<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Timetable;
use App\Subject;
use App\StudentAttendance;
use App\StudentPromotion;
use App\Course;
use App\Academic;
use Yajra\Datatables\Datatables;
use DB;
use \Auth;
use Exception;
class StudentListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

     
     /**
      * This Method View student lisr according to the classwise
      * @return [type] [description]
      */
    public function index()
    {
        $data['active_class']       = 'academic';
        $data['title']              = getPhrase('student_list');
        
        $data['academic_years']     = addSelectToList(getAcademicYears());
        $list                       = App\Course::getCourses(0);
        
        $data['layout']             = getLayout();
        $data['module_helper']      = getModuleHelper('student-list');

      return view('student.list', $data); 
    }
     /**
      * This method print the student list according to classwise
      * @param  Request $request [description]
      * @return [type]           [description]
      */
     public function printStudentList(Request $request)
     {
        
        $academic_id        = $request->academic_id;
        $course_parent_id   = $request->course_parent_id;
        $course_id          = $request->course_id;
        $year        = 1;
            if($request->year){
              $year = $request->year;
            }
            $semister = 0;
            if($request->semister){ 
            $semister    = $request->semister;
          }
        $academic_details  =  App\Academic::where('id',$request->academic_id)->first();
        $course_details    =  App\Course::where('id',$request->course_id)->first();
        $records = User::join('students', 'users.id' ,'=', 'students.user_id')  
        ->join('academics','academics.id','=','students.academic_id') 
        ->join('courses','courses.id','=','students.course_id')
        ->where('academic_id','=',$academic_id)
        // ->where('course_parent_id','=',$course_parent_id)
        ->where('course_id','=',$course_id)
        ->where('current_year','=',$year)
        ->where('current_semister','=',$semister)
        ->select(['students.user_id as id','users.name', 'roll_no','admission_no', 'course_title','blood_group','mobile','home_phone','image','academic_year_title', 'email', 'current_year', 'current_semister','course_dueration','students.academic_id as academic_id', 'students.course_id as course_id', 'students.user_id as user_id','users.slug'])
        ->get();
         if($course_details->course_dueration>1 && $course_details->is_having_semister==1){
         $data['title']     = $academic_details->academic_year_title.' '.$course_details->course_title.' '.$year.' '.'year'.' '.$semister.' '.'semester '.' '.getPhrase('list');
         }
        elseif ($course_details->course_dueration>1 && $course_details->is_having_semister==0) {
         $data['title']     = $academic_details->academic_year_title.' '.$course_details->course_title.' '.$year.' '.'year'.' '.getPhrase('list');
        }
        else{
          $data['title']     = $academic_details->academic_year_title.' '.$course_details->course_title.' '.getPhrase('list');
        }
        $data['records']   = $records;
        $data['extracols']   = $request->extracols;

         $view     = \View::make('student.class-list-print-file',$data);
        $contents = $view->render();

        return $contents;
     }
    /**
     * This Method show the course completed list according to the
     * selection list
     * @return [type] [description]
     */
    public function courseCompltedStudentsList()
    {
        $data['active_class']       = 'academic';
        $data['title']              = getPhrase('course_completed_student_list');
        
        $data['academic_years']     = addSelectToList(getAcademicYears());
        $list                       = App\Course::getCourses(0);
        
        $data['layout']             = getLayout();
        $data['module_helper']      = getModuleHelper('course-completed-student-list');

      return view('student.completed-list', $data); 
    }
    /**
     * This method print the course completed students list
     * @param Request $request [description]
     */
    public function printCourseCompltedStudentsList(Request $request)
    {   
        
        $academic_id        = $request->academic_id;
        $course_parent_id   = $request->parent_course_id;
        $course_id          = $request->course_id;
        $year        = 1;
            if($request->year){
              $year = $request->year;
            }
            $semister = 0;
            if($request->semister){ 
            $semister    = $request->semister;
          }
        $academic_details  =  App\Academic::where('id',$request->academic_id)->first();
        $course_details    =  App\Course::where('id',$request->course_id)->first();
        
         $records = StudentPromotion::join('users','users.id','=','studentpromotions.user_id')
            ->join('students','students.id','=','studentpromotions.student_id')
            ->join('courses','courses.id','=','students.course_id')
            ->where('from_academic_id','=',$academic_id)
            // ->where('from_course_parent_id','=',$course_parent_id)
            ->where('from_course_id','=',$course_id)
            ->where('from_year','=',$year)
            ->where('from_semister','=',$semister)
            ->where('type','=','completed')
            ->select(['users.name','students.roll_no','courses.course_title','users.slug'])
            ->get();
             if($course_details->course_dueration>1 && $course_details->is_having_semister==1){
         $data['title']     = $academic_details->academic_year_title.' '.$course_details->course_title.' '.$year.' '.'year'.' '.$semister.' '.'semester '.' '.getPhrase('course_completed_list');
         }
        elseif ($course_details->course_dueration>1 && $course_details->is_having_semister==0) {
         $data['title']     = $academic_details->academic_year_title.' '.$course_details->course_title.' '.$year.' '.'year'.' '.getPhrase('course_completed_list');
        }
        else{
          $data['title']     = $academic_details->academic_year_title.' '.$course_details->course_title.' '.getPhrase('course_completed_list');
        }
        $data['records']   = $records;

         $view     = \View::make('student.cousrse-completd-list-print-file',$data);
        $contents = $view->render();

        return $contents;

            
    }
    /**
     * This Method show the course detained list according to the
     * selection list
     * @return [type] [description]
     */
     public function courseDetainedStudentsList()
    {
        $data['active_class']       = 'academic';
        $data['title']              = getPhrase('detained_student_list');
        
        $data['academic_years']     = addSelectToList(getAcademicYears());
        $list                       = App\Course::getCourses(0);
        
        $data['layout']             = getLayout();
        $data['module_helper']      = getModuleHelper('detained-student-list');

      return view('student.detained-list', $data); 
    }
    /**
     * This method print the detained students list
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function printCourseDetainedStudentsList(Request $request)
    {
         
        $academic_id        = $request->academic_id;
        $course_parent_id   = $request->parent_course_id;
        $course_id          = $request->course_id;
        $year        = 1;
            if($request->year){
              $year = $request->year;
            }
            $semister = 0;
            if($request->semister){ 
            $semister    = $request->semister;
          }
        $academic_details  =  App\Academic::where('id',$request->academic_id)->first();
        $course_details    =  App\Course::where('id',$request->course_id)->first();

         $records = StudentPromotion::join('users','users.id','=','studentpromotions.user_id')
            ->join('students','students.id','=','studentpromotions.student_id')
            ->join('courses','courses.id','=','students.course_id')
            ->where('from_academic_id','=',$academic_id)
            // ->where('from_course_parent_id','=',$course_parent_id)
            ->where('from_course_id','=',$course_id)
            ->where('from_year','=',$year)
            ->where('from_semister','=',$semister)
            ->where('type','=','detained')
            ->select(['users.name','students.roll_no','courses.course_title','users.slug'])
            ->get();

             if($course_details->course_dueration>1 && $course_details->is_having_semister==1){
         $data['title']     = $academic_details->academic_year_title.' '.$course_details->course_title.' '.$year.' '.'year'.' '.$semister.' '.'semester '.' '.getPhrase('course_detained_list');
         }
        elseif ($course_details->course_dueration>1 && $course_details->is_having_semister==0) {
         $data['title']     = $academic_details->academic_year_title.' '.$course_details->course_title.' '.$year.' '.'year'.' '.getPhrase('course_detained_list');
        }
        else{
          $data['title']     = $academic_details->academic_year_title.' '.$course_details->course_title.' '.getPhrase('course_detained_list');
        }
        $data['records']   = $records;
         $view     = \View::make('student.cousrse-detained-list-print-file',$data);
        $contents = $view->render();

        return $contents;

    }
    
    
}
