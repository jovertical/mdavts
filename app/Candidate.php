<?php

namespace App;

use DB;

class Candidate extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function election()
    {
        return $this->belongsTo(Election::class, 'election_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function party_list()
    {
        return $this->belongsTo(PartyList::class, 'partylist_id');
    }

    public function getWinnerAttribute()
    {
        return DB::table('election_winners')
            ->where('election_id', $this->election->id)
            ->where('candidate_id', $this->id)
            ->count() > 0;
    }
}
