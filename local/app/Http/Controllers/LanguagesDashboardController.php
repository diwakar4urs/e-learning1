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
class LanguagesDashboardController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index()
    {

      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
      
      
      $data['title']              = getPhrase('languages_dashboard');
      $data['layout']             = getLayout();
      return view('languages.dashboard', $data);  
       
    }
}   