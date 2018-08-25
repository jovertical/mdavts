<?php

namespace App;

use Spatie\BinaryUuid\HasBinaryUuid;
use Spatie\BinaryUuid\HasUuidPrimaryKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasBinaryUuid, HasUuidPrimaryKey;

    use SoftDeletes;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->firstname}, {$this->lastname}";
    }

    public function getFullNameFormalAttribute()
    {
        return "{$this->lastname}, {$this->firstname} {$this->middlename}.";
    }
}
