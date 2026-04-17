<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function professors()
    {
        return $this->hasMany(Professor::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
