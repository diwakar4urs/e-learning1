<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use App\User;
use App\Student;
use App\Academic;
use App\Course;
use App\StudentPromotion;
use App\GeneralSettings as Settings;
use DB; 
use Auth;
use Exception;
class StudentController extends Controller
{
    
    public function __construct()
    {
    	$this->middleware('auth');
    }

    
    public function index()
    {
    	$data['record']       = FALSE;
        $data['active_class'] = 'users';
        $data['layout']       = getLayout();
        
        $data['title']        = getPhrase('add_student');
        return view('users.student.add-edit-student', $data);
    }

    /**
     * This method fetches the staff record from staff table based on 
     * user slug from users table
     * Sends the staff record to view based on the tab it needs to move
     * @param  [type] $slug [slug of the user]
     * @param  string $tab  [tab key that need to be active on view]
     * @return [view]       [description]
     */
    public function edit($slug, $tab = 'general')
    { 
        
        $userRecord                    = User::where('slug', $slug)->first();
        $phone_number                  = $userRecord->phone;
        $data['userRecord']            = $userRecord;
        $studentRecord                 = Student::where('user_id', $userRecord->id)->get()->first();
        $data['join_date']             =  isset($studentRecord->date_of_join) ?  $studentRecord->date_of_join:'';
        $data['birth_date']             = isset($studentRecord->date_of_birth) ? $studentRecord->date_of_birth : '';


        //joining details are fetched 
        
        $join_academicTitle = '';
        $join_courseName ='';
        $course_time = '';

        if(!empty($studentRecord->roll_no)){

        $student_joinDetails           = App\StudentPromotion::where('user_id','=',$studentRecord->user_id)->get()->first();
        
        $course_time                   = Course::where('id','=',$student_joinDetails->from_course_id)->select('course_dueration')->first();

        
       
        $data['course_time']           = $course_time;

        $join_academicTitle            = Academic::where('id','=',$student_joinDetails->from_academic_id)->
        select('academic_year_title')->first();
       

        $join_parentName               = Course::where('id','=',$student_joinDetails->from_course_parent_id)->
        select('course_title')->first();
        $data['join_parentName']       = $join_parentName;

        $join_courseName               = Course::where('id','=',$student_joinDetails->from_course_id)->
        select('course_title')->first();
       

        $data['join_year']             =  $student_joinDetails->from_year; 
        $data['join_semister']         =  $student_joinDetails->from_semister; 

        }

         $data['join_academicTitle']    = $join_academicTitle;
         $data['join_courseName']       = $join_courseName;
          $data['having_semiseter']      = $course_time;


        //present class details

        $academic_title                = Academic::where('id','=',$studentRecord->academic_id)->
        select('academic_year_title')->first();
        $data['academic_title']        = $academic_title;
        
        $course_parent_name            = Course::where('id','=',$studentRecord->course_parent_id)->
        select('course_title')->first();
        $data['course_parent_name']    = $course_parent_name;

        $course_name                   = Course::where('id','=',$studentRecord->course_id)->
        select('course_title')->first();
        $data['course_name']     = $course_name;

        $data['year']            =  $studentRecord->current_year; 
        $data['semister']        =  $studentRecord->current_semister; 

        $studentObject                 = new Student();
        $data['record']                = $studentRecord;
        
        $data['academic_years']        = addSelectToList(getAcademicYears());
        $list                          = App\Course::getCourses(0);
        $data['courses_parent_list']   = array_pluck($list, 'course_title', 'id');
        $data['courses_list']          = array();

        if(isset($studentRecord->course_parent_id))
        {
           $list                 = App\Course::getCourses($studentRecord->course_parent_id);
           $data['courses_list'] = array_pluck($list, 'course_title', 'id');
        }
        $selected_course = null;
        
        if(isset($studentRecord->course_id))
        $selected_course         = App\Course::where('id',$studentRecord->course_id)->first();
        
        $years['']                  = 'Select Year';

        if(isset($selected_course->course_dueration))
       for($i=1; $i<= $selected_course->course_dueration; $i++)
            $years[$i] = $i;

        $semisters['']            = 'Select Sem';
        $courseSemRecord          = array();
        
        if(isset($selected_course->is_having_semister))
        {
            $tempyear = 1;
            if($studentRecord->current_year)
                $tempyear = $studentRecord->current_year;

            $courseSemRecord = App\CourseSemister::where('course_id', '=', $selected_course->id)->where('year', '=', $tempyear)->first();
            
            if(isset($courseSemRecord->total_semisters))
            for($i=1; $i<= $courseSemRecord->total_semisters; $i++)
                $semisters[$i] = $i;            

        }

        $data['years']              = $years;
        $data['semisters']          = $semisters;
        $data['religions']          = \App\Religion::lists('religion_name', 'id');
        $data['categories']         = \App\Category::lists('category_name', 'id');
        $data['countries']          = (new Settings())->getCountries();
        $data['active_class']       = 'users';
        $data['tab_active']         = $tab;
        $data['title']              = getPhrase('student_profile');
        $data['ph_no']              = $phone_number;
        $data['user_name']          = $userRecord->name;
        $data['layout']             = getLayout();
         
        return view('users.student.add-edit-student', $data);
    }
   

    /**
     * Update general details
     * @param  Request $request [Input form request]
     * @param  [type]  $id      [Staff Record ID]
     * @return [type]           [redirect to next page]
     */
    public function updateGeneralDetails(Request $request, $slug)
    {
         
        $itHasErrors = FALSE;

        if($request->academic_id==''||$request->course_parent_id==''||$request->course_id==''){

             $itHasErrors = TRUE;

        }

        if($request->has('current_year'))
        {
            if($request->current_year=='')
                 $itHasErrors = TRUE;

        }

        if($request->has('current_semister'))
        {
            if($request->current_semister=='')
                 $itHasErrors = TRUE;

        }

        if($itHasErrors)
        {
          
            flash('Oops...!','Please Select The Details', 'overlay');
             return redirect()->back()->withInput($request->except('_token'));
        }
        $this->validate($request, [
        'date_of_join'      => 'bail|required|max:20|',
        'academic_id'	    => 'bail|required|',
        'course_id'         => 'bail|required|',
        'course_parent_id'  => 'bail|required|',
        ]);

        $user_record      = getUserWithSlug($slug);
      
        $student          = Student::where('user_id','=',$user_record->id)->first();

         if($student->roll_no == null)
        {    
            $current_year=1;
            if($request->current_year)
                $current_year = $request->current_year;

            $current_semister=0;
            if($request->current_semister)
                 $current_semister = $request->current_semister;

             $student->date_of_join            = $request->date_of_join;
             $student->academic_id             = $request->academic_id;
            
            $student->roll_no = $student->prepareRollNo($slug, $request->academic_id, $request->course_parent_id, $request->course_id,$request->current_year,$request->current_semister);
            $student->current_year             = $current_year;
            $student->current_semister         = $current_semister;
            $student->course_parent_id         = $request->course_parent_id;
            $student->course_id                = $request->course_id;

            $student->save();

            // Promotion insert start
            
            $promotionObject                      = new App\StudentPromotion();
            $promotionObject->user_id             =  $student->user_id;
            $promotionObject->student_id          =  $student->id;
            $promotionObject->type                =  'admission';
            $promotionObject->from_academic_id    =  $request->academic_id;
            $promotionObject->from_course_parent_id  =  $request->course_parent_id;
            $promotionObject->from_course_id      =  $request->course_id;
            $promotionObject->from_year           =  $current_year ;
            $promotionObject->from_semister       =  $current_semister;
            $promotionObject->record_updated_by   =  Auth::user()->id;

            $promotionObject->save();
            
            // Promotion End
            
            try{
                (new App\EmailSettings())->sendEmail('Academia', 'Your roll no. is '.$student->roll_no);
            }
            catch(Exception $ex)
            {
                
            }
        }
      

        $student->previous_highest_qualification
        									= $request->previous_highest_qualification;
        $student->previous_highest_qualification_percentage   
        									= $request->previous_highest_qualification_percentage;
        $student->year_passing   			= $request->year_passing;
        $student->previous_institute_name   = $request->previous_institute_name;
        $student->previous_institute_address= $request->previous_institute_address;
        $student->record_updated_by   =  Auth::user()->id;
       
        $student->save();
        flash('success','record_updated_successfully', 'success');
        return redirect('student/profile/edit/'.$slug.'/personal');
    }

     /**
     * Update personel details
     * @param  Request $request [Input form request]
     * @param  [type]  $id      [Staff Record ID]
     * @return [type]           [redirect to next page]
     */
    public function updatePersonalDetails(Request $request, $slug)
    { 
        if($request->first_name==''||$request->date_of_birth==''||$request->fathers_name==''||$request->mothers_name==''||$request->religion_id==''||$request->category_id==''){

            flash('Oops...!','Please Select required The Details', 'overlay');
            return redirect('/student/profile/edit/'.$slug.'/personal');
        }
        $this->validate($request, [
        'first_name'    => 'bail|required|max:20|',
        'date_of_birth' => 'bail|required|',
        'fathers_name'  => 'bail|required|',
        'mothers_name'  => 'bail|required|',
        'religion_id'   => 'bail|required|',
        'category_id'   => 'bail|required|',
        ]);

        $user                     = getUserWithSlug($slug);
        $student                  = Student::where('user_id','=',$user->id)->first();
        $student->first_name      = $request->first_name;
        $student->middle_name     = $request->middle_name;
        $student->last_name       = $request->last_name;
        $student->gender          = $request->gender;
        $student->blood_group     = $request->blood_group;
        $student->date_of_birth   = $request->date_of_birth;    
        $student->fathers_name    = $request->fathers_name;    
        $student->mothers_name    = $request->mothers_name;    
        $student->nationality     = $request->nationality;    
        $student->mother_tongue   = $request->mother_tongue;    
        $student->category_id  	  = $request->category_id;    
        $student->religion_id  	  = $request->religion_id;    
        $student->save();
        flash('success','record_updated_successfully', 'success');
        return redirect('student/profile/edit/'.$user->slug.'/contact');

    }


    /**
     * Update personel details
     * @param  Request $request [Input form request]
     * @param  [type]  $id      [Staff Record ID]
     * @return [type]           [redirect to next page]
     */
    public function updateContactDetails(Request $request, $slug)
    {
        // dd($request);
      if($request->city==''||$request->state==''||$request->country==''||$request->zipcode==''||$request->mobile==''){

        flash('Oops...!','Please Select required The Details', 'overlay');
            return redirect('/student/profile/edit/'.$slug.'/contact');

      }
        
        $this->validate($request, [
       
        'city'              => 'bail|required|max:50',
        'state'             => 'bail|required|max:50',
        'country'           => 'bail|required',
        'zipcode'           => 'bail|required',
        'mobile'           => 'bail|required|numeric',
        ]);
        $user                   = getUserWithSlug($slug);
        $role_name              = $user->roles()->first()->name;
        if($role_name  == 'staff')
            $staff              = Staff::where('user_id','=',$user->id)->first();
        else if($role_name == 'student')
            $staff              = Student::where('user_id','=',$user->id)->first();
        $staff->guardian_name   = $request->guardian_name;
        $staff->guardian_phone   = $request->guardian_phone;
        $staff->relationship_with_guardian   = $request->relationship_with_guardian;
        $staff->guardian_email  = $request->guardian_email;
        $staff->address_lane1   = $request->address_lane1;
        $staff->address_lane2   = $request->address_lane2;
        $staff->city            = $request->city;    
        $staff->state           = $request->state;    
        $staff->country         = $request->country;    
        $staff->zipcode         = $request->zipcode;    
        $staff->mobile          = $request->mobile;    
        $staff->home_phone      = $request->home_phone;    
        $staff->save();
        flash('success','record_updated_successfully', 'success');
        
            return redirect('student/profile/edit/'.$slug.'/general');

    } /**
     * Update personel details
     * @param  Request $request [Input form request]
     * @param  [type]  $id      [Staff Record ID]
     * @return [type]           [redirect to next page]
     */
    public function updateParentDetails(Request $request, $slug)
    {
        if($request->parent_name==''||$request->parent_user_name==''||$request->parent_email==''||$request->parent_password==''){

               flash('Oops...!','Please Select The Details', 'overlay');
         return redirect('student/profile/edit/'.$slug.'/parent');

        }

       
        $user     = User::where('slug', '=', $slug)->first();
        $role_id  = getRoleData('parent');
        $message  = '';
        $hasError = 0;

        DB::beginTransaction();
        if($request->account == 0)
        {
            //User is not having an account, create it and send email
            //Update the newly created user ID to the current user parent record
            $parent_user = new User();
            $parent_user->name = $request->parent_name;
            $parent_user->username = $request->parent_user_name;
            $parent_user->role_id = $role_id;
            $parent_user->slug = $parent_user->makeSlug($request->parent_user_name);
            $parent_user->email = $request->parent_email;
            $parent_user->password = bcrypt('password');
           
             
        try{
            $parent_user->save();
            $parent_user->roles()->attach($role_id);
            $user->parent_id = $parent_user->id;
            $user->save();
            sendEmail('registration', array('user_name'=>$user->name, 'username'=>$user->username, 'to_email' => $user->email, 'password'=>$parent_user->password));

            DB::commit();
            $message = 'record_updated_successfully';
        }
        catch(Exception $ex){
            DB::rollBack();
            $hasError = 1;
            $message = $ex->getMessage();
        }
    }
        if($request->account == 1)
        {
            try{
             $user->parent_id =  $request->parent_user_id;
             $user->save();
             DB::commit();
            }
            catch(Exception $ex)
            {
                $hasError = 1;
                DB::rollBack();
                $message = $ex->getMessage();
            }
        }
        if(!$hasError)
            flash('success',$message, 'success');
        else 
            flash('Ooops',$message, 'error');
        return redirect('student/profile/edit/'.$slug.'/general');

    }

    public function show($slug)
    {
        $userRecord     = User::where('slug', $slug)->get()->first();
        $staffRecord    = Staff::where('user_id', $userRecord->id)->get()->first();
        $data['user_record']       = $userRecord;
        $data['staff_record']       = $staffRecord;
        $data['department']         = \App\Department::find($staffRecord->department_id)->first();
        $data['active_class']       = 'users';
        $data['layout']             = getLayout();
        $data['title']              = getPhrase('staff_profile');        
        return view('users.staff.staff-profile', $data);
    }

    /**
     * This method returns the List of courses available with the sent academicId
     * @param  [integer] $academicId 
     * @return [json array]             
     */
    public function courses(Request $request)
    {
        $course_parent_id = $request->parent_course_id;
        $records = App\Course::where('parent_id', '=', $course_parent_id)->get();
        return $records;
    
     }

     public function coursesSemister($courseId, $year, $academic_id = 0, $semister = 0)
     {
         $dta = App\CourseSemister::
                                    where('course_id', '=', $courseId)
                                    ->where('year', '=', $year)
                                    ->first();
         return $dta;
     }

     public function search($term)
     {
         $term = Input::get('term');
    
        $results = array();
        
        $queries = DB::table('students')
            ->where('first_name', 'LIKE', '%'.$term.'%')
            ->orWhere('last_name', 'LIKE', '%'.$term.'%')
            ->orWhere('admission_no', 'LIKE', '%'.$term.'%')
            ->orWhere('roll_no', 'LIKE', '%'.$term.'%')
            ->take(5)->get();
        
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => $query->first_name.' '.$query->last_name ];
        }
        return Response::json($results);
    }

    
     /**
     * This method returns the list of students avaialbe with the requested 
     * combination
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getStudents(Request $request)
    {
        $academic_id        = $request->academic_id;
        $course_parent_id   = $request->course_parent_id;
        $course_id          = $request->course_id;
        $year               = $request->year;
        $semister           = $request->semister;

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
        return $records;
    }  
      /**
       * This method returns the course completed student list according to the 
       * selection details
       * @param  Request $request 
       * @return [type]           [description]
       */
    public function getCompletedStudents(Request $request)
    {
        $academic_id        = $request->academic_id;
        $course_parent_id   = $request->parent_course_id;
        $course_id          = $request->course_id;
        $year               = $request->year;
        $semister           = $request->semister;
        
         $records = StudentPromotion::join('users','users.id','=','studentpromotions.user_id')
            ->join('students','students.id','=','studentpromotions.student_id')
            ->join('courses','courses.id','=','students.course_id')
            ->where('from_academic_id','=',$academic_id)
            ->where('from_course_parent_id','=',$course_parent_id)
            ->where('from_course_id','=',$course_id)
            ->where('from_year','=',$year)
            ->where('from_semister','=',$semister)
            ->where('type','=','completed')
            ->select(['users.name','students.roll_no','courses.course_title','users.slug'])
            ->get();

            return $records;
    }

    public function getDetainedStudents(Request $request)
    {

        $academic_id        = $request->academic_id;
        $course_parent_id   = $request->parent_course_id;
        $course_id          = $request->course_id;
        $year               = $request->year;
        $semister           = $request->semister;

        $records = StudentPromotion::join('users','users.id','=','studentpromotions.user_id')
            ->join('students','students.id','=','studentpromotions.student_id')
            ->join('courses','courses.id','=','students.course_id')
            ->where('from_academic_id','=',$academic_id)
            ->where('from_course_parent_id','=',$course_parent_id)
            ->where('from_course_id','=',$course_id)
            ->where('from_year','=',$year)
            ->where('from_semister','=',$semister)
            ->where('type','=','detained')
            ->select(['users.name','students.roll_no','courses.course_title','users.slug'])
            ->get();

            return $records;

    }

    public function globalStudentSearch(Request $request)
    {
        $term = $request->search_text;
        $completed_students_request = false;

        if($request->has('certificate_type'))
        {
            if($request->certificate_type=='tc')
            $completed_students_request = true;
        }

         $records = User::join('students', 'users.id' ,'=', 'students.user_id')  
        ->join('academics','academics.id','=','students.academic_id') 
        ->join('courses','courses.id','=','students.course_id')
        ->where('name', 'LIKE', '%'.$term.'%');

      

         $records = $records->orWhere('first_name', 'LIKE', '%'.$term.'%')
            
            ->orWhere('last_name', 'LIKE', '%'.$term.'%')
            ->orWhere('admission_no', 'LIKE', '%'.$term.'%')
            ->orWhere('roll_no', 'LIKE', '%'.$term.'%')
            ->orWhere('mobile', 'LIKE', '%'.$term.'%')
            ->orWhere('home_phone', 'LIKE', '%'.$term.'%')
            ->orWhere('email', 'LIKE', '%'.$term.'%')

        ->select(['students.user_id as id','users.name', 'roll_no','admission_no', 'course_title','blood_group','mobile','home_phone','image','academic_year_title', 'current_year', 'current_semister','fathers_name','mothers_name','address_lane1','city','state','zipcode','course_dueration','date_of_join','users.slug','users.email as email','is_having_semister'])->limit(10);

        if($completed_students_request)
        {
            $certificate_type = $request->certificate_type;
            if($certificate_type=='tc')
            {
                $records = $records->having('students.current_year','=',-1)
                                   ->having('students.current_semister','=',-1);
            }
        }
        else {
             $records = $records->having('students.current_year','!=',-1)
                                   ->having('students.current_semister','!=',-1);
        }

        $records = $records->get();

        return $records;
    }

    public function getParentsOnSearch(Request $request)
    {
        $term = $request->search_text;
        $role_id = getRoleData('parent');
        $records = App\User::
            where('name','LIKE', '%'.$term.'%')
            ->orWhere('username', 'LIKE', '%'.$term.'%')
            ->orWhere('phone', 'LIKE', '%'.$term.'%')
            ->groupBy('id')  
            ->havingRaw('role_id='.$role_id)
            ->select(['id','role_id','name', 'username', 'email', 'phone'])
            ->get();
            return json_encode($records);
    }

}
