<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'status'      => $this->status,
            'assigned_to' => new UserResource($this->assignedTo),
            'assigned_by' => new UserResource($this->assignedBy),
            'subtasks'    => SubtaskResource::collection($this->subtasks),
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at
        ];
    }
}
