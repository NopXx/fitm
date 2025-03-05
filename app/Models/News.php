<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table = 'news';

    public function new_type()
    {
        // Assuming new_type in the news table is the foreign key
        // that references id in the new_type table
        return $this->belongsTo(NewType::class, 'new_type', 'id');
    }
}
