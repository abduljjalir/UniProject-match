<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'max_students',
        'required_points', 'professor_id', 'speciality_id'
    ];

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'project_skills')
                    ->withPivot('weight');
    }

    public function selections()
    {
        return $this->hasMany(Selection::class);
    }

    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }
}
