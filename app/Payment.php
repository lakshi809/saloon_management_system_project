<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $table = 'payment';

    protected $primaryKey = 'idpayment';


    protected $fillable = [
        'appointment_idappointment',
        'amount'
    ];


    public function appointment()
    {
        return $this->belongsTo(Appointment::class,
            'appointment_idappointment',
            'idappointment'
        );
    }

}