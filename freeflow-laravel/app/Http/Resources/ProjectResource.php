<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status,
            'status_color' => $this->status_color,
            'priority' => $this->priority,
            'priority_color' => $this->priority_color,
            'start_date' => $this->start_date?->format('Y-m-d'),
            'end_date' => $this->end_date?->format('Y-m-d'),
            'budget' => $this->budget,
            'hourly_rate' => $this->hourly_rate,
            'estimated_hours' => $this->estimated_hours,
            'actual_hours' => $this->actual_hours,
            'completion_percentage' => $this->completion_percentage,
            'images' => $this->images,
            'main_image_url' => $this->main_image_url,
            'tags' => $this->tags,
            'is_featured' => $this->is_featured,
            'is_public' => $this->is_public,
            'notes' => $this->notes,
            'total_earned' => $this->total_earned,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            
            // Relationships
            'client' => new ClientResource($this->whenLoaded('client')),
            'user' => new UserResource($this->whenLoaded('user')),
            'time_entries' => TimeEntryResource::collection($this->whenLoaded('timeEntries')),
            'invoices' => InvoiceResource::collection($this->whenLoaded('invoices')),
            
            // Counts
            'time_entries_count' => $this->whenCounted('timeEntries'),
            'invoices_count' => $this->whenCounted('invoices'),
        ];
    }
}