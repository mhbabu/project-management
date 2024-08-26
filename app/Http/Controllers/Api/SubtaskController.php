<?php

namespace App\Http\Controllers\Api;

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
        $subtask = Subtask::create($request->validated());

        return new SubtaskResource($subtask);
    }

    public function show(Subtask $subtask)
    {
        return new SubtaskResource($subtask);
    }

    public function update(UpdateSubtaskRequest $request, Subtask $subtask)
    {
        $subtask->update($request->validated());

        return new SubtaskResource($subtask);
    }

    public function destroy(Subtask $subtask)
    {
        $subtask->delete();

        return response()->json(null, 204);
    }
}
