<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'professor_id', 'image', 'speciality_id'
    ];

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
