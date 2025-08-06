<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    public function __construct(
        private ProjectService $projectService
    ) {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of projects.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'status' => 'sometimes|string|in:draft,active,on_hold,completed,cancelled',
            'client_id' => 'sometimes|integer|exists:clients,id',
            'is_featured' => 'sometimes|boolean',
            'search' => 'sometimes|string|max:255',
            'sort_by' => 'sometimes|string|in:title,created_at,updated_at,start_date,end_date',
            'sort_direction' => 'sometimes|string|in:asc,desc',
            'per_page' => 'sometimes|integer|min:1|max:100',
        ]);

        $projects = $this->projectService->getUserProjects(
            $request->user(),
            $request->all()
        );

        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created project.
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        try {
            $project = $this->projectService->createProject(
                $request->user(),
                $request->validated()
            );

            return response()->json([
                'message' => 'Project created successfully.',
                'project' => new ProjectResource($project),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create project.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified project.
     */
    public function show(Request $request, Project $project): JsonResponse
    {
        $this->authorize('view', $project);

        return response()->json([
            'project' => new ProjectResource($project->load(['client', 'timeEntries', 'invoices'])),
        ]);
    }

    /**
     * Update the specified project.
     */
    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $this->authorize('update', $project);

        try {
            $project = $this->projectService->updateProject($project, $request->validated());

            return response()->json([
                'message' => 'Project updated successfully.',
                'project' => new ProjectResource($project),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update project.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified project.
     */
    public function destroy(Project $project): JsonResponse
    {
        $this->authorize('delete', $project);

        try {
            $this->projectService->deleteProject($project);

            return response()->json([
                'message' => 'Project deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete project.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Upload project images.
     */
    public function uploadImages(Request $request, Project $project): JsonResponse
    {
        $this->authorize('update', $project);

        $request->validate([
            'images' => 'required|array|max:10',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ]);

        try {
            $project = $this->projectService->uploadProjectImages($project, $request->file('images'));

            return response()->json([
                'message' => 'Images uploaded successfully.',
                'project' => new ProjectResource($project),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to upload images.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove project image.
     */
    public function removeImage(Request $request, Project $project): JsonResponse
    {
        $this->authorize('update', $project);

        $request->validate([
            'image_path' => 'required|string',
        ]);

        try {
            $project = $this->projectService->removeProjectImage($project, $request->image_path);

            return response()->json([
                'message' => 'Image removed successfully.',
                'project' => new ProjectResource($project),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to remove image.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get public projects for portfolio.
     */
    public function portfolio(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'username' => 'required|string|exists:users,username',
            'per_page' => 'sometimes|integer|min:1|max:50',
        ]);

        $projects = $this->projectService->getPublicProjects(
            $request->username,
            $request->get('per_page', 12)
        );

        return ProjectResource::collection($projects);
    }
}