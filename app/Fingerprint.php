<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Fingerprint extends Model
{
     public function students()
    {
        return $this->hasOne(Student::class,'student_id','secondary_id');
    }
}
