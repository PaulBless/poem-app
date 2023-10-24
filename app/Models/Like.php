<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';

    protected $fillable = [];

    // likes on the poem
    public function poem()
    {
        return $this->belongsTo(Poem::class);
    }

}
