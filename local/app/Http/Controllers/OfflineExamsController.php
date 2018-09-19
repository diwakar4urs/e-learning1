<?php

namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\QuizApplicability;
use App\QuizResult;
use App\Quiz;
use App\Academic;
use App\Course;
use App\Student;
use App\Subject;
use Yajra\Datatables\Datatables;
use DB;
use Auth;
use Excel;
use Input;
use File;
use Exception;

class OfflineExamsController extends Controller
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

        $data['active_class']       = 'exams';
        $data['title']              = getPhrase('update_offline_exams_marks');
        $data['layout']             = getLayout();
        $data['module_helper']      = getModuleHelper('offlineexams-list');
      return view('offlineexams.list', $data);
    }

    public function getDatatable($slug = '')
    {
       if(!checkRole(getUserGrade(2)))

      {
        prepareBlockUserMessage();
        return back();
      }
        $academic_id = getDefaultAcademicId();
        $records = array();
        $records = Quiz::join('quizapplicability','quizapplicability.quiz_id','=','quizzes.id')
        ->join('subjects','subjects.id','=','quizzes.subject_id')
        ->join('academics','academics.id','=','quizapplicability.academic_id')
        ->join('courses','courses.id','=','quizapplicability.course_id')
        ->join('quizofflinecategories','quizzes.offline_quiz_category_id','=','quizofflinecategories.id')
        ->select(['quizzes.title','quizofflinecategories.title as quiz_offline_category','subjects.subject_title','quizzes.total_marks','quizzes.pass_percentage', 'quizzes.type',  'quizzes.id','quizzes.slug','start_date','end_date' ])

        ->where('quizzes.type','!=','online')
        ->where('quizapplicability.academic_id','=',$academic_id)
        
        ->groupBy('quizzes.id');
        
        return Datatables::of($records)

         ->addColumn('action', function ($records) {
         
          $link_data = '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="'.URL_OFFLINE_EXAMS_SELECTION_VIEW.$records->slug.'"><i class="fa fa-spinner" aria-hidden="true"></i>
'.getPhrase('update_marks').'</a></li>

                            <li><a href="'.URL_QUIZ_EDIT.'/'.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase('edit').'</a></li>';
                  
                  if(checkRole(getUserGrade(1))) {
                    $link_data .= ' <li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="fa fa-trash"></i>'. getPhrase("delete").'</a></li>';
                      }
              $link_data .='</ul></div>';
            return $link_data;
            })
        

         ->editColumn('title', function($records)
         {
          
              return '<a href="'.URL_OFFLINE_EXAMS_SELECTION_VIEW.$records->slug.'">'.$records->title.' ('.$records->id.')'.'</a>';
        })
         

        ->removeColumn('id')
        ->removeColumn('slug')
        ->removeColumn('type')
     
        ->make();
    }
    
    public function selectionview($slug)
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

       if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

      $quiz_record = App\Quiz::where('slug', '=', $slug)->first();
      $current_academic_id = getDefaultAcademicId();
      
      //Check the quiz record is valid or not
      
        $data['active_class']       = 'academic';
        $data['title']              = getPhrase('select_offline_exams_details');

        $records = QuizApplicability::join('quizzes','quizzes.id','=','quizapplicability.quiz_id')
                    ->join('courses','courses.id','=','quizapplicability.course_id')
                    ->where('quiz_id','=',$quiz_record->id)
                    ->where('academic_id', '=', $current_academic_id)
                    ->select(['quizapplicability.id as id','courses.course_dueration','courses.course_title','quizapplicability.year','quizapplicability.semister','courses.is_having_semister','quizapplicability.academic_id','quizapplicability.course_id'])->get();


        $select_options = [];
        $select_options[''] = getPhrase('Select');

        //Prepare the select list in the below format
        // Parent Course Code - Year-Sem - Subject-title  
        foreach($records as $record) {
          $year_semister = 0;
          if($record->course_dueration>1)
          {
            $year_semister = 'Year -'.$record->year;
            if($record->semister)
              $year_semister .= ' Sem -'.$record->semister;
          }
          $final_title = $record->course_title;
          
          if($year_semister)
            $final_title .= ' - '.$year_semister;
          
          $select_options[$record->id] = $final_title;
        }
  
           $data['quizzes']           = $select_options;
           $list                          = App\Course::getCourses(0);
      
         $data['layout']             = getLayout();
        $data['examtitle']           = getPhrase('update').' '.$quiz_record->title.' '.getPhrase('marks');
       
      
         
      return view('offlineexams.select-particulars', $data);  
    }

    public function isMarksAlreadyEntered($request ,$delete=FALSE)
    {
      $quiz_applicability_data  = QuizApplicability::where('id','=',$request->quiz_applicability_id)->get()->first();

        $year       = $quiz_applicability_data->year;
        $semister   = $quiz_applicability_data->semister;

       $data = App\QuizResult::where('quiz_id','=', $quiz_applicability_data->quiz_id)
      ->where('academic_id','=',$quiz_applicability_data->academic_id)
      ->where('course_parent_id','=',$quiz_applicability_data->course_parent_id)
      ->where('course_id','=',$quiz_applicability_data->course_id)
      ->where('year','=',$year)
      ->where('semister','=',$semister);
      if(!$delete)
      {
           return $data->get();
      }
       if(env('DEMO_MODE')) {
        return 1;
      }
      return $data->delete();
    }


    public function entermarks(Request $request)
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

          if(!$request->quiz_applicability_id)
        {
            flash('Oops...!','Invalid_details_supplied', 'overlay');
            return redirect()->back()->withInput($request->except('_token'));
        }

         $quiz_applicability_data  = QuizApplicability::where('id','=',$request->quiz_applicability_id)->get()->first();
         
       
      
        $marks_data = $this->isMarksAlreadyEntered($request);
        $data['marks_entered'] = FALSE;
        if(count($marks_data)){
        
        $data['marks_entered'] = TRUE;
        $data['entered_marks'] = $marks_data;
      }
        /**
         * Find wether the attendance is already added for the day or not
         * @var [type]
         */
         $year    = 1;
       if($quiz_applicability_data->year)
        $year = $quiz_applicability_data->year;

      $semester    = 0;
       if($quiz_applicability_data->semister)
        $semester = $quiz_applicability_data->semister;

      $data['record']           = FALSE;
      $data['active_class']     = 'academic';
      
      $course_record  = App\Course::where('id', '=', $quiz_applicability_data->course_id)->first();
      $submitted_data = array(
                        'current_year'       => $year,
                        'current_semister'   => $semester,
                        'course_record'      => $course_record,
                        'academic_id'        => $quiz_applicability_data->academic_id  ,      
                        'quiz_id'            => $quiz_applicability_data->quiz_id,
                        'quiz_applicable_id'  => $request->quiz_applicability_id        
                  );
     

      $studentObject        = new App\Student();
      $students             = $studentObject->getStudents
                             (
                              $quiz_applicability_data->academic_id,
                              $quiz_applicability_data->course_id,
                              $year,
                              $semester
                                   );
        $quiz_details = App\Quiz::where('id','=',$quiz_applicability_data->quiz_id)->get()->first();
        $academic_title = App\Academic::where('id','=',$quiz_applicability_data->academic_id)->pluck('academic_year_title');
        $data['submitted_data']    = (object)$submitted_data;
        $data['students']          = $students;
        $data['title']             = getPhrase('offline_exam_details');

      if($course_record->course_dueration>1 && $course_record->is_having_semister==1){
        $data['quiz_name']         = getPhrase('update').' '.$quiz_details->title.' '.getPhrase('marks_for').' '.$academic_title[0].' '.$course_record->course_title.' '.$quiz_applicability_data->year.' '.getPhrase('year').' '.$quiz_applicability_data->semister.' '.getPhrase('semester');
         }
         
       elseif($course_record->course_dueration>1 && $course_record->is_having_semister!=1){
        $data['quiz_name']         = getPhrase('update').' '.$quiz_details->title.' '.getPhrase('marks_for').' '.$academic_title[0].' '.$course_record->course_title.' '.$quiz_applicability_data->year.' '.getPhrase('year');
         }

        elseif($course_record->course_dueration<=1 && $course_record->is_having_semister!=1){
        $data['quiz_name']         = getPhrase('update').' '.$quiz_details->title.' '.getPhrase('marks_for').' '.$academic_title[0].' '.$course_record->course_title;
         }

        $data['layout']            = getLayout();
        $data['max_marks']         = $quiz_details->total_marks;
        $data['module_helper']      = getModuleHelper('offlineexams-entermarks');
        
        if(count($students))
          return view('offlineexams.marks-list', $data);

        flash('Oops...!','no_students_available', 'overlay');
        return redirect('academicoperations/offline-exams');
     
    }

   public function store(Request $request)
   { 
     if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

       if(count($this->isMarksAlreadyEntered($request)))
        {
            //Data exists, remove all data
            $this->isMarksAlreadyEntered($request, TRUE);
        }
         $marks            = new App\QuizResult();
         $quiz_id          = $request->quiz_id;
         $academic_id      = $request->academic_id;
         $course_parent_id = $request->course_parent_id;
         $course_id        = $request->course_id;
         $year             = $request->current_year;
         $semister         = $request->current_semister;
         $total_marks_records  = $request->total_marks;
         $marks_obtained   = $request->marks_obtained;
         $exam_status      = $request->exam_status;
         

         foreach ($total_marks_records as $key => $value)
          {

           $marks                   = new App\QuizResult();
           $marks->quiz_id          = $quiz_id;
           $marks->slug             = getHashCode();
           $marks->academic_id      = $academic_id;
           $marks->course_parent_id = $course_parent_id;
           $marks->course_id        = $course_id;
           $marks->year             = $year;
           $marks->semister         = $semister;
           $marks->total_marks      = $value;
           $marks->user_id          = $key;
           $marks->marks_obtained   = $marks_obtained[$key];
           $marks->negative_marks   = 0;
           $marks->percentage       = 0;
          
           if($marks_obtained[$key])
            $marks->percentage       = (($marks_obtained[$key]/$value)*100);

           $marks->exam_status      = $exam_status[$key];
           $marks->answers          = 0;
           $marks->time_spent_correct_answer_questions     = 0;
           $marks->time_spent_wrong_answer_questions       = 0;
           $marks->time_spent_not_answered_questions       = 0;
           $marks->percentage_title                        = 0;
           $marks->grade_title                             = 0;
           $marks->grade_points                            = 0;

           $marks->save();
          
          }

        flash('success','record_added_successfully', 'success');
        return redirect(URL_OFFLINE_EXAMS);

   }

   public function delete($slug)
    {
      try{
        if(!env('DEMO_MODE')) {
        Quiz::where('slug', $slug)->first()->delete();
        }
            $response['status'] = 1;
            $response['message'] = getPhrase('record_deleted_successfully');
          }
          catch(Exception $e){
            $response['status'] = 0;
           if(getSetting('show_foreign_key_constraint','module'))
            $response['message'] =  $e->getMessage();
           else
            $response['message'] =  getPhrase('this_record_is_in_use_in_other_modules');
          }
        return json_encode($response);
    }

   public function isValidRecord($record)
    {
      if ($record === null)
       {

        flash('Ooops...!', getPhrase("page_not_found"), 'error');
        return $this->getRedirectUrl();
    }

    return FALSE;
    }

    public function getReturnUrl()
    {
      return '/academicoperations/offline-exams';
    }

     /**
    * Display a page
    *
    * @return Response
    */
     public function import()
     {

        if(!checkRole(getUserGrade(2)))
        {
          prepareBlockUserMessage();
          return back();
        }
      
        $data['records']      = FALSE;
        $data['active_class'] = 'academic';
        $data['heading']      = getPhrase('import_marks');
        $data['title']        = getPhrase('import_marks');
        $data['academic_years'] = addSelectToList(getAcademicYears());
        $data['layout']       = getLayout();
        $data['module_helper']      = getModuleHelper('offlineexams-excelupload');
        return view('offlineexams.import.import', $data);
     }

     public function readExcel(Request $request)
     {
      
        $columns = array(
        'excel'  => 'bail|required',
        );
         
        $this->validate($request,$columns);

       if(!checkRole(getUserGrade(2)))
        {
          prepareBlockUserMessage();
          return back();
        }
       $success_list = [];
       $failed_list = [];

       try{
        if(Input::hasFile('excel')){
          $path = Input::file('excel')->getRealPath();
          $data = Excel::load($path, function($reader) {
          })->get();
   
          $marks_record = array();
          $marks =array();
          $isHavingDuplicate = 0;
          $role_id = getRoleData('student');
          $studentObject = new App\Student();
          if(!empty($data) && $data->count()){
            
            foreach ($data as $key => $value) {

              foreach($value as $record)
              {
                unset($marks_record);
            
                $marks_record['quiz_id'] = $record->quiz_id;
                $marks_record['roll_no'] = $record->roll_no;
               
                $marks_record['marks_obtained'] = $record->marks_obtained;
                $marks_record['total_marks']    = $record->total_marks;
                $marks_record['percentage']     = 0;
                
                if($record->total_marks)
                  $marks_record['percentage']   = getPercentage($record->marks_obtained, $record->total_marks);
                
                $marks_record['exam_status'] = $record->exam_status;
                $marks_record['academic_id'] = $record->academic_id;
                $marks_record['course_parent_id'] = $record->course_parent_id;
                $marks_record['course_id'] = $record->course_id;
                $marks_record['year'] = $record->year;
                $marks_record['semister'] = $record->semester;
                $userRecord = $studentObject->getStudentRecordWithRollNo($record->roll_no);
                
                $marks_record['user_id'] = isset($userRecord->user_id) ? $userRecord->user_id: 0;
                
                $marks_record = (object)$marks_record;
                $failed_length = count($failed_list);

                if(!$userRecord)
                {

                
                  $temp = array();
                 $temp['record'] = $marks_record;
                 $temp['type'] ='No Record exists with the roll_no';
                 $failed_list[$failed_length] = (object)$temp;
                  continue;
                }

                $failed_length = count($failed_list);
                
                if($this->isRecordExists($marks_record)>0)
                {

                  $isHavingDuplicate = 1;
                  $temp = array();
                 $temp['record'] = $marks_record;
                 $temp['type'] ='Record already exists with this combination';
                 $failed_list[$failed_length] = (object)$temp;
                  continue;
                }



                $marks[] = $marks_record;
               
              }
            
            }
              if(!env('DEMO_MODE')) {
                if($this->updateMarks($marks))
                  $success_list = $marks;
              }
          }
        }
       
       
     
       $this->excel_data['failed'] = $failed_list;
       $this->excel_data['success'] = $success_list;

       flash('success','record_added_successfully', 'success');
       $this->downloadExcel();

     }
     catch( \Illuminate\Database\QueryException $e)
     {
       if(getSetting('show_foreign_key_constraint','module'))
       {

          flash('oops...!',$e->getMessage(), 'error');
       }
       else {
          flash('oops...!','improper_sheet_uploaded', 'error');
       }
     }

        // URL_USERS_IMPORT_REPORT
       $data['failed_list']   =   $failed_list;
       $data['success_list']  =    $success_list;
       $data['records']      = FALSE;
       $data['academic_years'] = addSelectToList(getAcademicYears());
       $data['layout']      = getLayout();
       $data['active_class'] = 'academic';
       $data['heading']      = getPhrase('users');
       $data['title']        = getPhrase('report');
      
        return view('offlineexams.import.import', $data);
 
     }

 public function isRecordExists($record)
 {
    return App\QuizResult::where('quiz_id','=', $record->quiz_id)
              ->where('user_id','=',$record->user_id)
              ->count();

 }

 public function updateMarks($marks_records)
 {
      foreach ($marks_records as $record)
          {

           $marks                   = new App\QuizResult();
           $marks->quiz_id          = $record->quiz_id;
           $marks->slug             = getHashCode();
           $marks->academic_id      = $record->academic_id;
           $marks->course_parent_id = $record->course_parent_id;
           $marks->course_id        = $record->course_id;
           $marks->year             = $record->year;
           $marks->semister         = $record->semister;
           $marks->total_marks      = $record->total_marks;
           $marks->user_id          = $record->user_id;
           $marks->marks_obtained   = $record->marks_obtained;
           $marks->negative_marks   = 0;
           $marks->percentage       = $record->percentage;
          
           
           $marks->exam_status      = $record->exam_status;
           $marks->answers          = 0;
           $marks->time_spent_correct_answer_questions     = 0;
           $marks->time_spent_wrong_answer_questions       = 0;
           $marks->time_spent_not_answered_questions       = 0;
           $marks->percentage_title                        = 0;
           $marks->grade_title                             = 0;
           $marks->grade_points                            = 0;

           $marks->save();
          
          }
          return true;
 }

public function getFailedData()
{
  return $this->excel_data;
}

public function downloadExcel()
{
    Excel::create('marks_report', function($excel) {
      $excel->sheet('Failed', function($sheet) {
      $sheet->row(1, array('Reason','roll_no','quiz_id', 'academic_id','course_parent_id','course_id','year','semister', 'total_marks', 'marks_obtained', 'exam_status'));
      $data = $this->getFailedData();
      $cnt = 2;
      foreach ($data['failed'] as $data_item) {
        $item = $data_item->record;
        $sheet->appendRow($cnt++, array($data_item->type, $item->roll_no, $item->quiz_id, $item->academic_id, $item->course_parent_id, $item->course_id, $item->year, $item->semister, $item->total_marks, $item->marks_obtained, $item->exam_status));
      }
    });

    $excel->sheet('Success', function($sheet) {
           $sheet->row(1, array('roll_no','quiz_id', 'academic_id','course_parent_id','course_id','year','semister', 'total_marks', 'marks_obtained', 'exam_status'));
      $data = $this->getFailedData();
      $cnt = 2;
      foreach ($data['success'] as $data_item) {
        $item = $data_item;
        $sheet->appendRow($cnt++,array($item->roll_no, $item->quiz_id, $item->academic_id, $item->course_parent_id, $item->course_id, $item->year, $item->semister, $item->total_marks, $item->marks_obtained, $item->exam_status));
      }

    });

    })->download('xlsx');

    return TRUE;
}

/**
 * This method provides information for the 
 * exams with details like academic id, course parent id 
 * and course id with year and semister details to fill in excel
 * @param  Request $request [description]
 * @return [type]           [description]
 */
public function getOfflineExamsInformation(Request $request)
{
    $academic_id        = $request->academic_id;
    $course_parent_id   = $request->parent_course_id;
    $course_id          = $request->course_id;
    
    $semister           = 0;
    $year = 1;

    if($request->has('year'))
        $year               = $request->year;


    if($request->has('semister'))
        $semister           = $request->semister;

      
     $records = App\QuizApplicability::join('quizzes', 'quizzes.id', '=', 'quizapplicability.quiz_id')
                ->where('academic_id', '=', $academic_id)    
                ->where('course_parent_id', '=', $course_parent_id)    
                ->where('course_id', '=', $course_id)    
                ->where('year', '=', $year)    
                ->where('semister', '=', $semister)    
                ->where('quizzes.type', '=', 'offline')    
                ->select(['quizzes.id','title','total_marks','academic_id','course_parent_id','course_id','year','semister', 'start_date', 'end_date','total_marks']) 
                ->get();
    return $records;
}


}
