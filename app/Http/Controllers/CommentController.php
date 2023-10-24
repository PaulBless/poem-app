<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Poem;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //

    public function create(Request $request, Poem $poem)
    {
        // Validate request data
        $validatedData = $request->validate([
            'content' => 'required',
        ]);

        // Create a new comment
        $comment = Comment::create([
            'content' => $validatedData['content'],
            'user_id' => auth()->id(), // Set the user who created the comment
            'poem_id' => $poem->id,
        ]);

        return response()->json(['message' => 'Comment created successfully', 'comment' => $comment]);
    }


    public function update(Request $request, Comment $comment)
    {
        // Authorize the user
        $this->authorize('update', $comment);

        // Validate request data
        $validatedData = $request->validate([
            'content' => 'required',
        ]);

        // Update the comment
        $comment->update([
            'content' => $validatedData['content'],
        ]);

        return response()->json(['message' => 'Comment updated successfully', 'comment' => $comment]);
    }


}
