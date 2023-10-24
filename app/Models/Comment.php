<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    
    protected $fillable = [];




    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function poem()
    {
        return $this->belongsTo(Poem::class);
    }

    

}
