<?php

namespace App\Events;

use App\Http\Resources\SubtaskInfoResource;
use App\Http\Resources\TaskInfoResource;
use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubtaskAssignEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Subtask $subtask;

    /**
     * Create a new event instance.
     */
    public function __construct(Subtask $subtask)
    {
        $this->subtask = $subtask;
    }

    public function broadcastWith(): array
    {
        return [
            'data' => new SubtaskInfoResource($this->subtask)
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $teamLeaderId  = $this->subtask->task->project->team_leader_id;

        return [
            new PrivateChannel('subtask.user.' . $this->subtask->assigned_to), // we can use previous channel but not using here
            new PrivateChannel('subtask.user.' . $teamLeaderId),
        ];
    }
}

