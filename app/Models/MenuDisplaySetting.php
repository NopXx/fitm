<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuDisplaySetting extends Model
{
    protected $fillable = [
        'category_id',
        'is_visible',
        'show_dropdown',
        'css_class',
        'icon_url',
        'target'
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'show_dropdown' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class, 'category_id');
    }
}
