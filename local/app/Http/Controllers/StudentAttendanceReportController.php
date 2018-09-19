<?php
namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;
use App\Http\Requests;

use Yajra\Datatables\Datatables;
use DB;
use \Auth;
class StudentAttendanceReportController extends Controller
{
      public function __construct()
    {
    	$this->middleware('auth');
    }

    /**
     * Course listing method
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $data['active_class']       = 'school_hub';
        $data['title']              = getPhrase('attendance');
        
        $data['academic_years']     = addSelectToList(\App\Academic::pluck('academic_year_title', 'id'));
        $list                       = App\Course::getCourses(0);
        $data['courses_parent_list']= array_pluck($list, 'course_title', 'id');
        $data['courses_list']       = array(''=>'Select Course');
        $years[''] 					        = 'Select Year';
        $semisters[''] 				      = 'Select Sem';
        $data['years']      		    = $years;
        $data['semisters']          = $semisters;
        $data['layout']  		        = getLayout();


    	return view('attendance.reports.select-particulars', $data);
    }

    /**
     * This method will return the details to view attendance of student
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function viewStudentAttendance($slug)
    {

      if(!checkRole(getUserGrade(10)))
      {
        prepareBlockUserMessage();
        return back();
      }

      if(!isEligible($slug))
      {
        return back();
      }

      $user_record                = App\User::where('slug','=',$slug)->first();
      $data['active_class']       = 'dashboard';
      $data['title']              = getPhrase('overall_subject_wise_analysis');
      $data['user']               = $user_record;
      $data['student']            = App\Student::where('user_id', '=', $user_record->id)->first();

     
      $data['academic_years']     = addSelectToList(getAcademicYears());
      $userid                     = $user_record->id;
      $data['layout']             = getLayout();
      $data['userrecord']         = $user_record; 
      return view('attendance.reports.select-particulars', $data); 
    }


    public function getAttendance(Request $request)
    {  

        $academic_id        = $request->academic_id;
        $student_id         = $request->student_id;
        $course_id          = $request->course_id;
        $year               = $request->year;
        $semister           = $request->semister;

        $attendance         = App\StudentAttendance::
        join('subjects', 'subjects.id', '=', 'studentattendance.subject_id')

        ->select(['studentattendance.id','student_id','attendance_date','attendance_code','academic_id','course_parent_id','course_id','year','subject_title', 'total_class','studentattendance.record_updated_by as staff_id','subjects.id as subject_id'])

        ->where('student_id',   '=', $student_id)
        ->where('academic_id',  '=', $academic_id)
        ->where('course_id',    '=', $course_id)
        ->where('year',         '=', $year)
        ->where('semester',     '=', $semister)
        ->get();

        $sum = App\StudentAttendance::
          where('student_id',   '=', $student_id)
        ->where('academic_id',  '=', $academic_id)
        ->where('course_id',    '=', $course_id)
        ->where('year',         '=', $year)
        ->where('semester',     '=', $semister)
        ->sum('total_class');
 
        return json_encode(array('attendance'=>$attendance,'sum'=>$sum));

    }

    /**
     * This method loads the view for class wise attendance for all the staff
     * @return [type] [description]
     */
    public function classAttendance()
    {
        $data['active_class']       = 'academic';
        $data['title']              = getPhrase('attendance_report');
        
        $data['academic_years']     = addSelectToList(getAcademicYears());
        $list                       = App\Course::getCourses(0);
        
        $data['layout']             = getLayout();
        $data['module_helper']      = getModuleHelper('class_attendance_report');

      return view('attendance.class-report.selection-view', $data);   
    }

    /**
     * This method calculates the overall attendance for the sent 
     * combination of academic id, course id, year and semister
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getClassAttendance(Request $request)
    {
            $academic_id = $request->academic_id; 
            $course_id   = $request->course_id; 
            $year        = $request->year; 
            $semister    = $request->semister;

        $query = App\StudentAttendance::
                            join('students', 'students.id', '=', 'studentattendance.student_id')
                          ->join('users', 'users.id', '=', 'students.user_id')
                          ->where('studentattendance.academic_id', '=', $academic_id)
                          ->where('studentattendance.course_id', '=', $course_id)
                          ->where('studentattendance.year', '=', $year)
                          ->where('studentattendance.semester', '=', $semister);

        $total_class  = $query->groupBy('student_id')->sum('total_class');
        
        $students = $query->groupBy('student_id')
                          
                          ->get();
       $summary_attendance = array();
       $sno = 1;

       foreach($students as $student)
       {
          $temp['sno'] = $sno++;
          $temp['name'] = $student->name;
          $temp['slug'] = $student->slug;
          $temp['roll_no'] = $student->roll_no;
          $temp['total_classes'] = $total_class;
           $present = $student->getAttendanceCount('P', $academic_id, $course_id, $year, $semister);
          $absent = $student->getAttendanceCount('A', $academic_id, $course_id, $year, $semister);
          $leave = $student->getAttendanceCount('L', $academic_id, $course_id, $year, $semister);
          $temp['present'] = ($present) ? $present : 0;
          $temp['absent'] = ($absent) ? $absent: 0;
          $temp['leave'] = ($leave) ? $leave: 0;
          $temp['percentage'] = getPercentage($present,$total_class);
          $summary_attendance[] = $temp;
       }

        return $summary_attendance;      
    }


    /**
     * This method will return the last updated classes by teacher
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getLessionPlansLatestRecords(Request $request)
    {
      
      $subject_id = $request->subject_id;
      $user_id = $request->user_id;

      
      
      $topics = App\CourseSubject::join('lessionplans', 'course_subject.id', '=', 'lessionplans.course_subject_id')
      ->join('subjects', 'subjects.id', '=', 'course_subject.subject_id')
      ->join('topics', 'topics.id', '=', 'lessionplans.topic_id')
      
      ->where('course_subject.staff_id', '=', $user_id)
      ->where('course_subject.subject_id', '=', $subject_id)
      
      ->limit(10)
      ->select(['topics.topic_name', 'subject_title', 'lessionplans.is_completed', 'lessionplans.completed_on'])
      ->orderBy('lessionplans.completed_on', 'desc')
      ->get();
      $final_data = [];
      
        $temp['topic_data'] = $topics;
        $temp['user'] = App\User::join('staff', 'staff.user_id', '=','users.id')
                        ->where('users.id', '=', $user_id)
                        ->select(['users.name', 'users.email', 'users.phone', 'job_title','qualification','experience_information', 'image'])
                        ->first();
        $final_data = $temp;
      

      return json_encode($final_data);
    }

    public function printClassAttendance(Request $request)
    {
        
            $academic_id = $request->academic_id; 
            $course_id   = $request->course_id; 
            $year        = 1;
            if($request->year){
              $year = $request->year;
            }
            $semister = 0;
            if($request->semister){ 
            $semister    = $request->semister;
          }
          $academic_details  =  App\Academic::where('id',$request->academic_id)->first();
          $course_details  =  App\Course::where('id',$request->course_id)->first();
        $query = App\StudentAttendance::
                            join('students', 'students.id', '=', 'studentattendance.student_id')
                          ->join('users', 'users.id', '=', 'students.user_id')
                          ->where('studentattendance.academic_id', '=', $academic_id)
                          ->where('studentattendance.course_id', '=', $course_id)
                          ->where('studentattendance.year', '=', $year)
                          ->where('studentattendance.semester', '=', $semister);

        $total_class  = $query->groupBy('student_id')->sum('total_class');
        
        $students = $query->groupBy('student_id')
                          
                          ->get();
       $summary_attendance = array();
       $sno = 1;

       foreach($students as $student)
       {
          $temp['sno'] = $sno++;
          $temp['name'] = $student->name;
          $temp['slug'] = $student->slug;
          $temp['roll_no'] = $student->roll_no;
          $temp['total_classes'] = $total_class;
           $present = $student->getAttendanceCount('P', $academic_id, $course_id, $year, $semister);
          $absent = $student->getAttendanceCount('A', $academic_id, $course_id, $year, $semister);
          $leave = $student->getAttendanceCount('L', $academic_id, $course_id, $year, $semister);
          $temp['present'] = ($present) ? $present : 0;
          $temp['absent'] = ($absent) ? $absent: 0;
          $temp['leave'] = ($leave) ? $leave: 0;
          $temp['percentage'] = getPercentage($present,$total_class);
          $summary_attendance[] = $temp;
       }
         if($course_details->course_dueration>1 && $course_details->is_having_semister==1){
         $data['title']     = $academic_details->academic_year_title.' '.$course_details->course_title.' '.$year.' '.'year'.' '.$semister.' '.'semester '.' '.getPhrase('attendance_report');
         }
        elseif ($course_details->course_dueration>1 && $course_details->is_having_semister==0) {
         $data['title']     = $academic_details->academic_year_title.' '.$course_details->course_title.' '.$year.' '.'year'.' '.getPhrase('attendance_report');
        }
        else{
          $data['title']     = $academic_details->academic_year_title.' '.$course_details->course_title.' '.getPhrase('attendance_report');
        }

         $data['summary_attendance']   = $summary_attendance;
         $view     = \View::make('attendance.class-report.print-file',$data);
        $contents = $view->render();

        return $contents;
    }

    public function render($__php, $__data)
    {
        $obLevel = ob_get_level();
        ob_start();
        extract($__data, EXTR_SKIP);
        try {
            eval('?' . '>' . $__php);
        } catch (Exception $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw $e;
        } catch (Throwable $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw new FatalThrowableError($e);
        }
        return ob_get_clean();
    }
  }