<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
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

    public function create(User $user)
    {
        // Authorize creation, e.g., check if the user has the right role or permission.
    }

    public function update(User $user, Comment $comment)
    {
        // Authorize updating, e.g., check if the user is the owner of the comment or has the right role or permission.
    }

    public function delete(User $user, Comment $comment)
    {
        // Authorize deletion, e.g., check if the user is the writer of the comment or has the right role or permission.
    }

}
