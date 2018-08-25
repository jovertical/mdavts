<?php

namespace App;

class Candidate extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid');
    }

    public function election()
    {
        return $this->belongsTo(Election::class, 'election_uuid');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_uuid');
    }
}
