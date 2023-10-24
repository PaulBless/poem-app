<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Poem;

class LikeController extends Controller
{
    
    
    /**
     * Like a given poem.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Poem  $poem
     * @return \Illuminate\Http\Response
     */
    public function like(Request $request, Poem $poem)
    {
        // Check if the user has already liked the poem
        if ($poem->likes()->where('user_id', auth()->id())->count() === 0) {
            $like = Like::create([
                'user_id' => auth()->id(),
                'poem_id' => $poem->id,
            ]);

            return response()->json(['message' => 'Poem liked successfully', 'like' => $like])->setStatusCode(200);

        } else {
            return response()->json(['message' => 'You have already liked this poem'])->setStatusCode(403);
        }
    }

    /**
     * Unlike a poem
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Poem  $poem
     * @return \Illuminate\Http\Response
    */
    public function unlike(Request $request, Poem $poem)
    {
        // Find and delete the like if it exists
        $like = $poem->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Poem unliked successfully'])->setStatusCode(200);

        } else {
            return response()->json(['message' => 'You have not liked this poem']);
        }
    }

}
