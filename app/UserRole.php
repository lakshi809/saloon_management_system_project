<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    // Define the database table name associated with this model
    protected $table = 'user_role';


    // Define the primary key column of the user_role table
    protected $primaryKey = 'iduser_role';



    /**
     * Define relationship between UserRole and User.
     * One user role can have many users.
     */
    public function User()
    {
        // UserRole has many users using role foreign key
        return $this->hasMany(
            User::class,
            'role'
        );
    }

}