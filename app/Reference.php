<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $fillable = ['full_name_ref_1', 'phone_number_ref_1',"relationship_ref_1",
                            'full_name_ref_2', 'phone_number_ref_2',"relationship_ref_2",
                                'full_name_ref_3', 'phone_number_ref_3',"relationship_ref_3",];
	protected $table="refs";
}
