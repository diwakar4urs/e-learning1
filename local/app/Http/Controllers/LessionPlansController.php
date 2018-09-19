<?php

namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Subject;
use App\Student;
use App\Course;
use App\User;
use App\Academic;
use Yajra\Datatables\Datatables;
use DB;
use Input;
use Auth;
use Charts;
 

class LessionPlansController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    /**
     * This method fetches the list of subjects alotted to a staff
     *
     * @param      <type>  $slug   The slug
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function index($slug)
    {

      $user = App\User::where('slug','=',$slug)->first();


      if($isValid = $this->isValidRecord($user))
        return redirect($isValid);

      if(!checkRole(getUserGrade(3)))
      {
        prepareBlockUserMessage();
        return back();
      }
      
  if(!isEligible($slug))
          return back();

       $subjects = App\LessionPlan::getSubjects($user->id);
      
        $role_name                  = getRoleData($user->role_id);

        if($role_name!='staff')
        $data['active_class']       = 'academic';
        else
        $data['active_class']       = 'lession';

        $data['user']               = $user;
        $data['record']               = $user;
        $data['subjects']           = $subjects;
        $data['title']              = getPhrase('lesson_plans');
        $data['layout']             = getLayout();

        if(count($subjects))
        return view('staff.lessionplans.dashboard', $data);
          
             flash('Oops...!','no_data_available', 'overlay');

        return redirect (URL_USERS."staff");
        }
        

        /**
         * This method will display the list of students according staff allocated class
         * @param  [type] $slug [description]
         * @return [type]       [description]
         */
        public function studentlist($slug)
    {
      
      $user = App\User::where('slug','=',$slug)->first();

      if($isValid = $this->isValidRecord($user))
        return redirect($isValid);

      if(!checkRole(getUserGrade(11)))
      {
        prepareBlockUserMessage();
        return back();
      }
      
  if(!isEligible($slug))
          return back();


      $subjects = App\CourseSubject::join('subjects', 'subjects.id','=','course_subject.subject_id')
      ->join('courses','courses.id','=','course_subject.course_id')
      ->where('staff_id','=',$user->id)
      ->where('course_subject.academic_id','=',getDefaultAcademicId())

      ->select(['course_subject.id as id','course_subject.slug as slug', 'subject_title', 'course_title', 'year', 'semister', 'subject_id','staff_id','course_dueration','course_subject.academic_id as academic_id','course_subject.course_parent_id as course_parent_id','course_subject.course_id as course_id'])
      ->orderBy('year')
      ->orderBy('semister')
      ->get();
      


       $role_name                  =getRoleData($user->role_id);

        if($role_name!='staff')
        $data['active_class']       = 'academic';
        else
        $data['active_class']       = 'lession';

        $data['user']               = $user;
        $data['subjects']           = $subjects;
        $data['title']              = getPhrase('students_dashboard');
        $data['layout']             = getLayout();

        if(count($subjects)){
        return view('staff.lessionplans.studentlist-dashboard', $data);
        }
        else{
             flash('Oops...!','no_data_available', 'overlay');
             return back();
            }
        }


      /**
       * This method is display the students in staff lession plans dashboard
       * @param  [type] $userSlug          [description]
       * @param  [type] $courseSubjectSlug [description]
       * @return [type]                    [description]
       */
      

      public function viewStudents(Request $request)
     {

      //Check the user Grade
      if(!checkRole(getUserGrade(3)))
      {
        prepareBlockUserMessage();
        return back();
      }
      
    $course_time =  App\Course::where('id','=',$request->course_id)->select('course_dueration')->first();
    $academic_title =  App\Academic::where('id','=',$request->academic_id)->select('academic_year_title')->first();
    $course_name = App\Course::where('id','=',$request->course_id)->select('course_title')->first();     
    $branch_name = App\Course::where('id','=',$request->course_parent_id)->select('course_code')->first();     

        $data['active_class']       = 'academic';
        $data['title']              = getPhrase('student_list');
        $data['academic_id']        = $request->academic_id;
        $data['course_parent_id']   = $request->course_parent_id;
        $data['course_id']          = $request->course_id;
        $data['year']               = $request->year;
        $data['semister']           = $request->semister;
        $data['course_time']        = $course_time;
        $data['layout']             = getLayout();
        if($course_time->course_dueration!=1)

        $data['title']              = $academic_title->academic_year_title.' '.$branch_name->course_code.' '.
        $course_name->course_title.' '.$request->year.' '.getPhrase('year').' '.$request->semister.' '.getPhrase('semester').' '.getPhrase('students');

        else

        $data['title']              = $academic_title->academic_year_title.' '.$course_name->course_title.' '.getPhrase('students');
         
      return view('staff.lessionplans.student-list', $data);
       
   }


   public function getDatatable($academic_id, $course_parent_id, $course_id, $year, $semister)

    {    
        $records = array();

        $records = App\Student::join('users','users.id','=','students.user_id')
        ->join('courses','courses.id','=','students.course_id')

        ->select(['students.academic_id','students.course_parent_id','students.course_id','students.first_name','students.last_name','users.image','students.roll_no','courses.course_title','users.email'])

        ->where('students.academic_id',      '=',$academic_id)
        ->where('students.course_parent_id', '=',$course_parent_id)
        ->where('students.course_id',        '=',$course_id)
        ->where('students.current_year',     '=',$year)
        ->where('students.current_semister', '=',$semister)

        ->orderBy('students.updated_at','desc')->get();

         $course_time =  App\Course::where('id','=',$course_id)->select('course_dueration')->first();

        return Datatables::of($records)
        
         ->editColumn('first_name', function($records) {
          $data ='';
          $data = $records->first_name.' '.$records->last_name;
          return $data;
          
        })        
         ->editColumn('image', function($records){
            return '<img src="'.getProfilePath($records->image).'"  />';
        })
         ->editColumn('current_year',function($records){
          $data = '';
          $data=$records->current_year.' '.'-'.' '.$records->current_semister;
          return $data;
         })


 
        ->removeColumn('academic_id')
        ->removeColumn('course_parent_id')
        ->removeColumn('course_id')
        ->removeColumn('last_name')
        ->removeColumn('current_semister')
         
        ->make();
    }


   

    /**
     * Thid method returns the related topics of the user for the assigned subject
     *
     * @param      <type>  $userSlug           The user slug
     * @param      <type>  $courseSubjectSlug  The course subject slug
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function viewTopics($userSlug, $courseSubjectSlug)
    {

      //Check the user Grade
      if(!checkRole(getUserGrade(3)))
      {
        prepareBlockUserMessage();
        return back();
      }
      
      //*********VALIDATING THE USER START*****************//
      //Make sure that the user is accessing only his record apart from admin/owner
    if(!isEligible($userSlug)) {
      return back();
    }
    

      $user = App\User::where('slug','=',$userSlug)->first();

      if($isValid = $this->isValidRecord($user))
        return redirect($isValid);

      $courseSubjectRecord = App\CourseSubject::where('slug','=',$courseSubjectSlug)->first();
       
      if($isValid = $this->isValidRecord($courseSubjectRecord))
        return redirect($isValid);
      
      //Make sure the user got alotted the subject for him only
      if($courseSubjectRecord->staff_id!=$user->id)
      {
        flash('Ooops...!', getPhrase("page_not_found"), 'error');
        return back();
      }

      //*********VALIDATING THE USER END*****************//
       
      $courseRecord = App\Course::where('id','=',$courseSubjectRecord->course_id)->first();
      $subjectRecord = App\Subject::where('id','=', $courseSubjectRecord->subject_id)->first();

      $available_records = App\LessionPlan::where('course_subject_id', '=', $courseSubjectRecord->id)->get();
      
      
      $topics = $this->prepareTopicsList($courseSubjectRecord->subject_id, $courseSubjectRecord->id);
           

       if(!count($topics)){
       flash('Oops...!','no_topics availble', 'overlay');
        return redirect('staff/lession-plans/'.$user->slug);
         }
    
      $data['items']      = json_encode(
                    array(  'topics'      => $topics, 
                        'available_records' => $available_records)
                      );
      $data['subject_record']   = $subjectRecord;
      $data['user']             =$user; 
        $role_name                  =getRoleData($user->role_id);
       if($role_name!='staff')
        $data['active_class']       = 'academic';
        else
        $data['active_class']       = 'lession';
        
        $data['role_name']       = getRoleData(Auth::user()->role_id);

      
      $data['title']              = getPhrase('lesson_plans_for').' '.$subjectRecord->subject_title;
      $data['layout']              = getLayout();
      return view('staff.lessionplans.topics', $data);
       
   }

   /**
    * This method prepares  the list of topics and child topics and returns an array
    * @param  [type] $subject_id      [description]
    * @param  [type] $courseSubjectId [description]
    * @return [type]                  [description]
    */
   public function prepareTopicsList($subject_id, $courseSubjectId)
   {
     $parent_topics = $this->getTopicRecord($subject_id, 0,0);

      $topics = [];
      foreach($parent_topics as $topic)
      {

        $topics[$topic->id] = $topic;
        $topics[$topic->id]['course_subject_id'] = $courseSubjectId;

        $subject_topics_list = App\Topic::where('parent_id','=',$topic->id)->get()->toArray();
        $lession_plan_topics = App\LessionPlan::where('course_subject_id','=',$courseSubjectId)
                                                ->get()->toArray();
        $topics[$topic->id]['childs'] = $this->prepareChildRecords($subject_topics_list, $lession_plan_topics);
      }
     
      return $topics;
   }

   public function prepareChildRecords($topics_list, $lession_plan_list)
   {
    $final_records = [];
     $child_topics = [];
     foreach($topics_list as $topic)
     {
      $topic = (object)$topic;
      $child_topics['id'] = $topic->id;
      $child_topics['topic_name'] = $topic->topic_name;
      $completed_status = 0;
      $completed_date = '';

      foreach($lession_plan_list as $plan_record)
      {
        $plan_record = (object)$plan_record;
        if($topic->id == $plan_record->topic_id)
        {
          $completed_status = ($plan_record->is_completed) ? 1 : 0;
          $completed_date = $plan_record->completed_on;
        }
      }
      $child_topics['is_completed'] = $completed_status;
      $child_topics['completed_on'] = $completed_date;
      $final_records[] = $child_topics;
     }
     return $final_records;
   }

   /**
    * This method returns the specific topics based on the condition
    *
    * @param      <type>   $subject_id  The subject identifier
    * @param      integer  $parent_id   The parent identifier
    *
    * @return     <type>   The topic record.
    */
   public function getTopicRecord($subject_id, $parent_id = 0, $courseSubjectId = 0 )
   {
 
    $result = App\Topic::join('subjects', 'subjects.id','=','topics.subject_id')
      ->leftJoin('lessionplans','topic_id','=','topics.id');
   

      $result = $result->where('subjects.id', '=',$subject_id)
      ->where('topics.parent_id', '=', $parent_id)
      ->select(['topics.id as id', 'topic_name','lessionplans.is_completed','completed_on'])
      ->groupBy(['topics.id'])->get();
      return $result;




   }


   public function updateTopic(Request $request)
   {
    $topic_id           = $request->topic_id;
    $course_subject_id  = $request->course_subject_id;
    $is_completed       = $request->status;

    $record = App\LessionPlan::where('course_subject_id', '=', $course_subject_id)
    ->where('topic_id', '=', $topic_id)->first();
    $status = 0;
    if($record)
    {
      //Record already exists, just update that record
      $record->course_subject_id  = $course_subject_id;
      $record->topic_id       = $topic_id;
      $record->is_completed     = $is_completed;
      $record->completed_on     = date('Y-m-d');

      $record->save();
      $status = 1;
    }
    else {
      //Record not available, create new record with the data
      $record = new App\LessionPlan();
      $record->course_subject_id  = $course_subject_id;
      $record->topic_id       = $topic_id;
      $record->is_completed     = $is_completed;
      $record->completed_on     = date('Y-m-d');
      $record->save();
      $status = 1;
    }
    $topics = [];
    $course_subject_record = App\CourseSubject::where('id','=',$record->course_subject_id)->first();
    $topics = $this->prepareTopicsList($course_subject_record->subject_id, $course_subject_record->id);

    return array('status'=>$status, 'topics'=>$topics);
   }

    public function isValidRecord($record)
    {
      if ($record === null) {

        flash('Ooops...!', getPhrase("page_not_found"), 'error');
        return $this->getRedirectUrl();
    }

    return FALSE;
    }

    public function getReturnUrl()
    {
      return URL_LESSION_PLANS_DASHBOARD;
    }

    /**
     * This method will return
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getLastUpdatedRecords(Request $request)
    {
      $id = $request->id;
      $subject_id = $request->subject_id;
      $user_id = $request->user_id;

      $timetableObject = new App\Timetable();
      $decoded_items = (object) $timetableObject->decodeObject($id);
      $topics = App\CourseSubject::join('lessionplans', 'course_subject.id', '=', 'lessionplans.course_subject_id')
      ->join('subjects', 'subjects.id', '=', 'course_subject.subject_id')
      ->join('topics', 'topics.id', '=', 'lessionplans.topic_id')
      ->where('course_subject.staff_id', '=', $user_id)
      ->where('course_subject.subject_id', '=', $subject_id)
      
      ->select(['topics.topic_name', 'subject_title', 'lessionplans.is_completed', 'lessionplans.completed_on'])
      ->orderBy('lessionplans.completed_on', 'desc')
      ->get();

      return json_encode($topics);
    }


}
