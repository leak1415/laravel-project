<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentManagement extends Model
{
    protected $table = 'student_management';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'student_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
