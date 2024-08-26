<?php

namespace App\Http\Controllers\Api;

use App\Events\TaskAssignedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{ 
    public function index(Request $request)
    {
        $tasks = Task::paginate($request->input('per_page', 15));
        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $currentUser = auth()->user();
        // Check if the current user is an admin or team-leader
        if ($currentUser->type !== 'admin' && $currentUser->type !== 'team-leader') {
            return response()->json([ 'message' => 'Unauthorized. Only admin or team-leader can assign tasks.'], 403);
        }

        // Set the assigned_by field to the current user
        $validatedData                = $request->validated();
        $validatedData['assigned_by'] = $currentUser->id;
        $validatedData['status']      = 'pending'; // Initial status for assigned_to required
        $task                         = Task::create($validatedData);

        if(!empty($task->assigned_to)){
            TaskAssignedEvent::dispatch($task);
        }
        
        return new TaskResource($task);
    }

    public function show($taskId)
    {
        $task = Task::find($taskId);
        if (!$task) return response()->json(['message' => 'Task not found.'], 404);
        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, $taskId)
    {
        $currentUser = auth()->user();
        $task = Task::find($taskId);

        if (!$task) return response()->json(['message' => 'Task not found.'], 404);

        // Check if the current user is an admin or team-leader
        if ($currentUser->type !== 'admin' && $currentUser->type !== 'team-leader') {
            return response()->json(['message' => 'Unauthorized. Only admin or team-leader can update tasks.'], 403);
        }

        // Update the task
        $validatedData    = $request->validated();
        $sameAssignedUser = $task->assigned_to === $validatedData['assigned_to'] ? true : false;
        $task->update($validatedData);

        if(!$sameAssignedUser){ // Dispatch Soket Message if assigned_to changed
            TaskAssignedEvent::dispatch($task);
        }

        return new TaskResource($task);
    }

    public function destroy($taskId)
    {
        $currentUser = auth()->user();
        $task = Task::find($taskId);

        if (!$task) return response()->json(['message' => 'Task not found.'], 404);

        // Check if the current user is an admin or team-leader
        if ($currentUser->type !== 'admin' && $currentUser->type !== 'team-leader') {
            return response()->json(['message' => 'Unauthorized. Only admin or team-leader can delete tasks.'], 403);
        }

        $task->delete();
        return response()->json([ 'message' => 'Task deleted successfully.'], 200);
    }
}
