<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    /** @use HasFactory<\Database\Factories\RatingFactory> */
    use HasFactory;

    protected $fillable = [
        "comment",
        "stars"
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function movies()
    {
        return $this->belongsTo(Movie::class);
    }
}
