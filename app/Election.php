<?php

namespace App;

class Election extends Model
{
    public function positions()
    {
        return $this->belongsToMany(Position::class);
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
