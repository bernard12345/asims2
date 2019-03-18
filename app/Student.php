<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    // public function fullname($id)
    // {
    //   $student = Student::where('id',$id)->firstorfail();
    //   $name = $student->student_firstname + $student->student_middlename + $student->student_lastname; 
    //   return $name;
    // }
 // public $fillable = ['title','description'];//aysin para sa import 
   
   	public function attendances()
    {
      return $this->hasMany(Attendance::class,'student_id','id');
   	}
    
   	public function subjects()
    {
      return $this->BelongsToMany(Subject::class)->withPivot('section_id','batch','term','status');
   	}
    public function sections()
    {
      return $this->belongsToMany(Section::class);
    }
    public function mysections()
    {//hindi na ata to ginagamit
      return $this->belongsToMany(Section::class)->with('myschedules');
    }
    public function srfids()
    {
      return $this->hasone(Rfid::class,'secondary_id','student_id');
    }
    public function users()
    {
      return $this->hasone(User::class,'secondary_id','student_id');
    }

    public function followers()
    {
    return $this->belongsToMany(User::class)->withTimestamps();
    }
    
}
