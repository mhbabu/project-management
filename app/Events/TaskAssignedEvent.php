<?php

namespace App\Events;

use App\Http\Resources\TaskInfoResource;
use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskAssignedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Task $task;

    /**
     * Create a new event instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function broadcastWith(): array
    {
        return [
            'task' => new TaskInfoResource($this->task)
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $teamLeaderId  = $this->task->project->team_leader_id;

        return [
            new PrivateChannel('task.user.' . $this->task->assigned_to),
            new PrivateChannel('task.user.' . $teamLeaderId),
        ];
    }
}

