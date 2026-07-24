<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // Enable notification functionality for the user model
    use Notifiable;


    // Define the database table name associated with this model
    protected $table = 'master_user';


    // Define the primary key column of the user table
    protected $primaryKey = 'idmaster_user';


    // Disable automatic created_at and updated_at timestamp handling
    public $timestamps = false;


    // Define fields that can be assigned using mass assignment
    protected $fillable = [
        'user_name',
        'password',
        'role',
        'status',
        'first_name',
        'last_name',
        'dob',
        'contact_number',
        
    ];


    // Hide sensitive fields when converting model to array or JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Disable remember token functionality.
     * This project does not use Laravel remember me feature.
     */
    public function getRememberTokenName()
    {
        return null;
    }


    /**
     * Define relationship between User and UserRole.
     * Each user belongs to one user role.
     */
    public function UserRole()
    {
        // User belongs to UserRole using user_role_iduser_role foreign key
        return $this->belongsTo(
            \App\UserRole::class,
            'user_role_iduser_role',
            'iduser_role'
        );
    }

}