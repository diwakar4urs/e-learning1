<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timingset extends Model
{
    protected $table = 'timingset';
 
    public function getPeriods()
    {
    	return $this->hasMany('App\TimingsetDetails','timingset_id')->get();
    }
}
