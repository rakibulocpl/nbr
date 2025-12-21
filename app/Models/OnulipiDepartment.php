<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnulipiDepartment extends Model
{
    protected $fillable = [
        'archived_file_id',
        'department_id',
        'custom_department_name',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Each Onulipi belongs to one Archived File
    public function fileRepo()
    {
        return $this->belongsTo(FileRepo::class);
    }

    // Accessor to get display name
    public function getDisplayNameAttribute()
    {
        return $this->custom_department_name ?: ($this->department->name ?? '');
    }

    // Optional flag if ICT ministry
    public function getIsICTAttribute()
    {
        return $this->department;
    }
}
