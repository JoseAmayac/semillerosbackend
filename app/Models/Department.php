<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function programs(){
        return $this->hasMany(Program::class);
    }

    public function groups(){
        return $this->hasMany(Group::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

}
