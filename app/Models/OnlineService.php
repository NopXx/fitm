<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineService extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_th',
        'title_en',
        'image',
        'link',
        'active',
        'order',
    ];

    protected $casts = [
        'active' => 'boolean',
        'order' => 'integer',
    ];
}
