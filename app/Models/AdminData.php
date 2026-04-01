<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class AdminData extends Model
{
    use HasApiTokens;

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
