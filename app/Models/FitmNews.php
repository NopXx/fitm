<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class FitmNews extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fitm_news';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'issue_name',
        'title_th',
        'title_en',
        'url',
        'published_date',
        'cover_image',
        'description_th',
        'description_en',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'published_date' => 'date',
        'is_featured' => 'boolean',
    ];

    public function getTitleAttribute()
    {
        $lang = app()->getLocale();
        return $lang == 'en' ? ($this->title_en ?: null) : ($this->title_th ?: null);
    }

    public function getDescriptionAttribute()
    {
        $lang = app()->getLocale();
        return $lang == 'en' ? ($this->description_en ?: null) : ($this->description_th ?: null);
    }

    /**
     * Scope a query to only include news from a specific issue.
     *
     * @param Builder $query
     * @param string $issueName
     * @return Builder
     */
    public function scopeOfIssue(Builder $query, string $issueName): Builder
    {
        return $query->where('issue_name', $issueName);
    }
}