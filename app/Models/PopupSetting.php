<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopupSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'link',
        'image_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path
            ? ltrim($this->image_path, '/')
            : null;
    }
}
