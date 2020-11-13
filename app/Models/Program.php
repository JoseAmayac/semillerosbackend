<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'department_id',
        'coordinator_id'
    ];

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function students(){
        return $this->hasMany(User::class);
    }

    public function coordinator(){
        return $this->hasOne(User::class,'coordinator_id');
    }
}
