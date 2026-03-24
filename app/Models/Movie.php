<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    /** @use HasFactory<\Database\Factories\MovieFactory> */
    use HasFactory;

    protected $fillable = [
        "title",
        "genre",
        "plot",
        "releaseDate",
        "poster"
    ];

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'movie_id');
    }
}
