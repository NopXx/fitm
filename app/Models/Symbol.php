<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Symbol extends Model
{
    protected $fillable = [
        'type',
        'name_th',
        'name_en',
        'description_th',
        'description_en',
        'image_path',
        'download_link',
        'rgb_code',
        'cmyk_code'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ค่าคงที่สำหรับประเภทของสัญลักษณ์
    const TYPE_UNIVERSITY_EMBLEM = 'university_emblem';
    const TYPE_UNIVERSITY_COLOR = 'university_color';
    const TYPE_UNIVERSITY_TREE = 'university_tree';
    const TYPE_FACULTY_LOGO = 'faculty_logo';

    // Scope สำหรับการ query ข้อมูลแต่ละประเภท
    public function scopeUniversityEmblem($query)
    {
        return $query->where('type', self::TYPE_UNIVERSITY_EMBLEM);
    }

    public function scopeUniversityColor($query)
    {
        return $query->where('type', self::TYPE_UNIVERSITY_COLOR);
    }

    public function scopeUniversityTree($query)
    {
        return $query->where('type', self::TYPE_UNIVERSITY_TREE);
    }

    public function scopeFacultyLogo($query)
    {
        return $query->where('type', self::TYPE_FACULTY_LOGO);
    }
}
