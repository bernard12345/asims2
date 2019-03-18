<?php

namespace App;
use App\Student;
use App\VerifyUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Inani\Larapoll\Traits\Voter;


class User extends Authenticatable
{
    use Voter;
    use Notifiable;

    protected $fillable = [
        'secondary_id','name', 'email', 'password','provider','provider_id','roles',
    ];

   
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function followers()
    {
    return $this->belongsToMany(Student::class)->withTimestamps();
    }





  
     public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }

    public function role()
    {
        return $this->belongsTo(Role::class,'roles','role_id');
    }

 
}
