<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricalEvent extends Model
{
    protected $fillable = [
        'year',
        'title',
        'description',
        'image_path'
    ];

    protected $casts = [
        'year' => 'integer'
    ];
}
