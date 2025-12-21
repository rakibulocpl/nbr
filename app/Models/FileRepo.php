<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class FileRepo extends Model
{
    use Searchable;
    protected $table = 'file_repo';
    protected $guarded = ['id'];

    public function statusInfo()
    {
        return $this->belongsTo(FileStatus::class, 'status');
    }

    public function onulipis()
    {
        return $this->hasMany(OnulipiDepartment::class,'file_id','id');
    }

    public function sender_department()
    {
        return $this->belongsTo(Department::class, 'sender_department_id');
    }

    public function receiver_department()
    {
        return $this->belongsTo(Department::class, 'receiver_department_id');
    }



}
