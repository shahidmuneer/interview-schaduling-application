<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['employment', 'residence',"available_hours","good_fit"];
	protected $table="answers";
}
