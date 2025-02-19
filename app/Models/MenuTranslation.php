<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuTranslation extends Model
{
    protected $fillable = [
        'category_id',
        'language_code',
        'name',
        'url'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class, 'category_id');
    }
}
