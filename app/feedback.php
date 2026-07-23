<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';
    protected $primaryKey = 'idfeedback';

    protected $fillable = [
        'appointment_idappointment',
        'master_user_idmaster_user',
        'rating',
        'comment',
        'is_published'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_idappointment', 'idappointment');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'master_user_idmaster_user', 'idmaster_user');
    }
}