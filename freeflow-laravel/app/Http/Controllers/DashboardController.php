<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    ) {}

    /**
     * Get dashboard statistics.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $stats = $this->dashboardService->getDashboardStats($user);

            return response()->json([
                'stats' => $stats,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to load dashboard data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get recent activities.
     */
    public function recentActivities(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $activities = $this->dashboardService->getRecentActivities($user);

            return response()->json([
                'activities' => $activities,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to load recent activities.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get earnings chart data.
     */
    public function earningsChart(Request $request): JsonResponse
    {
        $request->validate([
            'period' => 'sometimes|string|in:week,month,quarter,year',
        ]);

        try {
            $user = $request->user();
            $period = $request->get('period', 'month');
            $chartData = $this->dashboardService->getEarningsChartData($user, $period);

            return response()->json([
                'chart_data' => $chartData,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to load earnings chart data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get time tracking summary.
     */
    public function timeTrackingSummary(Request $request): JsonResponse
    {
        $request->validate([
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
        ]);

        try {
            $user = $request->user();
            $startDate = $request->get('start_date', now()->startOfWeek());
            $endDate = $request->get('end_date', now()->endOfWeek());
            
            $summary = $this->dashboardService->getTimeTrackingSummary($user, $startDate, $endDate);

            return response()->json([
                'summary' => $summary,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to load time tracking summary.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}