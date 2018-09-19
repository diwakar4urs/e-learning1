<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App;
use App\Http\Requests;
use App\User;
use App\GeneralSettings as Settings;
use Image;
use ImageSettings;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Support\Facades\Hash;
use Excel;
use Input;
use File;
use App\OneSignalApp;
use Exception;
use App\LibraryIssue;
use Form;
class SettingsDashboardController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function settingsDashboard()
    {

      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
      
      $data['active_class']       = 'master_settings';
      $data['title']              = getPhrase('master_settings');
      $data['layout']             = getLayout();
      return view('mastersettings.dashboard', $data);  
       
    }
}   