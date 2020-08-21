<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentsSetting extends Model
{
    protected $fillable = ['date', 'time',"status","setting_id","user_id"];
	protected $table="appointments_settings";
}
