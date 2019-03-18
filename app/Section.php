<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{		
    public function courses()
    {
      return $this->belongsTo(Course::class,'course_id');
   	}
     public function schedules()
    {
      // NAHAPIN KUNG SAAN GINAMIT DI KO MAALALA 
     return $this->hasMany(Schedule::class,'section_id','id');
    }
    public function myschedules()
    {
      // NAHAPIN KUNG SAAN GINAMIT DI KO MAALALA 
      // burahin to 
     return $this->hasMany(Schedule::class,'section_id','id')->with('attendances');
    }

    public function mysschedules()
    {
      // NAHAPIN KUNG SAAN GINAMIT DI KO MAALALA 
      //hindi ata to nagana 
      return $this->belongsToMany(Schedule::class,'section_id','id')->with('attendances');
    }

     public function students()
    {
      // maramihan sila ni section many to many gumamit ng pivot table
     return $this->belongsToMany(Student::class);
    }

    public function studentpersections()
    {
      // NAHAPIN KUNG SAAN GINAMIT DI KO MAALALA 
      return $this->hasMany(Student::class,'section_id','id');
    }


     public function subjects()
    {
      return $this->belongsToMany(Subject::class)->withPivot('batch','term');
    }


}

