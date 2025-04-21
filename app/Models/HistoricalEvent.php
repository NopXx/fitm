<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricalEvent extends Model
{
    protected $fillable = [
        'year',
        'title_th',
        'title_en',
        'description_th',
        'description_en',
        'image_path'
    ];

    protected $casts = [
        'year' => 'integer'
    ];


}
