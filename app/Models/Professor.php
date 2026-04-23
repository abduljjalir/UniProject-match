<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'email', 'code', 'image', 'speciality_id'
    ];

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    public function allocations()
{
    return $this->hasManyThrough(
        Allocation::class,
        Project::class,
        'professor_id', // projects.professor_id
        'project_id',   // allocations.project_id
        'id', 
        'id'
    );
}
protected static function boot()
{
    parent::boot();

    static::creating(function ($professor) {
        $professor->code = 'PROF-' . strtoupper(uniqid());
    });
}
}
