<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table='appointment';
    protected $primaryKey='idappointment';


    public function Category(){
        //One Appointment belongsTo one Category
        return $this->belongsTo(Category::class,'category_idcategory');
    }


    public function User(){

        return $this->belongsTo(User::class,'master_user_idmaster_user');
    }


    public function TimeSlot(){

        return $this->belongsTo(TimeSlot::class,'time_slot_idtime_slot');
    }



    public function Payment(){

        return $this->hasOne(Payment::class,'appointment_idappointment');
    }

public function Feedback(){
    return $this->hasOne(\App\Feedback::class, 'appointment_idappointment');
}



//To get the stylist from the relationship between appointment and master_user tables.
    public function Stylist(){

        return $this->belongsTo(\App\User::class,'stylist_id');
    }

}