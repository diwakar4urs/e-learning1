<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App;
use App\Http\Requests;

class UpdatesController extends Controller
{
     public function __construct()
    {
     
         $this->middleware('auth');
    
    }

    /**
     * This is the first patch which updates the currency code to
     * Site Settings module
     * This can be used by the existing users
     * To access this method, user need to type the following url
     * http://sitename/updates/patch1
     * @return [type] [description]
     */
    public function patch1()
    {

      if(!checkRole(getUserGrade(1)))
      {
        prepareBlockUserMessage();
        return back();
      }
     // For Bonafide Certificate
     
    	$bonafide        = App\Settings::where('slug', 'bonafide-settings')->first();
    	 
    	$uptained_data = (array) json_decode($bonafide->settings_data);
        
       unset($uptained_data['orientation'],$uptained_data['margin'],$uptained_data['format'],$uptained_data['printable_file']);

       $changed_data =  $uptained_data;

       $bonafide->settings_data = json_encode($changed_data);
     
       $bonafide->save();
       
       //For Id Card
      
       $idcard        = App\Settings::where('slug', 'id-card-settings')->first();
       
       $idcard_setting_data = (array) json_decode($idcard->settings_data);
        
       unset($idcard_setting_data['orientation'],$idcard_setting_data['margin'],$idcard_setting_data['format'],$idcard_setting_data['printable_file']);

       $final_id_data =  $idcard_setting_data;

       $idcard->settings_data = json_encode($final_id_data);
     
       $idcard->save();

       //For Transfer Certificate

        $tc_data        = App\Settings::where('slug', 'transfer-certificate-settings')->first();

       
       $tc_setting_data = (array) json_decode($tc_data->settings_data);
        
       unset($tc_setting_data['orientation'],$tc_setting_data['margin'],$tc_setting_data['format'],$tc_setting_data['printable_file']);

       $final_tc_data =  $tc_setting_data;

       $tc_data->settings_data = json_encode($tc_setting_data);
     
       $tc_data->save();

       //For Timetable
       
       $timetable_data  = App\Settings::where('slug', 'timetable-settings')->first();
       if($timetable_data!=''){
       $timetable_data->delete();
       }


       flash('success','system_upgraded_successfully', 'success');
       return redirect(URL_MASTERSETTINGS_SETTINGS);
    }
}
