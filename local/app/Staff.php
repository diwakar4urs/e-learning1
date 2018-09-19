<?php

namespace App;
use App\User;
use App\Staff;
use App\GeneralSettings as Settings;
use Illuminate\Database\Eloquent\Model;
use DB;
class Staff extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function department()
    {
    	return $this->belongsTo('App\Department', 'department_id');
    }
    
    //
    public function prepareStaffID($userid)
    {
    	return (new Settings())->getStaffIDPrefix().$userid;
    }


}
