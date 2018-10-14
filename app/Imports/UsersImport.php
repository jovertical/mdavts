<?php

namespace App\Imports;

/**
 * Application
 */
use App\User;
use Maatwebsite\Excel\Concerns\{ToModel, WithHeadingRow};
class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $user)
    {
        $user = array_values($user);
        
        return new User([
            'type' => 'user',
            'firstname' => $user[0],
            'middlename' => $user[1],
            'lastname' => $user[2],
            'birthdate' => $user[3],
            'gender' => $user[4],
            'address' => $user[5],
        ]);
    }
}
