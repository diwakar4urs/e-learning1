<?php
namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\CourseSubject;
use App\Academic;
use Yajra\Datatables\Datatables;
use DB;
use Exception;

class CourseSubjectsController extends Controller
{
    public $current_slug = '';


         
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function setSlug($slug)
    {
        $this->current_slug = $slug;
    }

    public function getSlug()
    {
        return $this->current_slug;
    }

    /**
     * Default method
     * loads the list of available academics and courses 
     * based on subjects are alloted to them
     * @return [type] [description]
     */
	public function index($slug='courses')
    {
        $expected_slugs = ['courses', 'staff'];
        
        if(!in_array($slug, $expected_slugs))
            $slug = 'courses';

        $data['active_class']       = 'master_settings';
        $data['slug']               = $slug;
        $data['title']              = getPhrase('allocate_staff_to_courses');
        $data['layout']             = getLayout();
        $data['module_helper']      = getModuleHelper('courses-list-for-staff');

    	return view('mastersettings.course-subjects.list', $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable($slug)
    {
        
        $this->setSlug($slug);
        
         $records = CourseSubject::join('academics','academics.id','=','course_subject.academic_id')
         ->select(['academics.academic_year_title','academic_id', 'course_parent_id', 'course_id', 'course_subject.id'])
         ->groupBy('academic_id')
         ->groupBy('course_id');
        
        return Datatables::of($records)
        ->addColumn('action', function ($records) {
         

            return '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                         <li><a href="'.URL_MASTERSETTINGS_COURSE_SUBJECTS_GET_COURSE_SUBJECTS_SHOW.$records->academic_id.'/'.$records->course_id.'"><i class="icon-eye"></i>'.getPhrase("view").'</a></li>

                          <li><a href="'.URL_COURSE_SUBJECTS_ADD_STAFF.$records->academic_id.'/'.$records->course_id.'"><img src="'.IMAGE_TEACHER_ICON.'">'.getPhrase("allocate_staff").'</a></li>
                         
                            
                            
                            <li><a href="javascript:void(0);" onclick="deleteRecordCustom('.$records->academic_id.','.$records->course_id.');"><i class="fa fa-trash"></i>'. getPhrase("delete").'</a></li>
                        </ul>
                    </div>';
            })
        
        ->editColumn('academic_year_title',function($records)
        {
            $type = $this->getSlug();
           if($type=='courses')
           {
            return '<a href="'.URL_MASTERSETTINGS_COURSE_SUBJECTS_ADD.$records->slug.'">'.$records->academic_year_title.'</a>';
           }
            return '<a href="'.URL_COURSE_SUBJECTS_ADD_STAFF.$records->academic_id.'/'.$records->course_id.'">'.$records->academic_year_title.'</a>';
        })
        ->editColumn('course_parent_id', function($records){
            return App\Course::find($records->course_parent_id)->course_title;
        })
        ->editColumn('course_id', function($records){
            return App\Course::find($records->course_id)->course_title;
        })
      ->removeColumn('id')
      ->removeColumn('academic_id')
        ->make();
    }

     /**
     * This method loads the create view
     * @return void
     */
    public function create()
    {
        $data['record']             = FALSE;
        $data['active_class']       = 'master_settings';
        $data['items']              = json_encode(array('source_items'=>null,'target_items'=>null));
        $data['academic_years']     = addSelectToList(getAcademicYears());
        $data['layout']             = getLayout();
        $data['loadYears']          = FALSE;
        $data['keys']               = [];
        $data['title']              = getPhrase('add_subjects_to_course');
        $data['module_helper']      = getModuleHelper('allocate-subjects');
        return view('mastersettings.course-subjects.add-edit', $data);
    }

    /**
     * This method loads the year and semister details with subjects blocks
     * @return [type] [description]
     */
    public function loadYearDetails(Request $request)
    {
        $data['record']         	= FALSE;
    	$data['active_class']       = 'master_settings';
        $data['loadYears']             = TRUE;

         $subjects = App\Subject::where('status', '=', 'Active')->select(['id','subject_title','subject_code','maximum_marks','is_lab','is_elective_type'])->get();


        
        $data['right_bar']          = TRUE;
        $data['right_bar_path']     = 'mastersettings.course-subjects.item-view-right-bar';
        $data['right_bar_data']     = array(
                                            'item' => $subjects,
                                            );
 
    	$data['academic_years']     = addSelectToList(\App\Academic::pluck('academic_year_title', 'id'));
        $data['layout']             = getLayout();

    	$data['title']              = getPhrase('add_subjects_to_course');

        $academic_id = $request->academic_id;
        $course_id = $request->course_id;
        $academic_title = App\Academic::where('id','=',$academic_id)->first()->academic_year_title;
        $course_record = App\Course::where('id', '=', $course_id)->first();

        $available_data = App\CourseSubject::join('subjects','subjects.id', '=', 'course_subject.subject_id')
            ->where('academic_id','=',$academic_id)
            ->where('course_id','=',$course_id)
            ->select(['subjects.id as id','subject_title','is_lab','is_elective_type','year','semister','sessions_needed'])
            ->get();

        $data['items']              = json_encode(array('source_items'=>$subjects,'target_items'=>$available_data));
 
        $course_title   = $course_record->course_title;
        $data['academic_id']        = $academic_id;
        $data['course_id']          = $course_id;
        $data['record']             = $course_record;
        $data['title']              = getPhrase('subjects_list')
                                      .' - '.$academic_title.' - '.$course_title;
        $data['module_helper']      = getModuleHelper('allocate-subject-to-course');

        return view('mastersettings.course-subjects.manage-course-subjects.list-subjects-for-course', $data);
    	// return view('mastersettings.course-subjects.add-edit', $data);
    }

 

   

    /**
     * Update record based on slug and reuqest
     * @param  Request $request [Request Object]
     * @param  [type]  $slug    [Unique Slug]
     * @return void
     */
    public function update(Request $request, $create_new = FALSE)
    {
        $semister                       = $this->getSemisterFromRequest($request);
        $academic_id                    = $request->academic_id;
        $course_parent_id               = $request->course_parent_id;
        $course_id                      = $request->course_id;
        $year                           = $request->year;
        
        

        if(!$create_new)
        {
            //Already data exists with the combination so delete those first
            if(!env('DEMO_MODE')) {
              App\CourseSubject::where('academic_id', '=', $request->academic_id)
                 ->where('course_parent_id', '=', $request->course_parent_id)   
                 ->where('course_id', '=', $request->course_id)   
                 ->where('year', '=', $request->year)   
                 ->where('semister', '=', $semister)   
                ->delete();
            }
        }

        foreach ($request->subject_id as $subject_id) {
            $record = new App\CourseSubject();        
            $record->academic_id            = $academic_id;
            $record->course_parent_id       = $course_parent_id;
            $record->course_id              = $course_id;
            $record->year                   = $year;
            $record->sessions_needed        = 0;            
            $record->semister               = $semister;            
            $record->subject_id             = $subject_id;            
            $record->save();
        }

    }

    /**
     * This method adds subjects to specific course year and sem to db
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     <type>                    ( description_of_the_return_value )
     */
    public function store(Request $request)
    {

        $academic_id        = $request->academic_id;
        $course_id          = $request->course_id;
        $course_parent_id    = $request->course_parent_id;
        $current_year       = 0;
        $current_sem        = 0;
        $selected_list      = $request->selected_list;
        $total_classes      = $request->total_classes;

        $exception_occured = 0;
         DB::beginTransaction();
         try{
        foreach ($selected_list as $key => $subjects_list) {
               
                $yearsems = explode('_',str_replace("'","",$key));
                $current_year = $yearsems[0];
                $current_sem = $yearsems[1];

                $this->processAndUpdateSubjects(
                                            $academic_id, 
                                            $course_id, 
                                            $course_parent_id, 
                                            $current_year,
                                            $current_sem,
                                            $subjects_list,
                                            $total_classes[$key]
                                              );

             
            }

        }    
        catch(Exception $e)
        {
             DB::rollBack();
            $exception_occured = 1;
            if(getSetting('show_foreign_key_constraint','module'))
            {
              flash('oops...!',$e->getMessage(), 'error');
            }
           else {
              flash('oops...!','improper_data_in_the_question', 'error');
            }

        }

        if(!$exception_occured)
        {
            flash('success','record_updated_successfully', 'success');
            DB::commit();

        }
       
        return redirect(URL_MASTERSETTINGS_COURSE_SUBJECTS_ADD);

    }

    /**
     * This method updates the course subjects based on the sent paremeters
     * If any records exists with the combination of year and semister, 
     * first it deletes the records and inserts the new set of records
     * @param  [academic_id]
     * @param  [course_id]
     * @param  [course_parent_id]
     * @param  [current_year]
     * @param  [current_sem]
     * @param  [list of subjects in an array]
     * @param  [list of total classes in an array]
     * @return [void]
     */
    public function processAndUpdateSubjects($academic_id, 
                                            $course_id, 
                                            $course_parent_id, 
                                            $current_year,
                                            $current_sem,
                                            $subjects_list,
                                            $total_classes)
    {
        $query = App\CourseSubject::where('academic_id', '=', $academic_id)
                 ->where('course_parent_id', '=', $course_parent_id)   
                 ->where('course_id', '=', $course_id)   
                 ->where('year', '=', $current_year)   
                 ->where('semister', '=', $current_sem)
                 ->get();
                 $existing_subjects_list = [];
        foreach($query as $r)
        {
            $existing_subjects_list[] = $r->subject_id;
        }
        
        
        $items_to_remove =  array_diff($existing_subjects_list, $subjects_list);
        $items_to_add    =  array_diff($subjects_list, $existing_subjects_list);

        
        //Delete the unwanted/non-submitted items from course subjects table
        if(!env('DEMO_MODE')) {
            foreach($items_to_remove as $index => $subject_id)
            {
                $query = App\CourseSubject::where('academic_id', '=', $academic_id)
                     ->where('course_parent_id', '=', $course_parent_id)   
                     ->where('course_id', '=', $course_id)   
                     ->where('year', '=', $current_year)   
                     ->where('semister', '=', $current_sem)
                     ->where('subject_id', '=', $subject_id)->delete();
            }
        }
      
      
       //Insert the new set of records
       foreach ($items_to_add as $key => $value) {
           $record                      = new App\CourseSubject();
           $record->academic_id         = $academic_id;
           $record->slug                = $record->makeSlug(getHashCode());
           $record->course_parent_id    = $course_parent_id;
           $record->course_id           = $course_id;
           $record->year                = $current_year;
           $record->semister            = $current_sem;
           $record->subject_id          = $value;
           $record->sessions_needed     = $total_classes[$key];
           $record->save();
       }

    }

  /**
   * This method shows the course subjects as syllabus book in single view
   *
   * @param      <integer>  $academic_id  The academic identifier
   * @param      <integer>  $course_id    The course identifier
   *
   * @return     <view>  ( description_of_the_return_value )
   */
    public function show($academic_id, $course_id)
    {


        $academic_record = App\Academic::where('id','=',$academic_id)->first();

        $course_record   = App\Course::where('id', '=', $course_id)->first();

        if($isValid = $this->isValidRecord($academic_record))
            return redirect($isValid);
        
        if($isValid = $this->isValidRecord($course_record))
            return redirect($isValid);

        $course_title = $course_record->course_title;
        $academic_title = $academic_record->academic_year_title;
        
        $data['academic_id']        = $academic_id;
        $data['course_id']          = $course_id;
        $data['record']             = App\Course::find($course_id);
        $data['active_class']       = 'master_settings';
        $data['layout']             = getLayout();
        $data['title']              = getPhrase('subjects_list')
                                      .' - '.$academic_title.' - '.$course_title;
        $data['module_helper']      = getModuleHelper('view-subjects');

        return view('mastersettings.course-subjects.list-subjects-for-course', $data);
    }
    
    /**
     * Returns the semister value from the request object
     * @param  Request $request 
     * @return [type]           integer
     */
    public function getSemisterFromRequest(Request $request)
    {
         
       if(isset($request->semister) && is_numeric($request->semister))
        return $request->semister;
        return 0; 
    }
    
    /**
     * Delete Record based on the provided slug
     * @param  [string] $slug [unique slug]
     * @return Boolean 
     */
    public function delete(Request $request)
    {
        try{
        if(!env('DEMO_MODE')) {
        CourseSubject::where('academic_id', $request->academic_id)
                       ->where('course_id', $request->course_id)
                        ->delete();
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

    /**
     * Returns the list of years based on the request selected course id
     * 
     * @param  Request $request 
     * @return [type]           json array
     */
    public function getCourseYears(Request $request)
    {
    	return  json_encode(App\Course::find($request->course_id));
    }

    /**
     * Returns the record of semisters available for selected course and year for a course
     * @param  Request $request 
     * @return [type]           json record
     */
    public function getSemisters(Request $request)
    {
    	$courseId 	= $request->course_id;
    	$year 		= $request->year;
    	return  json_encode(App\CourseSemister::getCourseYearSemisters($courseId, $year));
    }

    /**
     * This method fetches the list of saved subjects based on few conditions
     * those are academic_id, course_id, year and [semister]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getSavedSubjects(Request $request)
    {
    	$courseId 	= $request->course_id;
    	$academicId	= $request->academicId;
    	$year 		= $request->year;
    	$semister 	= $this->getSemisterFromRequest($request);
    	$courseParentId = $request->courseParentId;

    	$dta = App\CourseSubject::getCourseSavedSubjects($academicId, $courseId, $year, $semister);
        
        $selected_list = array_pluck($dta, 'subject_id');
        return json_encode($selected_list);
     
    }


    public function staffAllotment($academic_id, $course_id)
    {

        $academic_record = App\Academic::where('id','=',$academic_id)->first();

        $course_record   = App\Course::where('id', '=', $course_id)->first();

        if($isValid = $this->isValidRecord($academic_record))
            return redirect($isValid);
        
        if($isValid = $this->isValidRecord($course_record))
            return redirect($isValid);


        $data['record']            = FALSE;
        $data['active_class']       = 'master_settings';
        $data['loadYears']             = TRUE;
        $staff_role_id = getRoleData('staff');

         $users = App\User::join('staff', 'user_id','=','users.id')
         ->where('role_id', '=',$staff_role_id)
         ->where('users.status','!=',0)
         ->where('staff.course_id','!=','')
         ->select(['users.id as id', 'users.name', 'image', 'job_title', 'gender', 'qualification'])
         ->get();
         
         $preferred_subjects = [];
         foreach($users as $user)
         {
            $preferred_subjects[$user->id] = $user->preferredSubjects();
         }

        
        $data['right_bar']          = TRUE;
        $data['right_bar_path']     = 'mastersettings.subjects-allotment.item-view-right-bar';
        $data['right_bar_data']     = array(
                                            'item' => $users,
                                            );
 
        $data['layout']             = getLayout();

        $data['title']              = getPhrase('allocate_subjects');

        $academic_title = $academic_record->academic_year_title;
        

        $available_data = App\CourseSubject::join('subjects','subjects.id', '=', 'course_subject.subject_id')
            ->where('academic_id','=',$academic_id)
            ->where('course_id','=',$course_id)
            ->select([ 'subjects.id as id','subject_title','is_lab','is_elective_type','year','semister','sessions_needed','staff_id'])
            ->get();
         
            $keys = $this->prepareKeys($available_data);
            $data['keys'] = $keys;
        $data['items']              = json_encode(array(
                                                            'source_items' => $users,
                                                            'target_items' => $available_data,
                                                            'preferred_subjects' => $preferred_subjects
                                                        ));
 
        $course_title   = $course_record->course_title;
        $data['academic_id']        = $academic_id;
        $data['course_id']          = $course_id;
        $data['record']             = $course_record;
        $data['title']              = getPhrase('allocate_staff')
                                      .' - '.$academic_title.' - '.$course_title;
        $data['module_helper']      = getModuleHelper('allocate-staff-to-subjects');

        return view('mastersettings.subjects-allotment.manage-course-subjects.list-subjects-for-course', $data);                
    }

    /**
     * This method prepares keys to use in angular js file for variable references
     *
     * @param      <type>  $available_data  The available data
     *
     * @return     array   ( description_of_the_return_value )
     */
    public function prepareKeys($available_data)
    {
        $keys = [];
        foreach($available_data as $data)
            $keys[] = $data->year.'_'.$data->semister.'_'.$data->id;

        return $keys;
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
        return URL_MASTERSETTINGS_COURSE_SUBJECTS;
    }

    /**
     * This method updates the list of staff allotted to the subjects for specific years and semisters
     * This method accepts a request majorly which contains selected_list varable
     * This variable contains array of strings in the below format
     * Year_Semister_SubjectID_UserID format
     * Split the string with '_' and loop with update operation
     *
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function updateStaffAllotment(Request $request)
    {

        $selected_list          = $request->selected_list;
        $course_id              = $request->course_id;
        $course_parent_id       = $request->course_parent_id;
        $academic_id            = $request->academic_id;
         $exception_occured = 0;
         
         DB::beginTransaction();
         try{

        foreach($selected_list as $list)
        {
            $record = (object) $this->processList($list);
             $query = App\CourseSubject::
                                    where('academic_id', '=', $academic_id)
                                    ->where('course_id', '=', $course_id)
                                    ->where('course_parent_id', '=', $course_parent_id)
                                    ->where('year', '=', $record->year)
                                    ->where('semister', '=', $record->semister); 
            


            $courseSubjectRecord  = $query->where('subject_id', '=', $record->subject_id)->first();
            $courseSubjectRecord->staff_id = $record->user_id;

            $courseSubjectRecord->save();
        }
        }
         catch(Exception $e)
        
        {
             DB::rollBack();
            $exception_occured = 1;
            if(getSetting('show_foreign_key_constraint','module'))
            {
              flash('oops...!',$e->getMessage(), 'error');
            }
           else {
              flash('oops...!','improper_data_in_the_question', 'error');
            }

        }

        if(!$exception_occured)
        {
            flash('success','record_updated_successfully', 'success');
            DB::commit();

        }

        return redirect(URL_COURSE_SUBJECTS_ADD_STAFF.$academic_id.'/'.$course_id);


    }


    public function processList($list)
    {
        $split_items = explode('_',$list);

        $data['year']       = $split_items[0];
        $data['semister']   = $split_items[1];
        $data['subject_id'] = $split_items[2];
        $data['user_id']    = $split_items[3];
        return $data;
    }

    /**
     * This method is used to find the subject is allocated to any staff for particular course
     * If allocated it returns the no. of times it got allocated to staff
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function removeSubject(Request $request)
    {
        $academic_id = $request->academic_id;
        $course_id = $request->course_id;
        $subject_id = $request->subject_id;
        $year = $request->year;
        $semister = $request->semister;
        $count = App\CourseSubject::where('academic_id', '=', $academic_id)
                                    ->where('course_id', '=', $course_id)
                                    ->where('subject_id', '=', $subject_id)
                                    ->where('year', '=', $year)
                                    ->where('semister', '=', $semister)
                                    ->where('staff_id', '!=', 0)
                                    ->count();
        return $count;

    }

    /**
     * This method finds wether the staff is alloted to any time table for particular course
     * If alloted it returns the count that for how many classes he got alloted 
     * @param  Request $request [description]
     * @return boolean          [description]
     */
    public function isSatffAllocatedToTimetable(Request $request)
    {
        $academic_id = $request->academic_id;
        $course_id = $request->course_id;
        $subject_id = $request->subject_id;
        $year = $request->year;
        $semister = $request->semister;
        $user_id = $request->user_id;
        $count = App\Timetable::where('academic_id', '=', $academic_id)
                                    ->where('course_id', '=', $course_id)
                                    ->where('subject_id', '=', $subject_id)
                                    ->where('year', '=', $year)
                                    ->where('semister', '=', $semister)
                                    ->where('user_id', '=', $user_id)
                                    ->count();
        return $count;

    }



}
