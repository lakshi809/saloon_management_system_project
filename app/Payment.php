<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // Define the database table name associated with this model
    protected $table = 'payment';

    // Define the primary key column of the payment table
    protected $primaryKey = 'idpayment';


    // Define fields that can be assigned using mass assignment
    protected $fillable = [
        'appointment_idappointment',
        'amount'
    ];


    /**
     * Define relationship between Payment and Appointment.
     * Each payment belongs to one appointment.
     */
    public function appointment()
    {
        // Payment belongs to Appointment using appointment_idappointment foreign key
        return $this->belongsTo(
            Appointment::class,
            'appointment_idappointment',
            'idappointment'
        );
    }

}