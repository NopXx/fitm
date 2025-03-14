<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Personnel extends Model
{
    use HasFactory;

    protected $table = 'personnel'; // ระบุชื่อตารางให้ชัดเจน

    protected $fillable = [
        'board_id',
        'firstname_th',
        'lastname_th',
        'firstname_en',
        'lastname_en',
        'position_th',
        'position_en',
        'image',
        'display_order',
        'order_title_th',
        'order_title_en',
        'email',
        'phone',
        'is_active',
    ];

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    // ฟังก์ชันสำหรับดึงชื่อเต็มตามภาษาที่กำหนด
    public function getFullNameAttribute()
    {
        $locale = app()->getLocale();
        if ($locale == 'en' && $this->firstname_en && $this->lastname_en) {
            return $this->firstname_en . ' ' . $this->lastname_en;
        }
        return $this->firstname_th . ' ' . $this->lastname_th;
    }

    // ฟังก์ชันสำหรับดึงตำแหน่งตามภาษาที่กำหนด
    public function getPositionAttribute()
    {
        $locale = app()->getLocale();
        return $locale == 'en' && $this->position_en ? $this->position_en : $this->position_th;
    }

    // ฟังก์ชันสำหรับดึงชื่อลำดับตามภาษาที่กำหนด
    public function getOrderTitleAttribute()
    {
        $locale = app()->getLocale();
        return $locale == 'en' && $this->order_title_en ? $this->order_title_en : $this->order_title_th;
    }
}
