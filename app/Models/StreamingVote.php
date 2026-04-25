<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class StreamingVote extends Model
{
    use HasFactory, HasApiTokens, SoftDeletes;

    protected $fillable = [
        "movie_id",
        "netflix",
        "disney",
        "hbo",
        "apple",
        "amazon"
    ];

    protected $dates = ['deleted_at'];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}