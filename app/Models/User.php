<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens,HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'lastname',
        'cellphone',
        'email',
        'password',
        'department_id',
        'program_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function publications(){
        return $this->hasMany(Publication::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function groups(){
        return $this->belongsToMany(Group::class);
    }

    public function program(){
        return $this->belongsTo(Program::class);
    }

    public function seedlings(){
        return $this->belongsToMany(Seedling::class)->withPivot('status');
    }
}
