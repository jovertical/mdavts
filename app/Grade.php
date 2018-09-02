<?php

namespace App;

class Grade extends Model
{
    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
