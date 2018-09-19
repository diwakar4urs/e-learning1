<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    public function getIdCardData($item_key, $data = NULL)
    {
    	$setting_name = 'id_card_fields';
    	if(!$data)
    	return getSetting($item_key, $setting_name);

    	 return $this->prepareValue(getSetting($item_key, $setting_name), $data);
    }

    public function prepareValue($key, $data)
    {	
          if($key=='address_full' || $key=='address_middle' || $key=='address_small')
    	{
    		
    		 return $this->prepareAddress($key, $data);
    	}
    	
    	return $data->$key;
    }

    public function prepareAddress($key, $data)
    {	
    	
    	$address = '';
    	switch($key)
    	{
    		case 'address_full': $address = $data->address_lane1
    								.', '.$data->city.', '.$data->state; break;
    		case 'address_middle': $address = $data->address_lane1.', '.$data->city; break;
    		case 'address_small' : $address = $data->city.', '.$data->state;

    	}

    	return $address;
    }

}
