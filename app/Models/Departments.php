<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departments extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'department_code',
        'department_name_th',
        'department_name_en',
        'overview_th',
        'overview_en',
        'status'
    ];

    /**
     * Get the content associated with the department.
     *
     * @deprecated This relationship will be removed after data migration
     */
    public function content()
    {
        return $this->hasOne(DepartmentContent::class, 'department_id');
    }

    /**
     * Check if the department is published.
     *
     * @return bool
     */
    public function isPublished()
    {
        return $this->status === 'published';
    }
}