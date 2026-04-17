<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
     protected $fillable = ['name'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_skills');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_skills')
                    ->withPivot('weight');
    }
}
