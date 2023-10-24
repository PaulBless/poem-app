<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class Poem extends Model
{
    use HasFactory;

    protected $table = 'poems';

    protected $fillable = [
        'title',
        'body',
    ];


    /**
     * Get total poems count of user
    */
    public function getTotalPoems($author_id) {
        
        try {
            
            $result = $this->where('author_id',$author_id)->count();
            if ($result > 0) {
                return $result;
            }

            return 0;

        } catch (QueryException $ex) {
            Log::info("PoemModel Error", ["getTotalPoems" => $ex->getMessage(), "line" => $ex->getLine()]);
            return 0;
        }
        
    }


    public function getPoem($author)
    {
        try {

            $result = $this->where('author_id',$author)->get();

            if (count($result) > 0) {
                return $result;
            }

            return null;

        } catch (QueryException $ex) {
            Log::info("PoemModel Error", ["getPoem" => $ex->getMessage(), "line" => $ex->getLine()]);
            return null;
        }
    }

    public function addPoem($title, $body, $genre_id, $author_id)
    {
        try {

            $this->title = $title;
            $this->body = $body;
            $this->genre_id = $genre_id;
            $this->author_id = $author_id;
            
            if ($this->save()) {
                return true;
            }

            return false;

        } catch (QueryException $ex) {
            Log::info("PoemModel Error", ["addPoem" => $ex->getMessage(), "line" => $ex->getLine()]);
            return false;
        }
    }

    public function getSinglePoem($id)
    {
        try {
            $result = $this->where('id', $id)->first();
            if (isset($result) & !empty($result)) {
                return $result;
            }
            return null;

        } catch (QueryException $ex) {
            Log::info("PoemModel Error", ["getSinglePoem" => $ex->getMessage(), "line" => $ex->getLine()]);
            return null;
        }
    }

    public function updatePoem($id, $title, $body, $genre)
    {
        try {
            $result = $this->where('id', $id)
                ->update(['title' => $title, 'body' => $body, 'genre_id' => $genre]);
            
                if ($result) {
                return true;
            }

            return false;

        } catch (QueryException $ex) {
            Log::info("PoemModel Error", ["updatePoem" => $ex->getMessage(), "line" => $ex->getLine()]);
            return false;
        }
    }

    public function deletePoem($id)
    {
        try {

            $result = $this->where('id', $id)->delete();
            if ($result) {
                return true;
            }

            return false;

        } catch (QueryException $ex) {
            Log::info("PoemModel Error", ["deletePoem" => $ex->getMessage(), "line" => $ex->getLine()]);
            return false;
        }
    }

    public function unpublishPoem() {

    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the comments for the poem.
    */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'poem_id', 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

}
