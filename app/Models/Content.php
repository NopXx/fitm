<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'title_th',
        'title_en',
        'detail_th',
        'detail_en'
    ];
}
