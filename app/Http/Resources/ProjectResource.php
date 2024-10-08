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
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'team_leader' => new UserInfoResource($this->teamLeader),
            'tasks'       => TaskResource::collection($this->tasks),
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at
        ];
    }
}
