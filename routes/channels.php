<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('task.user.{userId}', function (User $user, int $userId) {
    return $user->id === $userId ? $user : null;
});

Broadcast::channel('subtask.user.{userId}', function (User $user, int $userId) {
    return $user->id === $userId ? $user : null;
});