<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class login extends Model
{
    protected $table='login';
    protected $primaryKey = 'email_id';
    public $incrementing = false;
    public $timestamps = false;
}
