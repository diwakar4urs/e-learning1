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
use App\Academic;
use App\Course;
use Form;
class UsersDashboardController extends Controller
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
      
      $data['active_class']       = 'users';
      $data['title']              = getPhrase('users_dashboard');
      $data['layout']             = getLayout();
      $academic_details           = Academic::select('academic_year_title')->get();
      $data['academic_details']   = $academic_details;
      $course_details             = Course::select('course_title')->get();
      $data['course_details']     = $course_details;
      $data['module_helper']      = getModuleHelper('users-dashborad-list');
      return view('users.dashboard', $data);  
       
    }
}   