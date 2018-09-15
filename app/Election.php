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

    /**
     * @return string
     */
    public function getStatusClassAttribute()
    {
        switch ($this->status) {
            case 'upcoming':
                return 'warning';
            break;

            case 'active':
                return 'success';
            break;

            case 'closed':
                return 'danger';
            break;
        }
    }
}
