<?php

namespace App;
use App\Section;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
     public function sections()
    {
        return $this->hasMany(Section::class);
    }

    
}
