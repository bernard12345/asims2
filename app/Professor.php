<?php

namespace App;
use App\Schedule;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{

	 protected $fillable = [
        
        'title',
        'fname',
        'mname',
        'lname',
        'email',
        'gender',
        'contact',
    ];



    public function schedules()
    {
      return $this->hasMany(Schedule::class,'professor_id','id');
   	}


    public function prfids()
    {
      return $this->hasone(Rfid::class,'secondary_id','professor_id');
    }

    
}
?>