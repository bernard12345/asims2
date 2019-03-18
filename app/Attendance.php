<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
	 protected $fillable = [
        'schedule_id','student_id', 'a_date', 'status',
    ];

    public function students()
    {
      return $this->belongsTo(Student::class,'student_id','id');
    }
 
    public function schedules()
    {
      return $this->belongsTo(Schedule::class,'schedule_id','id');
    }



    
}
