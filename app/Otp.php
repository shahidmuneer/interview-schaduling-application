<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = ['user_id', 'mobile_number',"code","token"];
	protected $table="otps";
}
