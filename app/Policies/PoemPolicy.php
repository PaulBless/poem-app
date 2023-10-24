<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Poem;
use Illuminate\Auth\Access\HandlesAuthorization;

class PoemPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // Authorize creation, e.g., check if the user has the right role or permission.
        return true;
    }

    /**
     * Determine if the given poem can be updated by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Poem  $poem
     * @return bool
    */
    public function update(User $user, Poem $poem)
    {
        // Authorize updating, e.g., check if the user is the owner of the poem or has the right role or permission.
        return $user->id === $poem->author_id;
    }

    /**
     * Determine if the given poem can be updated by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Poem  $poem
     * @return bool
    */
    public function delete(User $user, Poem $poem)
    {
        // Authorize deletion, e.g., check if the user is the owner of the poem or has the right role or permission.
        return $user->id === $poem->author_id;
    }

}
