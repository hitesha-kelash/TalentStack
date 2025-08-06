<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProjectService
{
    /**
     * Get user projects with filters.
     */
    public function getUserProjects(User $user, array $filters = []): LengthAwarePaginator
    {
        $query = $user->projects()->with(['client']);

        // Apply filters
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['client_id'])) {
            $query->where('client_id', $filters['client_id']);
        }

        if (isset($filters['is_featured'])) {
            $query->where('is_featured', $filters['is_featured']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereJsonContains('tags', $search);
            });
        }

        // Apply sorting
        $sortBy = $filters['sort_by'] ?? 'updated_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortBy, $sortDirection);

        $perPage = $filters['per_page'] ?? 15;
        return $query->paginate($perPage);
    }

    /**
     * Create a new project.
     */
    public function createProject(User $user, array $data): Project
    {
        $data['user_id'] = $user->id;
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        return Project::create($data);
    }

    /**
     * Update project.
     */
    public function updateProject(Project $project, array $data): Project
    {
        $project->update($data);
        return $project->fresh();
    }

    /**
     * Delete project.
     */
    public function deleteProject(Project $project): void
    {
        // Delete associated images
        if ($project->images) {
            foreach ($project->images as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $project->delete();
    }

    /**
     * Upload project images.
     */
    public function uploadProjectImages(Project $project, array $images): Project
    {
        $uploadedImages = [];
        $existingImages = $project->images ?? [];

        foreach ($images as $image) {
            $uploadedImages[] = $this->processAndStoreImage($image);
        }

        $project->update([
            'images' => array_merge($existingImages, $uploadedImages),
        ]);

        return $project->fresh();
    }

    /**
     * Remove project image.
     */
    public function removeProjectImage(Project $project, string $imagePath): Project
    {
        $images = $project->images ?? [];
        $images = array_filter($images, fn($img) => $img !== $imagePath);

        // Delete file from storage
        Storage::disk('public')->delete($imagePath);

        $project->update(['images' => array_values($images)]);
        return $project->fresh();
    }

    /**
     * Get public projects for portfolio.
     */
    public function getPublicProjects(string $username, int $perPage = 12): LengthAwarePaginator
    {
        $user = User::where('username', $username)->firstOrFail();

        return $user->projects()
            ->where('is_public', true)
            ->where('status', Project::STATUS_COMPLETED)
            ->orderBy('is_featured', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Process and store image.
     */
    private function processAndStoreImage(UploadedFile $image): string
    {
        $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
        $path = "projects/{$filename}";

        // Resize and optimize image
        $processedImage = Image::make($image)
            ->resize(1200, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('jpg', 85);

        // Store image
        Storage::disk('public')->put($path, $processedImage);

        // Create thumbnail
        $thumbnailPath = "projects/thumbnails/{$filename}";
        $thumbnail = Image::make($image)
            ->resize(400, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('jpg', 80);

        Storage::disk('public')->put($thumbnailPath, $thumbnail);

        return $path;
    }
}