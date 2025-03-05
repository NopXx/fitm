<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MenuCategory extends Model
{
    protected $table = 'menu_categories';

    protected $fillable = [
        'system_name',
        'parent_id',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class, 'parent_id');
    }

    // Remove the orderBy here - we'll apply it when loading
    public function children(): HasMany
    {
        return $this->hasMany(MenuCategory::class, 'parent_id');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(MenuTranslation::class, 'category_id');
    }

    public function displaySetting(): HasOne
    {
        return $this->hasOne(MenuDisplaySetting::class, 'category_id');
    }
}
