<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitmVideo extends Model
{
    use HasFactory;

    protected $table = 'fitm_videos';

    protected $fillable = [
        'name',
        'url',
        'is_important',
    ];

    protected $casts = [
        'is_important' => 'boolean',
    ];
}
