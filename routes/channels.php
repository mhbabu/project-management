<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('task.user.{userId}', function (User $user, int $userId) {
    info('hitting...');
    return $user->id === $userId ? $user : null;
});