<?php

namespace App\Actions\Jetstream;

use App\Models\Group;
use Laravel\Jetstream\Contracts\DeletesTeams;

class DeleteTeam implements DeletesTeams
{
    /**
     * Delete the given team.
     */
    public function delete(Group $team): void
    {
        $team->purge();
    }
}
