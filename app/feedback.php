<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    // Define the database table name associated with this model
    protected $table = 'feedback';

    // Define the primary key column of the feedback table
    protected $primaryKey = 'idfeedback';


    // Define fields that can be mass assigned
    protected $fillable = [
        'appointment_idappointment',
        'master_user_idmaster_user',
        'rating',
        'comment',
        'is_published'
    ];


    /**
     * Define relationship between Feedback and User.
     * Each feedback belongs to one user/client.
     */
    public function user()
    {
        // Feedback belongs to User through master_user_idmaster_user foreign key
        return $this->belongsTo(
            User::class,
            'master_user_idmaster_user',
            'idmaster_user'
        );
    }


    /**
     * Define relationship between Feedback and Appointment.
     * Each feedback belongs to one appointment.
     */
    public function appointment()
    {
        // Feedback belongs to Appointment through appointment_idappointment foreign key
        return $this->belongsTo(
            Appointment::class,
            'appointment_idappointment',
            'idappointment'
        );
    }
}