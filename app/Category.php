<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Define the database table name related to this model
    protected $table = 'category';

    // Define the primary key column of the category table
    protected $primaryKey = 'idcategory';


    /**
     * Define relationship between Category and Appointment.
     * One category can have many appointments.
     */
    public function Appointment()
    {
        // Category has many appointments through category_id foreign key
        return $this->hasMany(Appointment::class, 'category_id');
    }

}