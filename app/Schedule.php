<?php

namespace App;
use App\Professor;
use App\Schedule;
use App\Section;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Schedule extends Model
{

    public function sections()
    {
      return $this->belongsTo(Section::class,'section_id','id');
   	}
   	
   	public function professors()
    {
      return $this->belongsTo(Professor::class,'professor_id','id');
   	}

   	public function subjects()
    {
      return $this->belongsTo(Subject::class,'subject_id','id');
   	}

    public function attendances()
    {
      return $this->hasMany(Attendance::class,'schedule_id','id');
    }

  
}
