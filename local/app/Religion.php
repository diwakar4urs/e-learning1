<?php

namespace App;

use DB;

use Illuminate\Database\Eloquent\Model;


class Religion extends Model
{

    protected $fillable=[
        'religion_name',
        'status'
    ];

}
