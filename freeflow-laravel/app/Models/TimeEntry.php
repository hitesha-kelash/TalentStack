<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'project_id',
        'client_id',
        'description',
        'start_time',
        'end_time',
        'duration',
        'hourly_rate',
        'is_billable',
        'is_invoiced',
        'tags',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'duration' => 'integer', // in minutes
            'hourly_rate' => 'decimal:2',
            'is_billable' => 'boolean',
            'is_invoiced' => 'boolean',
            'tags' => 'array',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($entry) {
            if ($entry->start_time && $entry->end_time) {
                $entry->duration = $entry->start_time->diffInMinutes($entry->end_time);
            }
        });
    }

    /**
     * Get the user that owns the time entry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the project associated with the time entry.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the client associated with the time entry.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get duration in hours.
     */
    public function getDurationInHoursAttribute(): float
    {
        return round($this->duration / 60, 2);
    }

    /**
     * Get formatted duration (e.g., "2h 30m").
     */
    public function getFormattedDurationAttribute(): string
    {
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours}h {$minutes}m";
        } elseif ($hours > 0) {
            return "{$hours}h";
        } else {
            return "{$minutes}m";
        }
    }

    /**
     * Calculate earnings for this time entry.
     */
    public function getEarningsAttribute(): float
    {
        if (!$this->is_billable || !$this->hourly_rate) {
            return 0;
        }

        return $this->duration_in_hours * $this->hourly_rate;
    }

    /**
     * Check if time entry is currently running.
     */
    public function getIsRunningAttribute(): bool
    {
        return $this->start_time && !$this->end_time;
    }

    /**
     * Stop the time entry.
     */
    public function stop(): void
    {
        if ($this->is_running) {
            $this->update(['end_time' => now()]);
        }
    }

    /**
     * Scope a query to only include billable entries.
     */
    public function scopeBillable($query)
    {
        return $query->where('is_billable', true);
    }

    /**
     * Scope a query to only include non-invoiced entries.
     */
    public function scopeNotInvoiced($query)
    {
        return $query->where('is_invoiced', false);
    }

    /**
     * Scope a query to only include running entries.
     */
    public function scopeRunning($query)
    {
        return $query->whereNotNull('start_time')->whereNull('end_time');
    }

    /**
     * Scope a query for entries within a date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('start_time', [$startDate, $endDate]);
    }
}