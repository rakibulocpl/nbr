<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    public function desks()
    {
        return $this->belongsToMany(Desk::class, 'department_desk', 'department_id', 'desk_id');
    }

}
