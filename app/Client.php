<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    // Define the database table name associated with this model
    protected $table = 'client';

    // Define the primary key column of the client table
    protected $primaryKey = 'idclient';
}