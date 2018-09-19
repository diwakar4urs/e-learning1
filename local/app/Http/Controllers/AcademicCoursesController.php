<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App;
use App\Http\Requests;
use DB;
use Auth;
use Input;
use App\AcademicCourse;
use Exception;

class AcademicCoursesController extends Controller
{
   
    public function __construct()
    {
    	$this->middleware('auth');
    }


    public function academicCoursesArrangment($slug)
    {
      
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

      $record = App\Academic::where('slug', '=', $slug)->first();
      if($isValid = $this->isValidRecord($record))
    		return redirect($isValid);

    	$courses = App\Course::where('parent_id','!=',0)->select(['id','course_title','parent_id'])->get();
 
      $alloted_list = $record->academicCourses()->get();
      $final_list = [];
 
      foreach($alloted_list as $l)
      {
           
        $course_item = App\Course::where('id','=',$l->course_id)->first();
        $final_list[] = (object) array('id'=>$l->course_id, 'course_title'=>$course_item->course_title, 'parent_id'=> $course_item->parent_id);
      }
  		$data['record']       		= $record;
  		$data['active_class']       = 'mastersettings';
  		$data['title']       		= getPhrase('academic_courses');
        $data['items']              = json_encode(array('courses'=>$courses,'allocated_courses'=>$final_list));
        $data['right_bar']          = TRUE;
        $data['right_bar_path']     = 'mastersettings.academic-courses.item-view-right-bar';
        $data['right_bar_data']     = array(
                                            'item' => $courses,
                                            );
        $data['layout']              = getLayout();
        $data['module_helper']       = getModuleHelper('allocate-course-to-academics');
        
     	return view('mastersettings.academic-courses.add-edit', $data);   
    }

    /**
     * This method updates the academic course records in academic_courses table
     * 1) It will first identify any records exists in table wil academic id
     *   If exists, removes all old records and inserts the new set of records
     * 2) If not exists, it will inserts the set of records received
     * @param  Request $request [description]
     * @param  [type]  $slug    [description]
     * @return [type]           [description]
     */
    public function updateAcademicCourses(Request $request, $slug)
    {
      
      $record = App\Academic::where('slug','=',$slug)->first();

       if($isValid = $this->isValidRecord($record))
        return redirect($isValid);
      $model = AcademicCourse::where('academic_id','=',$record->id);
      $count = $model->count();
      $academic_id = $record->id;


      DB::beginTransaction();
      try{
          if($count)
          {
            if(!env('DEMO_MODE')) {
            //Previous records exists  
            $model->delete();
            }
          }
          if(count($request->selected_list)){
              foreach($request->selected_list as $key=>$value)
              {
                $newRecord = new AcademicCourse();
                $newRecord->academic_id = $academic_id;
                $newRecord->course_id = $value;
                $newRecord->course_parent_id = $request->parent_list[$key];
                $newRecord->save();
              }
               
            }

            DB::commit();
            flash('success...!','records_updated_successfully', 'success');
        }
      catch(Exception $ex)
      {
       DB::rollBack();
       if(getSetting('show_foreign_key_constraint','module'))
       {

          flash('oops...!',$e->getMessage(), 'error');
       }
       else {
          flash('oops...!','improper_data', 'error');
       }
      }

       return redirect(URL_MASTERSETTINGS_ACADEMICS);

    }

    /**
     * This method will checks if the record is valid
     * @param  [type]  $record [description]
     * @return boolean         [description]
     */
    public function isValidRecord($record)
    {
    	if ($record === null) {

    		flash('Ooops...!', getPhrase("page_not_found"), 'error');
   			return $this->getRedirectUrl();
		}

		return FALSE;
    }

    /**
     * This method will send the default URL to send the user to back
     * @return [type] [description]
     */
    public function getReturnUrl()
    {
    	return URL_MASTERSETTINGS_ACADEMICS;
    }

    /**
     * This method returns the list of parent courses available with the specific 
     * academic year
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getParentCourses(Request $request)
    {
        $records = AcademicCourse::join('courses', 'academic_course.course_parent_id', '=' ,'courses.id')
         ->select([  
            'course_title','courses.id'])
         ->where('academic_id', '=', $request->academic_id)
         ->groupBy('course_parent_id')->get();
         return $records;
    }

     /**
     * This method returns the list of courses available with the specific 
     * academic year AND Parent Course id
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getChildCourses1(Request $request)
    {
        $records = AcademicCourse::join('courses', 'academic_course.course_id', '=' ,'courses.id')
         ->select([  
            'course_title','courses.id', 'course_dueration','is_having_semister','academic_id', 'course_parent_id'])
         ->where('academic_id', '=', $request->academic_id)
         ->where('course_parent_id', '=', $request->parent_course_id)
         ->groupBy('course_id')->get();
         return $records;
    }

    /**
     * This method will return the child courses based on the request
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getChildCourses(Request $request)
    {
     
        $current_user = Auth::user();
        $user_role = getRoleData($current_user->role_id);
        $student_record = '';
        if($user_role=='student')
        {
          $student_record = App\Student::where('user_id','=',$current_user->id)->first();
        }


        $course_id =$request->course_id;
        $academic_id = $request->academic_id;
        $parent_course_id = $request->parent_course_id;
        $records = AcademicCourse::join('courses', 'academic_course.course_id', '=' ,'courses.id')
         ->select([  
            'course_title','courses.id', 'course_dueration','is_having_semister','academic_id', 'course_parent_id'])
         ->where('academic_course.academic_id', '=', $academic_id)
         ->where('academic_course.course_parent_id', '=', $parent_course_id);

         if($user_role=='student')
         {
            $records = $records->where('academic_course.course_id','=',$student_record->course_id);
         }
         else {
           $records = $records->groupBy('course_id');
        }
        $records = $records->get();
         $final_records = [];
         foreach($records as $key => $value)
         {
          $temp['course'] = $value;
          $temp['semister'] = $value->semisters();

          $final_records[] = $temp;
         }
         return $final_records;
    }

    

  public function checkStatus(Request $request)
  {
     $academic_id = $request->academic_id;
        $course_id = $request->course_id;

    $students = App\Student::where('academic_id', '=', $academic_id)
                                    ->where('course_id', '=', $course_id)
                                    ->count();
    $subjects = App\CourseSubject::where('academic_id', '=', $academic_id)
                                    ->where('course_id', '=', $course_id)
                                    ->count();
    return $students+$subjects;   
  } 

}
