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
        'department_name_th'
    ];

    public function content()
    {
        return $this->hasOne(DepartmentContent::class, 'department_id');
    }
}
