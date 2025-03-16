<?php
use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

Broadcast::channel('chat.{userId}', function (User $user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('online', function (User $user) {
    return ['id' => $user->id, 'name' => $user->name];
});

Broadcast::channel('team.{teamId}', function (User $user, $teamId) {
    return $user->teams()->where('teams.id', $teamId)->exists();
});
