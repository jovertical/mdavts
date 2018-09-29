<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartyList extends Model
{
    
    public function partylist()
    {
        return $this->belongsTo(Candidate::class); 
    }
}
