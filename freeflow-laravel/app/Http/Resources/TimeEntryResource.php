<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeEntryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'start_time' => $this->start_time?->format('Y-m-d H:i:s'),
            'end_time' => $this->end_time?->format('Y-m-d H:i:s'),
            'duration' => $this->duration, // in minutes
            'duration_in_hours' => $this->duration_in_hours,
            'formatted_duration' => $this->formatted_duration,
            'hourly_rate' => $this->hourly_rate,
            'earnings' => $this->earnings,
            'is_billable' => $this->is_billable,
            'is_invoiced' => $this->is_invoiced,
            'is_running' => $this->is_running,
            'tags' => $this->tags,
            'notes' => $this->notes,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            
            // Relationships
            'project' => new ProjectResource($this->whenLoaded('project')),
            'client' => new ClientResource($this->whenLoaded('client')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}