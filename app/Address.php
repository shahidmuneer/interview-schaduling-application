<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['address_1', 'address_2',"city_town","state","zip_code"];
	protected $table="address";
}
