<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with('teamLeader', 'tasks')->paginate($request->input('per_page', 15));
        return ProjectResource::collection($projects);
    }

    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->validated());

        return new ProjectResource($project);
    }

    public function show(Project $project)
    {
        $project->load('teamLeader', 'tasks.subtasks'); // Eager load related data
        return new ProjectResource($project);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());

        return new ProjectResource($project);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json(null, 204);
    }
}
