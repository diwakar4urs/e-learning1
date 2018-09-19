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
use Charts;
class LibraryDashboardController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index()
    {

      if(!checkRole(getUserGrade(9)))
      {
        prepareBlockUserMessage();
        return back();
      }

      $records = (object) App\LibraryMaster::getAssetsCount();
      $asset_names = $records->names;
      $assets_count = $records->count;
      
      
    $chart =  Charts::create('pie', 'chartjs')
    ->title(getPhrase('assets_information'))
    ->labels($asset_names)
    ->values($assets_count)
    ->responsive(false)
    ->height(300)
    ->width(0);
      $data['asset_charts']       = $chart;
      $data['active_class']       = 'library';
      $data['title']              = getPhrase('library_dashboard');
      $data['layout']             = getLayout();
      $data['module_helper']      = getModuleHelper('library-dashboard');
      return view('library.librarydashboard.dashboard', $data);  
       
    }
    /**
     * This Method show the student list who are return the books to the library
     * @return [type] [description]
     */
    public function books()
    { 

      if(!checkRole(getUserGrade(15))){
      $data['active_class']       = 'library';
      }
      else{
      $data['active_class']       = 'student-return';
      }
      $data['title']              = getPhrase('student_book_returns');
      $data['layout']             = getLayout();
      $data['module_helper']      = getModuleHelper('student-book-return');
      return view('library.librarydashboard.list', $data);
    }
    /**
     * This method show the staff list who are return the books to library
     * @return [type] [description]
     */
    public function staffbooks()
    {
      if(!checkRole(getUserGrade(15))){
      $data['active_class']       = 'library';
      }
      else{
      $data['active_class']       = 'staff-return';
      }
      $data['title']              = getPhrase('staff_book_returns');
      $data['layout']             = getLayout();
      $data['module_helper']      = getModuleHelper('staff-book-return');
      return view('library.librarydashboard.staff-list', $data);
    }

/**
 * This method returns the students list who are not return the book
 * @return [type] [description]
 */
    public function getDatatable()
    {
      $records = array();

      $records = LibraryIssue::join('users','libraryissues.user_id','=','users.id')
      
        ->join('librarymasters','libraryissues.master_asset_id','=','librarymasters.id')
        ->join('students','libraryissues.user_id','=','students.user_id')

        ->join('academics','students.academic_id','=','academics.id')

        ->join('courses','students.course_id','=','courses.id')

      ->join('libraryassettypes','librarymasters.asset_type_id','=','libraryassettypes.id')

      ->select(['users.image','students.roll_no','users.name','academics.academic_year_title','courses.course_title','courses.is_having_semister','students.current_year','students.current_semister','libraryissues.library_asset_no','librarymasters.title','users.email','libraryissues.issued_on','libraryissues.due_date','libraryissues.id','libraryissues.user_id','libraryissues.master_asset_id','libraryissues.library_instance_id','courses.course_dueration'])->where('issue_type','=','issue')

      ->orderBy('libraryissues.updated_at','desc');

      return Datatables::of($records)

      ->addColumn('submit',function($records)
      {

    $link_data = '<a href="javascript:void(0);" onclick="changeStatus(\''.$records->user_id.'\',\''.$records->id.'\',\''.$records->library_instance_id.'\',\''.$records->master_asset_id.'\');" ><button type="button"  class="btn btn-primary">Return</button></a>';

               return $link_data;

                      
     })

      ->editColumn('image', function($records)
      {
            return '<img src="'.getProfilePath($records->image).'"  />';

          })

      ->editColumn('issued_on',function($records)
      {
          $data = $records->issued_on.'<br>'.'<b>'.'<span class="text-red">'.$records->due_date.'</span></b>';
          
          return $data;
      })

      ->editColumn('roll_no',function($records)
      {
          $data = '<b>'.$records->roll_no;
          
          return $data;
      })

      ->editColumn('library_asset_no',function($records)
      {
          $data = '<b>'.$records->library_asset_no;
          
          return $data;
      })

      ->editColumn('academic_year_title',function($records)
      {   
        if($records->course_dueration>1 && $records->is_having_semister==1){

          if($records->current_year==-1 && $records->current_semister==-1){

             return $data = $records->academic_year_title.'<br>'.$records->course_title.'<br>'.'<span class="text-red">'.'Complted';
            }

          $data = $records->academic_year_title.'<br>'.$records->course_title.'<br>'.$records->current_year.'Year'.'-'.$records->current_semister.'Sem';
          
          return $data;
        }
          else{

            if($records->current_year==-1 && $records->current_semister==-1){

             return $data = $records->academic_year_title.'<br>'.$records->course_title.'<br>'.'<span class="text-red">'.'Complted';
              }

            $data = $records->academic_year_title.'<br>'.$records->course_title.'<br>'.$records->current_year.'Year';
          
          return $data;
          }

          if($records->course_dueration<=1){
               if($records->current_year==-1 && $records->current_semister==-1){
                 return $data = $records->academic_year_title.'<br>'.$records->course_title.'<br>'.'<span class="text-red">'.'Complted';
               }
            $data = $records->academic_year_title.'<br>'.$records->course_title;
             return $data;
          }
          
      })
      ->removeColumn('course_title')
      ->removeColumn('current_year')
      ->removeColumn('current_semister')
      ->removeColumn('due_date')
      ->removeColumn('updated_at')
      ->removeColumn('id')
      ->removeColumn('user_id')
      ->removeColumn('master_asset_id')
      ->removeColumn('library_instance_id')
      ->removeColumn('course_dueration')
      ->removeColumn('is_having_semister')
      ->make();
    }
/**
 * This method returns staf list who are not return the book 
 * @return [type] [description]
 */
    public function getStaffDatatable()
    {
      $records = array();
      $records = LibraryIssue::join('users','libraryissues.user_id','=','users.id')
      ->join('staff','libraryissues.user_id','=','staff.user_id')
      ->join('courses','staff.course_id','=','courses.id')
      ->join('librarymasters','libraryissues.master_asset_id','=','librarymasters.id')
      ->select(['libraryissues.id','users.image','staff.staff_id','users.name','courses.course_title','libraryissues.library_asset_no','librarymasters.title','users.email','libraryissues.issued_on','libraryissues.due_date','libraryissues.user_id','libraryissues.master_asset_id','libraryissues.library_instance_id'])->where('issue_type','=','issue')

      ->orderBy('libraryissues.updated_at','desc');

      return Datatables::of($records)
      
     ->addColumn('submit',function($records)
      {
        
   $link_data = '<a href="javascript:void(0);" onclick="changeStatus(\''.$records->user_id.'\',\''.$records->id.'\',\''.$records->library_instance_id.'\',\''.$records->master_asset_id.'\');" ><button type="button"  class="btn btn-primary">Return</button></a>';

               return $link_data;
   
                      
     })

      ->editColumn('image', function($records)
      {
            return '<img src="'.getProfilePath($records->image).'"  />';

          })

      ->editColumn('staff_id',function($records)
      {
          $data = '<b>'.$records->staff_id;
          
          return $data;
      })

      ->editColumn('library_asset_no',function($records)
      {
          $data = '<b>'.$records->library_asset_no;
          
          return $data;
      })

      ->editColumn('issued_on',function($records)
      {
          $data = $records->issued_on.'<br>'.'<b>'.'<span class="text-red">'.$records->due_date.'</span></b>';
          
          return $data;
      })
      ->removeColumn('id') 
      ->removeColumn('user_id')
      ->removeColumn('master_asset_id')
      ->removeColumn('library_instance_id')     
      ->removeColumn('due_date')
      ->removeColumn('updated_at')

      ->make();


    } 
}

?>    
