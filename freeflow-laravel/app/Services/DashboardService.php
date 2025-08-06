<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * Get dashboard statistics for user.
     */
    public function getDashboardStats(User $user): array
    {
        $currentMonth = now()->startOfMonth();
        $lastMonth = now()->subMonth()->startOfMonth();

        return [
            'projects' => [
                'total' => $user->projects()->count(),
                'active' => $user->projects()->where('status', Project::STATUS_ACTIVE)->count(),
                'completed' => $user->projects()->where('status', Project::STATUS_COMPLETED)->count(),
                'this_month' => $user->projects()->where('created_at', '>=', $currentMonth)->count(),
            ],
            'clients' => [
                'total' => $user->clients()->count(),
                'active' => $user->clients()->where('is_active', true)->count(),
                'this_month' => $user->clients()->where('created_at', '>=', $currentMonth)->count(),
            ],
            'invoices' => [
                'total' => $user->invoices()->count(),
                'paid' => $user->invoices()->where('status', Invoice::STATUS_PAID)->count(),
                'pending' => $user->invoices()->where('status', Invoice::STATUS_SENT)->count(),
                'overdue' => $user->invoices()->overdue()->count(),
                'this_month' => $user->invoices()->where('created_at', '>=', $currentMonth)->count(),
            ],
            'earnings' => [
                'total' => $user->invoices()->where('status', Invoice::STATUS_PAID)->sum('total_amount'),
                'this_month' => $user->invoices()
                    ->where('status', Invoice::STATUS_PAID)
                    ->where('paid_date', '>=', $currentMonth)
                    ->sum('total_amount'),
                'last_month' => $user->invoices()
                    ->where('status', Invoice::STATUS_PAID)
                    ->whereBetween('paid_date', [$lastMonth, $currentMonth])
                    ->sum('total_amount'),
                'outstanding' => $user->invoices()->unpaid()->sum('total_amount'),
            ],
            'time_tracking' => [
                'total_hours' => $user->timeEntries()->sum('duration') / 60, // Convert minutes to hours
                'this_week' => $user->timeEntries()
                    ->whereBetween('start_time', [now()->startOfWeek(), now()->endOfWeek()])
                    ->sum('duration') / 60,
                'billable_hours' => $user->timeEntries()->billable()->sum('duration') / 60,
                'running_entries' => $user->timeEntries()->running()->count(),
            ],
        ];
    }

    /**
     * Get recent activities for user.
     */
    public function getRecentActivities(User $user, int $limit = 10): array
    {
        $activities = [];

        // Recent projects
        $recentProjects = $user->projects()
            ->latest()
            ->limit(3)
            ->get(['id', 'title', 'status', 'created_at', 'updated_at']);

        foreach ($recentProjects as $project) {
            $activities[] = [
                'type' => 'project',
                'action' => $project->wasRecentlyCreated ? 'created' : 'updated',
                'title' => "Project: {$project->title}",
                'description' => "Status: {$project->status}",
                'timestamp' => $project->updated_at,
                'url' => "/projects/{$project->id}",
            ];
        }

        // Recent invoices
        $recentInvoices = $user->invoices()
            ->latest()
            ->limit(3)
            ->get(['id', 'invoice_number', 'status', 'total_amount', 'created_at', 'updated_at']);

        foreach ($recentInvoices as $invoice) {
            $activities[] = [
                'type' => 'invoice',
                'action' => $invoice->wasRecentlyCreated ? 'created' : 'updated',
                'title' => "Invoice: {$invoice->invoice_number}",
                'description' => "Amount: \${$invoice->total_amount} - Status: {$invoice->status}",
                'timestamp' => $invoice->updated_at,
                'url' => "/invoices/{$invoice->id}",
            ];
        }

        // Recent time entries
        $recentTimeEntries = $user->timeEntries()
            ->with('project')
            ->latest()
            ->limit(4)
            ->get(['id', 'project_id', 'description', 'duration', 'created_at']);

        foreach ($recentTimeEntries as $entry) {
            $activities[] = [
                'type' => 'time_entry',
                'action' => 'logged',
                'title' => "Time logged: {$entry->formatted_duration}",
                'description' => $entry->project ? "Project: {$entry->project->title}" : $entry->description,
                'timestamp' => $entry->created_at,
                'url' => "/time-tracking",
            ];
        }

        // Sort by timestamp and limit
        usort($activities, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);

        return array_slice($activities, 0, $limit);
    }

    /**
     * Get earnings chart data.
     */
    public function getEarningsChartData(User $user, string $period = 'month'): array
    {
        $query = $user->invoices()->where('status', Invoice::STATUS_PAID);

        switch ($period) {
            case 'week':
                $startDate = now()->subWeeks(12)->startOfWeek();
                $groupBy = "DATE_FORMAT(paid_date, '%Y-%u')";
                $dateFormat = 'Y-W';
                break;
            case 'quarter':
                $startDate = now()->subQuarters(4)->startOfQuarter();
                $groupBy = "CONCAT(YEAR(paid_date), '-Q', QUARTER(paid_date))";
                $dateFormat = 'Y-\QQ';
                break;
            case 'year':
                $startDate = now()->subYears(5)->startOfYear();
                $groupBy = "YEAR(paid_date)";
                $dateFormat = 'Y';
                break;
            default: // month
                $startDate = now()->subMonths(12)->startOfMonth();
                $groupBy = "DATE_FORMAT(paid_date, '%Y-%m')";
                $dateFormat = 'Y-m';
                break;
        }

        $earnings = $query
            ->where('paid_date', '>=', $startDate)
            ->select(
                DB::raw("{$groupBy} as period"),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        return [
            'labels' => $earnings->pluck('period')->toArray(),
            'data' => $earnings->pluck('total')->toArray(),
            'period' => $period,
        ];
    }

    /**
     * Get time tracking summary.
     */
    public function getTimeTrackingSummary(User $user, string $startDate, string $endDate): array
    {
        $timeEntries = $user->timeEntries()
            ->whereBetween('start_time', [$startDate, $endDate])
            ->with('project')
            ->get();

        $totalMinutes = $timeEntries->sum('duration');
        $billableMinutes = $timeEntries->where('is_billable', true)->sum('duration');
        $totalEarnings = $timeEntries->where('is_billable', true)->sum('earnings');

        // Group by project
        $projectSummary = $timeEntries->groupBy('project_id')->map(function ($entries, $projectId) {
            $project = $entries->first()->project;
            return [
                'project' => $project ? $project->title : 'No Project',
                'total_minutes' => $entries->sum('duration'),
                'total_hours' => round($entries->sum('duration') / 60, 2),
                'billable_minutes' => $entries->where('is_billable', true)->sum('duration'),
                'billable_hours' => round($entries->where('is_billable', true)->sum('duration') / 60, 2),
                'earnings' => $entries->where('is_billable', true)->sum('earnings'),
            ];
        })->values();

        // Group by day
        $dailySummary = $timeEntries->groupBy(function ($entry) {
            return $entry->start_time->format('Y-m-d');
        })->map(function ($entries, $date) {
            return [
                'date' => $date,
                'total_minutes' => $entries->sum('duration'),
                'total_hours' => round($entries->sum('duration') / 60, 2),
                'billable_minutes' => $entries->where('is_billable', true)->sum('duration'),
                'billable_hours' => round($entries->where('is_billable', true)->sum('duration') / 60, 2),
                'earnings' => $entries->where('is_billable', true)->sum('earnings'),
            ];
        })->values();

        return [
            'summary' => [
                'total_hours' => round($totalMinutes / 60, 2),
                'billable_hours' => round($billableMinutes / 60, 2),
                'non_billable_hours' => round(($totalMinutes - $billableMinutes) / 60, 2),
                'total_earnings' => $totalEarnings,
                'average_hourly_rate' => $billableMinutes > 0 ? round($totalEarnings / ($billableMinutes / 60), 2) : 0,
            ],
            'by_project' => $projectSummary,
            'by_day' => $dailySummary,
        ];
    }
}