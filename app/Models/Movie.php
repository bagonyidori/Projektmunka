<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    /** @use HasFactory<\Database\Factories\MovieFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "tmdb_id",
        "title",
        "genre",
        "plot",
        "releaseDate",
        "poster"
    ];

    protected $dates = ['deleted_at'];

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'movie_id');
    }
}
