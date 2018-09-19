<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleHelper extends Model
{
    protected $table = 'modulehelper';
    
    public static function getRecord($key)
    {
    	return ModuleHelper::where('slug','=',$key)->first();
    }
}
