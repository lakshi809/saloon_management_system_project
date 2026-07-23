<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    // Database table name
    protected $table='appointment';

    // Primary key of the appointment table
    protected $primaryKey='idappointment';


    // One Appointment belongs to one Category
    public function Category(){

        return $this->belongsTo(Category::class,'category_idcategory');
    }


    // One Appointment belongs to one User (Client)
    public function User(){

        return $this->belongsTo(User::class,'master_user_idmaster_user');
    }


    // One Appointment belongs to one Time Slot
    public function TimeSlot(){

        return $this->belongsTo(TimeSlot::class,'time_slot_idtime_slot');
    }


    // One Appointment has one Payment
    public function Payment(){

        return $this->hasOne(Payment::class,'appointment_idappointment');
    }


    // One Appointment has one Feedback
    public function Feedback(){

        return $this->hasOne(\App\Feedback::class, 'appointment_idappointment');
    }


    // One Appointment belongs to one Stylist (Staff User)
    // Relationship between appointment table and master_user table
    public function Stylist(){

        return $this->belongsTo(\App\User::class,'stylist_id');
    }

}