<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App;
use App\Http\Requests;
use DB;
use Auth;
use Exception;
class TimetableController extends Controller
{

     public function __construct()
    {
      $this->middleware('auth');
    }
    public function index()
    {
      $data['active_class']       = 'academic';
        $data['title']              = getPhrase('timetable');
        
        $data['layout']             = getLayout();
        $data['module_helper']      = getModuleHelper('timetable-dashboard');

        return view('timetable.dashboard', $data);
    }

    /**
     * This method will load the view for timetable creation
     * @return [type] [description]
     */
    public function viewTimetable()
    {
      $data['active_class']       = 'academic';
        $data['title']              = getPhrase('timetable');
        $data['academic_years']     = addSelectToList(getAcademicYears());
        $time_mapings = App\TimingsetMap::get();
        
        $data['layout']             = getLayout();


        $users = App\User::join('staff', 'user_id','=','users.id')
        
         ->where('role_id', '=',getRoleData('staff'))
        ->select(['users.id as id', 'users.name', 'image', 'job_title', 'gender', 'qualification'])
         ->get();
         
         $preferred_subjects = [];
         foreach($users as $user)
         {
            $preferred_subjects[$user->id] = $user->preferredSubjects();
         }

        $periods = App\Timingset::where('slug','=', 'daily')->first();
        $period_details = $periods->getPeriods();
        $data['right_bar']          = TRUE;
        $data['right_bar_path']     = 'timetable.timetable-allotment.item-view-right-bar';
        $data['right_bar_data']     = array(
                                            'item' => $users,

                                            );
          $data['items']              = json_encode(
                            array('source_items'  => $users,
                                'periods'   => $period_details,
                                                    'time_mapings' => $time_mapings
                                                    ));

        $data['module_helper']      = getModuleHelper('create-timetable');
        return view('timetable.timetable-allotment.timetable-view', $data);
    }

    /**
     * This method will be called by ajax call
     * This will return the particular selection for academic year,
     * course id, year and semister
     * It will return the set of staff, subject alloted to that specific 
     * academic, course and years
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getAllocatedStaffAndTimings(Request $request)
    {
        $academic_id    = $request->academic_id;
        $course_id      = $request->course_id;

        $year = 1;
        $semister = 0;
        if($request->has('year'))
            $year           = $request->year;
        if($request->has('semister'))
            $semister       = $request->semister;
         //Collect the set of staff records assigned 
        //to particular academic, course and year
        $staff_records = App\CourseSubject::join('staff', 'staff.user_id', '=', 'course_subject.staff_id')
                ->join('subjects', 'subjects.id','=', 'course_subject.subject_id')
                ->join('users', 'users.id','=', 'staff.user_id')
                ->where('users.status', '!=', 0)
                ->where('course_subject.academic_id', '=', $academic_id)
                ->where('course_subject.course_id', '=', $course_id)
                ->where('course_subject.year', '=', $year)
                ->where('course_subject.semister', '=', $semister)
                ->select(['course_subject.id as course_subject_id','staff.id as staff_main_id','staff.user_id as staff_user_id',
                'job_title', 'first_name','last_name','gender', 'qualification',
                'subject_title', 'subject_code', 'subjects.id as subject_id', 'is_lab', 'is_elective_type',
                'users.name', 'users.image'])
                ->get();

        $staff_with_allotment_records = [];
        foreach ($staff_records as $record) {
            $temp = [];
            $temp['staff_record'] = $record;
            $temp['schedule_record'] = $this->getSchedules($academic_id,0,0,0,$record->staff_user_id);
            $staff_with_allotment_records[] = $temp;

        }

        $data['staff_records'] = $staff_with_allotment_records;

       
        $scheduled_records = (object)$this->getSchedules(
                                $academic_id, 
                                $course_id, 
                                $year,
                                $semister
                                );
        
        $data['timemaps']          = $scheduled_records->timemaps;
        
        

        $data['maximum_periods_set'] = $scheduled_records->maximum_periods_set;

        return json_encode($data);

    }

    /**
     * This method will return the detailed scheduled report for the week
     * with all users or a specific user
     * @param  [type]  $academic_id [description]
     * @param  [type]  $course_id   [description]
     * @param  integer $year        [description]
     * @param  integer $user_id     [description]
     * @return [type]               [description]
     */
    public function getSchedules($academic_id =1, $course_id=1, $year=1,$semister=0, $user_id = 0)
    {
   
        //Collect the set of mapping records for particular
        //academic year, course and year
        $map_records = App\TimingsetMap::
                        join('timingset', 'timingset.id', '=', 'timingset_id');
      
        $map_records = $map_records->select(['timingsetmap.id as map_id', 'timingset.id as timingset_id', 'timingsetmap.day','name as timeset_name'])
                        ->get();

        $timemaps = [];
        $days = [];

        //Find the maximum periods per day
        $maximum_periods_in_day = [];
        foreach($map_records as $record)
        {
            $days[] = array('day_id' => $record->day, 'day'=>getDay($record->day));
            $timemaps[$record->day]['record'] = $record;
            $timeset_details = App\TimingsetDetails::
                                where('timingset_id', '=', $record->timingset_id)
                                ->select(['id', 'period_name', 'start_time', 'end_time', 'is_break','timingset_id'])
                                ->get();
            if(count($timeset_details)>count($maximum_periods_in_day))
                $maximum_periods_in_day = $timeset_details;

            $timemaps[$record->day]['timeset'] = $timeset_details;
            $period_details = [];
           
           //Prepare the list of classes/periods available with detailed view
            foreach($timeset_details as $details) {
           
            $timetable_record = App\Timetable::
                      join('users', 'users.id', '=', 'timetable.user_id')
                      ->join('staff', 'users.id', '=', 'staff.user_id')
                      ->join('subjects', 'subjects.id', '=', 'timetable.subject_id');
            if($user_id == 0) {
             $timetable_record = $timetable_record
                      ->where('timetable.academic_id', '=', $academic_id)
                      ->where('timetable.course_id', '=', $course_id)
                      ->where('timetable.year', '=', $year)
                      ->where('timetable.semister', '=', $semister);
 
            }
            $timetable_record = $timetable_record->where('day', '=', $record->day)
                      ->where('timetable.academic_id', '=', $academic_id)
                      ->where('timingset_id', '=', $record->timingset_id)
                      ->where('timingset_map_id', '=', $record->map_id)
                      ->where('timingset_details_id', '=', $details->id);
            
            if($user_id!=0)
            $timetable_record = $timetable_record->where('timetable.user_id','=', $user_id);
            $timetable_record = $timetable_record->select([
                'timetable.academic_id as academic_id', 
                'timetable.course_id as course_id', 
                'timetable.year as year',
                'timetable.day as day',
                'timetable.timingset_id as timingset_id',
                'timetable.timingset_map_id as timingset_map_id',
                'timetable.timingset_map_id as map_id',
                'timetable.user_id as staff_id',
                'timetable.subject_id as subject_id',
                'users.id as user_id',
                'users.name',
                'users.image',
                'subjects.subject_title',
                'subjects.subject_code',
                'subjects.is_lab',
                'subjects.is_elective_type as is_elective',
                ]);
            $timetable_record = $timetable_record->first();
            $period_details['is_assigned'] = ($timetable_record) ? 1 : 0;
            $period_details['day_number'] = $record->day;
            $period_details['user_id'] = 
                            ($timetable_record) ? $timetable_record->user_id :null;
            $period_details['academic_id'] = 
                            ($timetable_record) ? $timetable_record->academic_id :null;
            $period_details['course_id'] = 
                            ($timetable_record) ? $timetable_record->course_id :null;
            $period_details['year'] = 
                            ($timetable_record) ? $timetable_record->year :null;
            $period_details['semister'] = 
                            ($timetable_record) ? $timetable_record->semister :null;
            
            $period_details['staff_id'] = 
                            ($timetable_record) ? $timetable_record->staff_id :null;

            $period_details['name'] = ($timetable_record) ? $timetable_record->name :null;
            $period_details['image'] = ($timetable_record) ? $timetable_record->image :null;
            $period_details['subject_id'] = ($timetable_record) ? $timetable_record->subject_id :null;
            $period_details['subject_title'] = ($timetable_record) ? $timetable_record->subject_title :null;
            $period_details['subject_code'] = ($timetable_record) ? $timetable_record->subject_code :null;
            $period_details['is_lab'] = ($timetable_record) ? $timetable_record->is_lab :null;;
            $period_details['is_elective'] = ($timetable_record) ? $timetable_record->is_elective :null;
            $period_details['is_break'] = $details->is_break;
            $period_details['period_name'] = $details->period_name;

            $period_details['id'] = 
                                    $academic_id
                                    .'_'.$course_id
                                    .'_'.$year
                                    .'_'.$semister
                                    .'_'.$record->day
                                    .'_'.$record->timingset_id
                                    .'_'.$record->map_id
                                    .'_'.$details->id;


            if($user_id==0) {
                $period_details['course_title'] = $this->prepareCourseTitle($academic_id,$course_id, $year, $semister);
               

            }
            else {

            $period_details['course_title'] = $this->prepareCourseTitle($period_details['academic_id'], $period_details['course_id'], $period_details['year'], $period_details['semister']);

                 $period_details['id'] = 
                                    $period_details['academic_id']
                                    .'_'.$period_details['course_id']
                                    .'_'.$period_details['year']
                                    .'_'.$period_details['semister']
                                    .'_'.$record->day
                                    .'_'.$record->timingset_id
                                    .'_'.$record->map_id
                                    .'_'.$details->id;


            }
            $timemaps[$record->day]['periods'][] = $period_details;
            }
        }

         $data['days'] = $days;
       
        $data['timemaps'] = $timemaps;

        $data['maximum_periods_set'] = $maximum_periods_in_day;
        return $data;
    }


    public function prepareCourseTitle($academic_id, $course_id, $year=1, $semister=0)
    {
        $course_title = '';
        if(!$course_id)
            return $course_title;
       $course_title = '';
        if(!$academic_id)
            return $course_title;
        $academic_record = App\Academic::where('id','=',$academic_id)->first();
        
        if(!$academic_record)
            return $course_title;

        $course_record = App\Course::where('id','=',$course_id)->first();
        if(!$course_record)
            return $course_title;

        $course_title = '('.$academic_record->academic_year_title.')'.$course_record->course_title;
        if($course_record->course_dueration>1)
            $course_title .=  ' '.$year;
        if($course_record->is_having_semister && $semister !=0)
            $course_title .= '-'.$semister;
        return $course_title;
    }

    /**
     * Create or update the time table
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateTimetable(Request $request)
    {
        $academic_id    = $request->academic_id;
        $course_id      = $request->course_id;
        $subjects       = $request->subject;
        $current_year   = 1;
        $current_semister = 0;

        if($request->has('current_year'))
            $current_year   = $request->current_year;
         if($request->has('current_semister'))
            $current_semister = $request->current_semister;

         if($academic_id==''||$course_id==''||$current_year=='')
         {
         flash('Oops...!','Please Selcet the details', 'overlay');
        return redirect('timetable/allot-timetable');  
       }

       

        $table_elements = $request->staff;
        DB::beginTransaction();
        try{
        foreach($table_elements as $code => $user_id)
        {
            $decoded_items          = (object) $this->decodeObject($code);
            $day                    = $decoded_items->day;
            $timingset_id           = $decoded_items->timingset_id;
            $timingset_map_id       = $decoded_items->timingset_map_id;
            $timingset_details_id   = $decoded_items->timingset_details_id;
            
            $subject_id = $subjects[$code];

            //Try to get the timetable record with all the above data
            //If the record exists, edit and update the record
            //If not exists, insert the new record
            //Record available in db and no data submitted with the post method
            //Delete that record.
            /**
             * Steps
             * 1) Fetch the record
             * 2) If Record and $user_id is not NULL, Update the record
             * 3) If Record is NULL and user_id is not NULL, Insert the record
             * 4) If Record is not NULL and user_id is NULL, Delete the record
             * 5) If Record is NULL and user_id is NULL, ignore that record
             * 6) Repeat STEP 1
             */
            //1st Step
            $record = App\Timetable::where('academic_id', '=', $academic_id)
                      ->where('course_id', '=', $course_id)
                      ->where('year', '=', $current_year)
                      ->where('semister', '=', $current_semister)
                      ->where('day', '=', $day)
                      ->where('timingset_id', '=', $timingset_id)
                      ->where('timingset_map_id', '=', $timingset_map_id)
                      ->where('timingset_details_id', '=', $timingset_details_id)
                      ->first();

           if($record)
           {
            
            //Record Exists
            if($user_id)
            {

                //2nd Step
                //User is available
                
                $record->user_id = $user_id;
                $record->subject_id = $subject_id;
                $record->timingset_details_id = $timingset_details_id;
                $record->save();
            }
            else
            {
                //4th step
                //Record Available, User Not availabe
              if(!env('DEMO_MODE')) {
                $record->delete();
              }
            }
           
           }
           else
           {
            if($user_id!='')
            {
                //3rd Step 
                //Record not available, insert new record
                $record = new App\Timetable();
                $record->academic_id = $academic_id;
                $record->course_id = $course_id;
                $record->year = $current_year;
                $record->semister = $current_semister;
                $record->day = $day;
                $record->timingset_id = $timingset_id;
                $record->timingset_map_id = $timingset_map_id;
                $record->timingset_details_id = $timingset_details_id;
                $record->user_id = $user_id;
                $record->subject_id = $subject_id;
                $record->save();
            }
            
           }
        
        }
    
        flash('success','record_updated_successfully', 'success');
        DB::commit();
       }
     catch(Exception $e)
     {
      DB::rollBack();
       if(getSetting('show_foreign_key_constraint','module'))
       {

          flash('oops...!',$e->getMessage(), 'error');
       }
       else {
          flash('oops...!','improper_data_submitted', 'error');
       }
     }
      return redirect(URL_TIMETABLE_VIEW);        
     }

     /**
      * This method verifies if the staff is busy or not for the specific day and time
      * It returns the message and status information
      * @param  Request $request [description]
      * @return [type]           [description]
      */
     public function checkStaffIsAvailable(Request $request)
     {
        $data   = (object) $this->decodeObject($request->id);
        $record = App\Timetable::
                         where('academic_id', '=', $data->academic_id)
                      //->where('course_id', '=', $data->course_id)
                      //->where('year', '=', $data->year)
                      
                      ->where('day', '=', $data->day)
                      ->where('timingset_id', '=', $data->timingset_id)
                      ->where('timingset_map_id', '=', $data->timingset_map_id)
                      ->where('timingset_details_id', '=', $data->timingset_details_id)
                      ->where('user_id', '=', $request->user_id)
                      ->first();
        $result['status'] = 1;
        $result['message'] = '';
        if($record)
        {
            $result['status'] = 0;
            $result['message'] = 'Ooops..! '.getPhrase('staff_is_busy_for_that_slot');
        }
        return json_encode($result);
     }

    /**
     * $code contains the elements in the below format saperated by _
     * 0-academic_id, 1-course_id, 2-current_year, 3-day, 
     * 4-timingset_id, 5-timingset_map_id, 6-timingset_details_id(period_id)
     * @var [type]
     */
     public function decodeObject($code)
     {

        $index_academic_id = 0;
        $index_course_id = 1;
        $index_year = 2;
        $index_semester = 3;
        $index_day = 4;
        $index_timingset_id = 5;
        $index_timingset_map_id = 6;
        $index_period_id = 7;

        $elements               = explode('_',$code);
        $data['academic_id']    = $elements[$index_academic_id];
        $data['course_id']      = $elements[$index_course_id];
        $data['year']           = $elements[$index_year];
        $data['semister']       = $elements[$index_semester];
        $data['day']            = $elements[$index_day];
        $data['timingset_id']   = $elements[$index_timingset_id];
        $data['timingset_map_id'] = $elements[$index_timingset_map_id];
        $data['timingset_details_id'] = $elements[$index_period_id];

        return $data;
     }

     /**
      * This method will load the timetable of specific user based on the provided slug
      * @param  [type] $slug [description]
      * @return [type]       [description]
      */
     public function staffTimetable($slug)
     {
        
        
        $user_record = App\User::where('slug', '=', $slug)->first();
        $user       = $user_record;
        if($isValid = $this->isValidRecord($user_record))
            return redirect($isValid);

        $academic_id    = getDefaultAcademicId();
        $course_id      = 0;
        $year           = 0;
        $semister       = 0;
        $notes          = '';
        $timetable_title = '';

        $role = getRoleData($user_record->role_id);

        if($role=='staff')
        {
            $user_id        = $user_record->id;
            $timetable_title = getPhrase('timetable_for'). ' '.ucfirst($user_record->name);

                                
        }

        if($role=='student')
        {
            $user_id        = 0;
            $record         = prepareStudentSessionRecord($slug);
            $academic_id    = $record->student->academic_id;
            $course_id      = $record->student->course_id;
            $year           = $record->student->current_year;
            $semister       = $record->student->current_semister;


           $academic_record = App\Academic::where('id', '=', $academic_id)
                              ->select('academic_year_title')->first();
           $course_record = App\Course::where('id', '=', $course_id)
                            ->select(['id','parent_id','course_title','course_dueration', 'is_having_semister'])->first();
            
           $course_parent_record = App\Course::where('id', '=', $course_record->parent_id)
                            ->select('course_title')->first();


             $timetable_title         = getPhrase('timetable_for')
                                .' '.$academic_record->academic_year_title
                                .' '.$course_parent_record->course_title
                                .' '.$course_record->course_title;
        if($course_record->course_dueration>1) {                                
            $timetable_title .= ' '.$year;
        }

        if($course_record->is_having_semister && $semister) {                                
            $timetable_title .= ' Sem '. $semister;
        }

        }



        if($role!='staff')
        $data['active_class']       = 'academic';
        else
        $data['active_class']       = 'timetable';
            
        $data['title']              = getPhrase('timetable');
        $data['user']               = $user;
        $data['role']               = $role;
        $data['record']               = $user_record;
        
        $allocated_periods = [];
        if($user_id)
        {
            //Print Staff Timetable
            $allocated_periods = $this->getSchedules($academic_id,0,0,0,$user_id);
        }
        else{
            //Print Class timetable
         $allocated_periods = $this->getSchedules(
                                $academic_id,
                                 $course_id,
                                $year,
                                $semister,
                                $user_id);
        }

        // dd($allocated_periods);
        $days = getDay();
        $data['allocated_periods']  = json_encode($allocated_periods);
        
        $data['layout']             = getLayout();
        if($user_id) {
            $data['right_bar']          = TRUE;
            $data['right_bar_path']     = 'timetable.user-timetables.item-view-right-bar';
            $data['right_bar_data']     = array(
                                                'item' => [],
                                                );
        }
        return view('timetable.user-timetables.timetable-staff-view', $data);         
     }

     /**
      * This method will print the timetable along with the instructions 
      * entered by user
      * @param  Request $request [description]
      * @return [type]           [description]
      */
     public function printTimetable(Request $request)
     {

        $academic_id    = $request->academic_id;
        $course_id      = $request->course_id;
        $year           = $request->year;
        $semister           = $request->semister;
        $notes          = $request->notes;
        $user_id        = ($request->has('user_id')) ? $request->user_id : 0;

        $academic_record = App\Academic::where('id', '=', $academic_id)
                          ->select('academic_year_title')->first();
       $course_record = App\Course::where('id', '=', $course_id)
                        ->select(['id','parent_id','course_title','course_dueration', 'is_having_semister'])->first();
        
       $course_parent_record = App\Course::where('id', '=', $course_record->parent_id)
                        ->select('course_title')->first();
       

       $data['academic_record'] = $academic_record;
       $data['course_record']   = $course_record;
       $data['course_parent_record'] = $course_parent_record;
       $data['year']            = $year;
       $data['semister']        = $semister;
       $timetable_title         = getPhrase('timetable_for')
                                .' '.$academic_record->academic_year_title
                                .' '.$course_parent_record->course_title
                                .' '.$course_record->course_title;
        if($course_record->course_dueration>1) {                                
            $timetable_title .= ' '.$year;
        }

        if($course_record->is_having_semister && $semister) {                                
            $timetable_title .= ' Sem '. $semister;
        }
       $data['timetable_title'] = $timetable_title;
       $data['active_class']       = 'academic';
       $data['title']              = getPhrase('timetable');
        $days = getDay();
       
        if($user_id)
        {
            //Print Staff Timetable
            $allocated_periods = (object)$this->getSchedules(0,0,0,0,$user_id);
        }
        else{
            //Print Class timetable
         $allocated_periods = (object)$this->getSchedules(
                                $academic_id,
                                 $course_id,
                                $year,
                                $semister,
                                $user_id);
        }
        $data['allocated_periods']  = $allocated_periods;
        $data['layout']             = getLayout();
        $data['notes']             = $notes;
         $view = \View::make('timetable.printable-template.template',$data);
          $contents = $view->render();
          return $contents;
        
      }

      /**
       * This method identifies the user type logged in and prints the appropriate timetable
       * for logged in user
       * @param  [type] $slug [description]
       * @return [type]       [description]
       */
      public function printStaffStudentTimetable($slug)
      { 

        $user_record = App\User::where('slug', '=', $slug)->first();
        if($isValid = $this->isValidRecord($user_record))
            return redirect($isValid);

        $academic_id    = getDefaultAcademicId();
        $course_id      = 0;
        $year           = 0;
        $semister       = 0;
        $notes          = '';
        $timetable_title = '';

        $role = getRoleData($user_record->role_id);
        if($role=='staff')
        {
            $user_id        = $user_record->id;
            $timetable_title = getPhrase('timetable_for'). ' '.ucfirst($user_record->name);


                                
        }

        if($role=='student')
        {

            $user_id        = 0;
            $record         = prepareStudentSessionRecord($slug);
            if(!$record->student->roll_no)
            {
                 flash('Oops...!','Student Roll Number Is Not Generated', 'overlay');
                 return redirect(URL_USER_DETAILS.$user_record->slug);
            }
            $academic_id    = $record->student->academic_id;
            $course_id      = $record->student->course_id;
            $year           = $record->student->current_year;
            $semister       = $record->student->current_semister;


           $academic_record = App\Academic::where('id', '=', $academic_id)
                              ->select('academic_year_title')->first();
           $course_record = App\Course::where('id', '=', $course_id)
                            ->select(['id','parent_id','course_title','course_dueration', 'is_having_semister'])->first();
            
           $course_parent_record = App\Course::where('id', '=', $course_record->parent_id)
                            ->select('course_title')->first();


             $timetable_title         = getPhrase('timetable_for')
                                .' '.$academic_record->academic_year_title
                                .' '.$course_parent_record->course_title
                                .' '.$course_record->course_title;
        if($course_record->course_dueration>1) {                                
            $timetable_title .= ' '.$year.' '.getPhrase('year');
        }

        if($course_record->is_having_semister && $semister) {                                
            $timetable_title .= ' '. $semister.' '.getPhrase('semister');
        };

        }
      
       $data['timetable_title'] = $timetable_title;
       $data['active_class']       = 'academic';
       $data['title']              = getPhrase('timetable');
        $days = getDay();
       
        if($user_id)
        {
            //Print Staff Timetable
            $allocated_periods = (object)$this->getSchedules($academic_id,0,0,0,$user_id);
          
           if(!count($allocated_periods->timemaps[1]['timeset'])) {
             flash('Oops...!','Time table is not allocated for you', 'overlay');
             return back();
          }
        
        }
        else{
            //Print Class timetable
         $allocated_periods = (object)$this->getSchedules(
                                $academic_id,
                                $course_id,
                                $year,
                                $semister,
                                $user_id);
        }
        if(!count($allocated_periods->timemaps[1]['timeset'])){
          flash('Oops...!','Time table is not created for your class', 'overlay');
          return back();
        }
           
        $data['allocated_periods']  = $allocated_periods;
        $data['layout']             = getLayout();
        $data['notes']             = $notes;
        // return view('timetable.printable-template.template', $data); 
        
        $view = \View::make('timetable.printable-template.template',$data);
            $contents = $view->render();

            return $contents;

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
        return PREFIX;
    }
}
