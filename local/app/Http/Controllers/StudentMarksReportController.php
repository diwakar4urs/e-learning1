<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Timetable;
use App\Subject;
use App\StudentAttendance;
use App\Course;
use App\Academic;
use Yajra\Datatables\Datatables;
use DB;
use \Auth;

class StudentMarksReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

     /**
     * Marks listing method
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $data['active_class']       = 'academic';
        $data['title']              = getPhrase('marks_report');
        
        $data['academic_years']     = addSelectToList(getAcademicYears());
        $list                       = App\Course::getCourses(0);
        
        $data['layout']             = getLayout();

      return view('offline-exams.class-report.selection-view', $data); 
    }

    /**
     * Marks listing method
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function classMarks()
    {
        $data['active_class']       = 'academic';
        if(getRoleData(Auth::user()->role_id)=='student')
          $data['active_class']       = 'analysis';
        $data['title']              = getPhrase('marks_report');
        
        $data['academic_years']     = addSelectToList(getAcademicYears());
        $list                       = App\Course::getCourses(0);
        
        $data['layout']             = getLayout();
        $data['module_helper']      = getModuleHelper('class_marks_reports');

      return view('offlineexams.class-report.selection-view', $data); 
    }

    /**
     * This method lists the list of offline exams by the set of combination
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function offlineExamsList(Request $request)
    {
    	$academic_id 	= $request->academic_id; 
        $course_id 		= $request->course_id; 
        $course_id 		= $request->course_id; 
        $year 			= $request->year; 
        $semister 		= $request->semister;

        $records = App\OfflineQuizCategories::
                            join('quizzes', 'quizzes.offline_quiz_category_id', '=', 'quizofflinecategories.id')
                          ->join('quizapplicability', 'quizapplicability.quiz_id', '=', 'quizzes.id')
                          ->where('quizapplicability.academic_id', '=', $academic_id)
                          ->where('quizapplicability.course_id', '=', $course_id)
                          ->where('quizapplicability.year', '=', $year)
                          ->where('quizapplicability.semister', '=', $semister)
                          ->select(['quizofflinecategories.id', 'quizofflinecategories.title'])
                          ->groupBy('quizofflinecategories.id')
                          ->get();
        return $records;
	}

 /**
     * Marks listing method
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getClassMarks(Request $request)
    {

    	$academic_id = $request->academic_id; 
            $course_id = $request->course_id; 
            $year = $request->year; 
            $semister=$request->semister;
            $offline_quiz_category_id = $request->offline_quiz_category_id;

      $course_record = App\Course::where('id','=',$course_id)->first();
      $academic_record = App\Academic::where('id','=',$academic_id)->first();
      $offline_quiz_category = App\OfflineQuizCategories::where('id', '=', $offline_quiz_category_id)->first();      
      $quiz_details   = App\Quiz::where('offline_quiz_category_id','=',$offline_quiz_category_id)->get();
      $title = $academic_record->academic_year_title.' '.$course_record->course_title;
      if($course_record->course_dueration>1)
      {
        $title .= ' Year-'.$year;
        if($course_record->is_having_semister && $semister>0)
          $title .= ' Sem-'.$semister;
      }

      if($offline_quiz_category)
      $title .= ' '.$offline_quiz_category->title.' class marks';

       $subjects = App\QuizApplicability::
                            
                          join('quizzes', 'quizapplicability.quiz_id', '=', 'quizzes.id')
                          ->join('subjects', 'subjects.id', '=', 'quizzes.subject_id')
                          ->where('quizapplicability.academic_id', '=', $academic_id)
                          ->where('quizapplicability.course_id', '=', $course_id)
                          ->where('quizapplicability.year', '=', $year)
                          ->where('quizapplicability.semister', '=', $semister)
                          ->where('quizzes.offline_quiz_category_id', '=', $offline_quiz_category_id)
                          ->select(['quizzes.id as quiz_id', 'quizzes.title','subject_id', 'subject_title','subject_code','quizzes.offline_quiz_category_id','total_marks'])
                          ->get();

           foreach($quiz_details as $quiz_datail){
      $students = App\Student::join('users','users.id','=','students.user_id')
                              ->join('quizresults','quizresults.user_id','=', 'users.id')

                          ->where('quizresults.quiz_id', '=', $quiz_datail->id)
                          ->where('quizresults.academic_id', '=', $academic_id)
                          ->where('quizresults.course_id', '=', $course_id)
                          ->where('quizresults.year', '=', $year)
                          ->where('quizresults.semister', '=', $semister)
                          ->select(['users.id as user_id','roll_no','name','image','students.id as student_id','users.slug as user_slug'])
                          ->get();
                        }
       $students_list = [];
       $final_list = [];

       foreach($students as $student)
       {
         $temp = [];
        $temp['user_id'] = $student->user_id;
        $temp['name'] = $student->name;
        $temp['roll_no'] = $student->roll_no;
        $temp['image']   = $student->image;
        $temp['slug']   = $student->user_slug;
        $subject_marks = [];
        $average = 0;
          foreach($subjects as $subject)
          {
        $marks_records = $this->getSubjectMarks($student->user_id,$offline_quiz_category_id, $subject->subject_id);
            
            $subject_marks['subject_id'] = $subject->subject_id;
            $subject_marks['subject_title'] = $subject->subject_title;
            $subject_marks['subject_code'] = $subject->subject_code;
            $subject_marks ['score'] = isset($marks_records) ? $marks_records : null;
            $subject_marks ['percentage'] = isset($marks_records->percentage) ? $marks_records->percentage: 0;
            $average = $average+$subject_marks ['percentage'];
            $temp['marks'][] = $subject_marks;
          }
          $temp['average']   = 0;
          $total_subjects = count($subjects);

          if($total_subjects)
           $temp['average']   = round($average/count($subjects));
          
          $students_list[] = $temp;

       }
      $final_list['students'] = $students_list;
      $final_list['subjects'] = $subjects;
      $final_list['course_title'] = $title;
      return $final_list;
       
    }
    /**
     * Returns the list of marks with the sent combination
     * @param  [type] $user_id                  [description]
     * @param  [type] $quiz_offline_category_id [description]
     * @param  [type] $subject_id               [description]
     * @return [type]                           [description]
     */
    public function getSubjectMarks($user_id, $quiz_offline_category_id, $subject_id)
    {
      $records = App\Quiz::join('quizresults','quizzes.id','=','quizresults.quiz_id')
                          ->where('quizzes.offline_quiz_category_id','=',$quiz_offline_category_id)
                          ->where('quizzes.subject_id','=',$subject_id)
                          ->where('quizresults.user_id','=',$user_id)
                          

                          ->select(['user_id','quizresults.marks_obtained','subject_id', 'quizresults.total_marks','quizresults.percentage', 'quizresults.exam_status'])->first();
      return $records;
    }

    public function printClassMarks(Request $request)
    {  
        if(checkRole(getUserGrade(5)))
        {
           $academic_id  = $request->extra_academic_id;
        }
        else{
            $academic_id = $request->academic_id; 
          }
            $course_id = $request->course_id; 
           $year        = 1;
            if($request->year){
              $year = $request->year;
            }
            $semister = 0;
            if($request->semister){ 
            $semister    = $request->semister;
          }
            $offline_quiz_category_id = $request->offline_quiz_category_id;

      $course_record = App\Course::where('id','=',$course_id)->first();
      $academic_record = App\Academic::where('id','=',$academic_id)->first();

      $offline_quiz_category = App\OfflineQuizCategories::where('id', '=', $offline_quiz_category_id)->first();      
      $quiz_details   = App\Quiz::where('offline_quiz_category_id','=',$offline_quiz_category_id)->get();
      $title = $academic_record->academic_year_title.' '.$course_record->course_title;

      if($course_record->course_dueration>1)
      {
        $title .= ' Year-'.$year;
        if($course_record->is_having_semister && $semister>0)
          $title .= ' Sem-'.$semister;
      }

      if($offline_quiz_category)
      $title .= ' '.$offline_quiz_category->title.' class marks';

       $subjects = App\QuizApplicability::
                            
                          join('quizzes', 'quizapplicability.quiz_id', '=', 'quizzes.id')
                          ->join('subjects', 'subjects.id', '=', 'quizzes.subject_id')
                          ->where('quizapplicability.academic_id', '=', $academic_id)
                          ->where('quizapplicability.course_id', '=', $course_id)
                          ->where('quizapplicability.year', '=', $year)
                          ->where('quizapplicability.semister', '=', $semister)
                          ->where('quizzes.offline_quiz_category_id', '=', $offline_quiz_category_id)
                          ->select(['quizzes.id as quiz_id', 'quizzes.title','subject_id', 'subject_title','subject_code','quizzes.offline_quiz_category_id','total_marks'])
                          ->get();

           foreach($quiz_details as $quiz_datail){
      $students = App\Student::join('users','users.id','=','students.user_id')
                              ->join('quizresults','quizresults.user_id','=', 'users.id')

                          ->where('quizresults.quiz_id', '=', $quiz_datail->id)
                          ->where('quizresults.academic_id', '=', $academic_id)
                          ->where('quizresults.course_id', '=', $course_id)
                          ->where('quizresults.year', '=', $year)
                          ->where('quizresults.semister', '=', $semister)
                          ->select(['users.id as user_id','roll_no','name','image','students.id as student_id','users.slug as user_slug'])
                          ->get();
                        }
       $students_list = [];
       $final_list = [];

       foreach($students as $student)
       {
         $temp = [];
        $temp['user_id'] = $student->user_id;
        $temp['name'] = $student->name;
        $temp['roll_no'] = $student->roll_no;
        $temp['image']   = $student->image;
        $temp['slug']   = $student->user_slug;
        $subject_marks = [];
        $average = 0;
          foreach($subjects as $subject)
          {
        $marks_records = $this->getSubjectMarks($student->user_id,$offline_quiz_category_id, $subject->subject_id);
            
            $subject_marks['subject_id'] = $subject->subject_id;
            $subject_marks['subject_title'] = $subject->subject_title;
            $subject_marks['subject_code'] = $subject->subject_code;
            $subject_marks ['score'] = isset($marks_records) ? $marks_records : null;
            $subject_marks ['percentage'] = isset($marks_records->percentage) ? $marks_records->percentage: 0;
            $average = $average+$subject_marks ['percentage'];
            $temp['marks'][] = $subject_marks;
          }
          $temp['average']   = 0;
          $total_subjects = count($subjects);

          if($total_subjects)
           $temp['average']   = round($average/count($subjects));
          
          $students_list[] = $temp;

       }
      $final_list['students'] = $students_list;
      $final_list['subjects'] = $subjects;
      $final_list['course_title'] = $title;
      $data ['final_list']     = $final_list;
      if($course_record->course_dueration>1 && $course_record->is_having_semister==1){
         $data['title']     = $academic_record->academic_year_title.' '.$course_record->course_title.' '.$year.' '.'year'.' '.$semister.' '.'semester '.' '.$offline_quiz_category->title.' '.getPhrase('marks');
         }
        elseif ($course_record->course_dueration>1 && $course_record->is_having_semister==0) {
         $data['title']     = $academic_record->academic_year_title.' '.$course_record->course_title.' '.$year.' '.'year'.' '.$offline_quiz_category->title.' '.getPhrase('marks');
        }
        else{
          $data['title']     = $academic_record->academic_year_title.' '.$course_record->course_title.' '.$offline_quiz_category->title.' '.getPhrase('marks');
        }
     // dd($final_list);
         $view     = \View::make('offlineexams.class-report.print-file',$data);
        $contents = $view->render();

        return $contents;
      
    }
}
