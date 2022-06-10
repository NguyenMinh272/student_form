<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;


    protected $table = 'students';
    protected $fillable = [
        'full_name',
        'address',
        'email',
        'social_id',
        'birthday',
        'gender',
        'phone',
        'image',
        'faculty_id',
        'password'
    ];

    public static $upload_dir = 'images';

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'id', 'id');
    }

    public function studentSubject()
    {
        return $this->belongsTo(StudentSubject::class,'id','student_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subjects', 'student_id', 'subject_id')
            ->withPivot('mark');
    }



}
