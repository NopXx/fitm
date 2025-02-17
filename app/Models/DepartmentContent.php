<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartmentContent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'department_id',
        'overview',
        'meta_title',
        'meta_description',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    public function department()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }
}
