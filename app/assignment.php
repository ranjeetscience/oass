<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assignment extends Model
{
    protected $table='submitted';
    public $incrementing = false;
    public $timestamps = false;
}
