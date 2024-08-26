<?php

namespace App\Http\Controllers\Api;

use App\Events\SubtaskAssignEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subtask\StoreSubtaskRequest;
use App\Http\Requests\Subtask\UpdateSubtaskRequest;
use App\Http\Resources\SubtaskResource;
use App\Models\Subtask;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    public function index(Request $request)
    {
        $subtasks = Subtask::paginate($request->input('per_page', 15));
        return SubtaskResource::collection($subtasks);
    }

    public function store(StoreSubtaskRequest $request)
    {
        $currentUser = auth()->user();
        // Check if the current user is an admin or team-leader
        if ($currentUser->type !== 'admin' && $currentUser->type !== 'team-leader') {
            return response()->json([ 'message' => 'Unauthorized. Only admin or team-leader can assign subtasks.'], 403);
        }

        // Set the assigned_by field to the current user
        $validatedData                = $request->validated();
        $validatedData['assigned_by'] = $currentUser->id;
        $validatedData['status']      = 'pending'; // Initial status for assigned_to required
        $subtask                      = Subtask::create($validatedData);

        if(!empty($subtask->assigned_to)){
            SubtaskAssignEvent::dispatch($subtask);
        }

        return new SubtaskResource($subtask);
    }

    public function show($subtaskId)
    {
        $subtask = Subtask::find($subtaskId);
        if (!$subtask) return response()->json(['message' => 'Subtask not found.'], 404);
        return new SubtaskResource($subtask);
    }

    public function update(UpdateSubtaskRequest $request, $subtaskId)
    {
        $currentUser = auth()->user();
        $subtask = Subtask::find($subtaskId);

        if (!$subtask) return response()->json(['message' => 'Subtask not found.'], 404);

        // Check if the current user is an admin or team-leader
        if ($currentUser->type !== 'admin' && $currentUser->type !== 'team-leader') {
            return response()->json(['message' => 'Unauthorized. Only admin or team-leader can update tasks.'], 403);
        }

        $validatedData    = $request->validated();
        $sameAssignedUser = $subtask->assigned_to === $validatedData['assigned_to'] ? true : false;
        $subtask->update($validatedData);

        if(!$sameAssignedUser){ // Dispatch Soket Message if assigned_to changed
            SubtaskAssignEvent::dispatch($subtask);
        }

        return new SubtaskResource($subtask);
    }

    public function destroy($subtaskId)
    {
        $currentUser = auth()->user();
        $subtask     = Subtask::find($subtaskId);

        if (!$subtask) return response()->json(['message' => 'Subtask not found.'], 404);

        // Check if the current user is an admin or team-leader
        if ($currentUser->type !== 'admin' && $currentUser->type !== 'team-leader') {
            return response()->json(['message' => 'Unauthorized. Only admin or team-leader can delete tasks.'], 403);
        }

        $subtask->delete();
        return response()->json([ 'message' => 'Subtask deleted successfully.'], 200);
    }
}
