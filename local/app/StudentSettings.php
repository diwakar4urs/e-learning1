<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentSettings extends Model
{
    //
    
    protected $settings = array(
    								'prefix'  => 'ACASTU',
    								'admission_no_length' => 5,
    								'roll_no_length' => 5,
    								'saperator' => '-',
    							);

    
    protected $studentAdmissionNoLength = 5;
    protected $studentRollNoLength = 5;

    protected $rollNoFormat = 'prefix-yy-cc-no';
    protected $temp = array( 
    				'prefix'		=> array('value' => '', 
    									'sort_order'=>0, 
    									'status'=>1
    									),
    				'start_year'	=> array('value' => 'yy', 
    									'sort_order'=>0, 
    									'status'=>1
    									),

    				'end_year'		=> array('value' => 'yy', 
    									'sort_order'=>0, 
    									'status'=>1
    									),
    				'batch_code'	=> array('value' => 'code', 
    									'sort_order'=>0, 
    									'status'=>1
    									),
    				'course_code'	=> array('value' => 'code', 
    									'sort_order'=>0, 
    									'status'=>1
    									),

					'serial_no'		=> array('value' => 'code', 
    									'sort_order'=>0, 
    									'status'=>1
    									)
    			);
    public function getRollNoLength()
    {
    	return $this->studentRollNoLength;
    }

    public function getSettings()
    {
    	return $this->settings;
    }

}
