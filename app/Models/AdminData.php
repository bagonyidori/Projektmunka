<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminData extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'daily_last_update',
        'trending_last_update',
    ];

    protected $casts = [
    'daily_last_update' => 'datetime',
    'trending_last_update' => 'datetime',
    ];

    protected $dates = ['deleted_at'];
}
