<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    use HasFactory;

    protected $fillable = [
        'board_name_th',
        'board_name_en',
        'display_order',
        'is_active',
    ];

    public function personnel(): HasMany
    {
        return $this->hasMany(Personnel::class);
    }

    // ฟังก์ชันสำหรับดึงชื่อตามภาษาที่กำหนด
    public function getBoardNameAttribute()
    {
        $locale = app()->getLocale();
        return $locale == 'en' && $this->board_name_en ? $this->board_name_en : $this->board_name_th;
    }
}
