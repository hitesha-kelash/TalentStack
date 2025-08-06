<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'company' => $this->company,
            'website' => $this->website,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'postal_code' => $this->postal_code,
            'full_address' => $this->full_address,
            'notes' => $this->notes,
            'avatar' => $this->avatar,
            'avatar_url' => $this->avatar_url,
            'is_active' => $this->is_active,
            'preferred_contact_method' => $this->preferred_contact_method,
            'timezone' => $this->timezone,
            'total_earned' => $this->total_earned,
            'total_outstanding' => $this->total_outstanding,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            
            // Relationships
            'projects' => ProjectResource::collection($this->whenLoaded('projects')),
            'invoices' => InvoiceResource::collection($this->whenLoaded('invoices')),
            'time_entries' => TimeEntryResource::collection($this->whenLoaded('timeEntries')),
            
            // Counts
            'projects_count' => $this->whenCounted('projects'),
            'invoices_count' => $this->whenCounted('invoices'),
            'time_entries_count' => $this->whenCounted('timeEntries'),
        ];
    }
}