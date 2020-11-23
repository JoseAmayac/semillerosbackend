<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'department_id'
    ];

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function seedlings(){
        return $this->hasMany(Seedling::class);
    }

    public function lines(){
        return $this->hasMany(Line::class);
    }

    public function publications(){
        return $this->hasMany(Publication::class);
    }

    public function teachers(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
