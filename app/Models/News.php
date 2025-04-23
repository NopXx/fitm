<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'news';

    protected $fillable = [
        'no',
        'title_th',
        'title_en',
        'display_type',
        'new_type',
        'detail_th',
        'detail_en',
        'content_th',
        'content_en',
        'cover',
        'effective_date',
        'view_count',
        'link',
        'status',
        'is_important',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $dates = [
        'effective_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Get dynamic attributes based on current language
    public function getTitleAttribute()
    {
        $lang = app()->getLocale();
        return $lang == 'en' ? ($this->title_en ?: null) : ($this->title_th ?: null);
    }

    public function getDetailAttribute()
    {
        $lang = app()->getLocale();
        return $lang == 'en' ? ($this->detail_en ?: null) : ($this->detail_th ?: null);
    }

    public function getContentAttribute()
    {
        $lang = app()->getLocale();
        return $lang == 'en' ? ($this->content_en ?: null) : ($this->content_th ?: null);
    }

    public function new_type()
    {
        return $this->belongsTo(NewType::class, 'new_type', 'id');
    }
}