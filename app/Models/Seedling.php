<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seedling extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'group_id',
        'teacher_id'
    ];

    protected $hidden = ['users'];

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)->select(['program_id', 'name', 'email', 'lastname', 'users.id', 'department_id'])->withPivot('status');
    }
}
