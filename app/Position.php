<?php

namespace App;

class Position extends Model
{
    public function elections()
    {
        return $this->belongsToMany(Election::class);
    }
}