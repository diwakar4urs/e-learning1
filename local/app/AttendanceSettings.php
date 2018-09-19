<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceSettings extends Model
{
     ////////////////////////////
    //	Attendance Settings    //
    ////////////////////////////
    protected  $settings = array(
     'attendance_type'          => array(
     									'day' =>'Per Day', 
     									'subject'=>'Per Subject'
     									),
     'selected_attendance_type' => 'day',
     );

 /**
     * This method returns the settings related to  System
     * @param  boolean $key [For specific setting ]
     * @return [json]       [description]
     */
    public function getSettings($key = FALSE)
    {
    	if($key && array_key_exists($key,$settings))
    		return json_encode($this->settings[$key]);
    	return json_encode($this->settings);
    }
}
