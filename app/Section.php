<?php

namespace App;

class Section extends Model
{
   public function grade() 
   {
       return $this->belongsTo(Grade::class, 'grade_uuid');
   }
}
