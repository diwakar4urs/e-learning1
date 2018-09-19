<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
     protected $table="publishers";
 
    public static function getRecordWithSlug($slug)
    {
        return Publisher::where('slug', '=', $slug)->first();
    }
}
