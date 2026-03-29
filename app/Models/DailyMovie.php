<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyMovie extends Model
{
    protected $fillable = ['movie_id', 'date'];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
