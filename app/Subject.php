<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Schedule;

class Subject extends Model
{
     public function schedules()
    {
      return $this->hasMany(Schedule::class,'subject_id','id');
    }

    public function insertattend()
    {
      return $this->belongsToMany(Student::class);
      //ginamit ito doon sa cronjob sa pag iinsert ng attendance
    }
    public function sections()
    {
    	return $this->belongsToMany(Section::class,'subject_id','section_id')->withPivot('batch','term');
    }


    public function students()
    {
      //para makita din yung laman doon sa pivot table s
      return $this->belongsToMany(Student::class)->withPivot('section_id','batch','term','status');
    }
     public function studentss($q,$id)
    {
      //para makita din yung laman doon sa pivot table s
      $schedule = Schedule::where('id',$id)->first();
      return $this->belongsToMany(Student::class)->withPivot('section_id','batch','term')
                                                 ->wherepivot('term',$schedule->term)
                                                 ->wherepivot('batch',$schedule->batch);
    }



    public function srfids()
    {
      return $this->hasone(Rfid::class,'secondary_id','student_id');
    }
}
