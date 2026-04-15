<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Movie extends Model
{
    /** @use HasFactory<\Database\Factories\MovieFactory> */
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = [
        "tmdb_id",
        "title",
        "genre",
        "plot",
        "releaseDate",
        "poster",
        "deleted_at"
    ];

    protected $dates = ['deleted_at'];

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'movie_id');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'movie_user');
    }

    public function getIsFavoriteAttribute()
    {
        if (!auth()->check())
            return false;

        return $this->favoritedBy()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function dailySelections()
    {
        return $this->hasMany(DailyMovie::class);
    }

    public function getAverageRatingAttribute()
    {
        if ($this->relationLoaded('ratings')) {
            return $this->ratings->avg('stars') ?? 0;
        }
        
        return $this->ratings()->avg('stars') ?? 0;
    }
}
