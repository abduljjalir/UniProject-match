<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'student_id', 'image', 'cgpa', 'speciality_id'
    ];

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }

    public function skills()
    {
        return $this->belongsToMany(
            Skill::class,
            'student_skills',
            'student_id',
            'skill_id'
        );
    }

    public function selections()
    {
        return $this->hasMany(Selection::class);
    }

    public function allocation()
    {
        return $this->hasOne(Allocation::class);
    }
}