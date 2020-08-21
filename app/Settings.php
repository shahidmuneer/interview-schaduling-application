<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = ['from_date', 'to_date',"from_time","to_time","hours"];
	protected $table="settings";
}
