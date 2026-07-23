<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    // Define the database table name associated with this model
    protected $table = 'time_slot';

    // Define the primary key column of the time slot table
    protected $primaryKey = 'idtime_slot';

    // Disable automatic management of created_at and updated_at fields
    // because the table does not contain timestamp columns
    public $timestamps = false;
}