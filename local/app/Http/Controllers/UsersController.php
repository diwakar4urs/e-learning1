<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App;
use App\Http\Requests;
use App\User;
use App\Student;
use App\Course;
use App\Academic;
use App\StudentPromotion;
use App\LibraryIssue;
use App\LibraryMaster;
use App\GeneralSettings as Settings;
use Image;
use ImageSettings;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Support\Facades\Hash;
use Excel;
use Input;
use File;
use Exception;
use Auth;
use App\OneSignalApp;
class UsersController extends Controller
{

  public $excel_data = '';

    public function __construct()
    {
         $currentUser = \Auth::user();
     
         $this->middleware('auth');
    
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
     public function index($role = 'users')
     {
      if(!checkRole(getUserGrade(2)))
        {
          prepareBlockUserMessage();
          return back();
        }

        $expected_roles = ['owner','admin','staff','student','librarian','assistant_librarian', 'parent', 'users'];
        
        if(!in_array($role, $expected_roles))
          
        $role                      = 'student';
        $data['records']           = FALSE;
        $data['role']              = $role;
        $data['layout']            = getLayout();
        $data['active_class']      = 'users';
        $academic_details          = Academic::select('academic_year_title')->get();
        $data['academic_details']  = $academic_details;
        $course_details            =Course::select('course_title')->get();
        $data['course_details']    = $course_details;

        $data['heading']           = getPhrase('users');
        $data['title']             = getPhrase($role);
        $data['module_helper']     = getModuleHelper('users-list');

        return view('users.list-users', $data);
     }


    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    
    public function getDatatable($slug = 'users')
    {
        $records = array();

        if($slug=='users')
        {
             $records = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->select(['users.name','image','email','roles.display_name','roles.name as role_name','login_enabled','role_id',
              'slug', 'users.id', 'users.updated_at','users.status'])
            ->orderBy('users.updated_at', 'desc');
        }

        elseif($slug =='student') 
        {
            $role = getRoleData($slug);
            
            $records = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->join('students','students.user_id','=','users.id')
            ->join('courses','courses.id','=','students.course_id')
            ->where('roles.id', '=', $role)
            ->select(['users.id','users.name', 'image','students.roll_no','courses.course_title','students.current_year','students.current_semister', 'email','roles.name as role_name','login_enabled','role_id','users.slug as slug', 'users.updated_at','courses.course_dueration','courses.is_having_semister'])


            ->orderBy('users.updated_at', 'desc');

                }

          elseif($slug =='staff') 
            {
            $role = getRoleData($slug);
            
            $records = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->join('staff','staff.user_id','=','users.id')
            ->join('courses','courses.id','=','staff.course_parent_id')
            ->where('roles.id', '=', $role)
            ->where('users.status', '!=',0)
            ->select(['users.name', 'image','staff.staff_id','staff.job_title','courses.course_title', 'email','roles.name as role_name','login_enabled','role_id','users.slug as slug', 'users.updated_at','users.status','staff.user_id'])


            ->orderBy('users.updated_at', 'desc');

                } 

        else {
            
            $role = getRoleData($slug);
            
            $records = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.id', '=', $role)
            ->select(['users.name',  'image', 'email','roles.name as role_name','login_enabled','role_id','users.slug as slug', 'users.updated_at'])


             ->orderBy('users.updated_at', 'desc');



        }

        return Datatables::of($records)
        ->addColumn('action', function ($records) {
          $current_id = '';
          
          $link_data = '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                        <li><a href="'.URL_USERS_EDIT.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>
                        ';

                    if($records->role_name == 'student') {
                     

                        $link_data .= '
                           <li ><a href="'.URL_STUDENT_EDIT_PROFILE.$records->slug.'"><i class="fa fa-user" aria-hidden="true"></i>'.getPhrase("admission_details").'</a></li>

                            <li><a href="'.URL_USER_DETAILS.$records->slug.'"><i class="fa fa-university" aria-hidden="true"></i>'.getPhrase("profile").'</a></li>';
                      }
                      
                    if($records->role_name == 'staff') {
                      $status_name = getPhrase('make_inactive');
                      if(!$records->status)
                        $status_name = getPhrase('make_active');

                        $link_data .= '
                           <li><a href="'.URL_STAFF_EDIT_PROFILE.$records->slug.'"><i class="fa fa-user" aria-hidden="true"></i>'.getPhrase("edit_details").'</a></li>

                           <li><a href="javascript:void(0);" onclick="changeStatus(\''.$records->slug.'\',\''.$records->status.'\',\''.$records->user_id.'\');" ><i class="fa fa-star" aria-hidden="true"></i>'.$status_name.'</a></li>';
                      }

                         $temp='';

                        //Show delete option to only the owner user
                        if(checkRole(getUserGrade(1)) && $records->id!=\Auth::user()->id)   {
                        $temp = '<li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="fa fa-trash"></i>'. getPhrase("delete").'</a></li>';
                         } 
                            
                        $temp .='</ul> </div>';
                        $link_data .= $temp;
            return $link_data;
            })
         ->editColumn('name', function($records) {
          $role = getRoleData($records->role_id);
          if($role =='student')
            return '<img src="'.IMAGE_STUDENT_ICON.'" title="'.getPhrase('student').'" > <a href="'.URL_USER_DETAILS.$records->slug.'">'.ucfirst($records->name).'</a>';
          else if($role=='staff')
          {
            
              return '<img src="'.IMAGE_TEACHER_ICON.'" title="'.getPhrase('teacher').'" > <a href="'.URL_STAFF_DETAILS.$records->slug.'">'.ucfirst($records->name).'</a>';
          }
          else if($role=='admin' || $role=='owner')
          {
             return '<img src="'.IMAGE_ADMIN_ICON.'" title="'.getPhrase('admin').'" > '.ucfirst($records->name); 
          }
          return ucfirst($records->name);
          
        })        
         ->editColumn('image', function($records){
            return '<img src="'.getProfilePath($records->image).'"  />';
        })
         
         ->editColumn('current_year',function($records){
          if($records->course_dueration>1){
            
             if($records->current_year==-1 && $records->current_semister==-1){
              return 'Completed';
             }
              if($records->is_having_semister==0){
                return $records->current_year;
              }
          $data = '';
          $data=$records->current_year.' '.'-'.' '.$records->current_semister;
          return $data;
          }
          elseif ($records->course_dueration<=1 && $records->current_year==-1 && $records->current_semister==-1) {
            return 'Completed';
          }
          return '-';
         })
 
        ->removeColumn('login_enabled')
        ->removeColumn('role_id')
        ->removeColumn('role_name')
        ->removeColumn('current_semister')
        ->removeColumn('id')
        ->removeColumn('slug')
        ->removeColumn('updated_at')
        ->removeColumn('course_dueration')
        ->removeColumn('is_having_semister')
        ->removeColumn('status')
        ->removeColumn('user_id')
         
        ->make();
    }

    /**
     * This method View The Inactive Staff List
     */
 

     public function staff_inactivelist($role='staff')
    {   

      if(!checkRole(getUserGrade(2)))
        {
          prepareBlockUserMessage();
          return back();
        }
        $data['active_class']       = 'users';
        $data['title']              = getPhrase('staff_inactive_list');
        $data['layout']             = getLayout();
        $data['role']               = $role;
      return view('users.staff-inactivelist', $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getStaffInactiveList($slug='staff')
    {
        
        $role = getRoleData($slug);
        DB::statement(DB::raw('set @rownum=0'));

          $records = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->join('staff','staff.user_id','=','users.id')
            ->join('courses','courses.id','=','staff.course_parent_id')
            ->where('roles.id', '=', $role)
            ->where('users.status', '=',0)
            ->select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),'users.name',  'image','staff.staff_id','staff.job_title','courses.course_title', 'email','roles.name as role_name','login_enabled','role_id','users.slug as slug', 'users.updated_at','users.status'])


            ->orderBy('users.updated_at', 'desc');

        
        return Datatables::of($records)
        ->addColumn('action', function ($records) {
            $status_name = getPhrase('make_inactive');
                      if(!$records->status)
                        $status_name = getPhrase('make_active');

            return '<a href="javascript:void(0);" onclick="changeStatus(\''.$records->slug.'\',\''.$records->status.'\');" ><button type="button" class="btn btn-primary">'
                    .$status_name.'</button></a>';
            })
        ->editColumn('name', function($records) {
          
        
              return '<img src="'.IMAGE_TEACHER_ICON.'" title="'.getPhrase('teacher').'" > <a href="'.URL_STAFF_DETAILS.$records->slug.'">'.ucfirst($records->name).'</a>';
          })
         ->editColumn('image', function($records){
            return '<img src="'.getProfilePath($records->image).'"  />';
        })
        ->removeColumn('id')
        ->removeColumn('slug')
        ->removeColumn('status')
        ->removeColumn('updated_at')
        ->removeColumn('login_enabled')
        ->removeColumn('role_id')
        ->removeColumn('role_name')
        ->make();
    }

/**
      * This Method is Used To
      * @param  Request $request [description]
      * @return [type]           [description]
      */
    public function changeStatus(Request $request)
    {
      $user_id   = $request->user_id;
      $library_issue = new App\LibraryIssue();
      $books_need_to_return  = $library_issue->isUserHavingBookings($user_id);

       if($books_need_to_return<=0){

      $record  = User::where('slug', $request->user_slug)->get()->first();
      if($request->current_status==1){
        $status =0;
      }
      if($request->current_status==0){
        $status = 1;
      }
        
      $record->status  = $status;
      $record->save(); 
      
       flash('success','status_changed_successfully', 'success');
          return redirect(URL_USERS."staff");
        }
        
       flash('Oops...','this staff is need to return books in library', 'overlay');
          return redirect(URL_USERS."staff");

    }


     /**
      * Show the form for creating a new resource.
      *
      * @return Response
      */
     public function create()
     {
        if(!checkRole(getUserGrade(2)))
        {
          prepareBlockUserMessage();
          return back();
        }

        
        
        $data['record']       = FALSE;
        $data['active_class'] = 'users';
        $data['roles']        = $this->getUserRoles();
        $data['title']        = getPhrase('add_user');
        if(checkRole(['parent']))
          $data['active_class'] = 'children';
        $data['layout']         = getLayout();

        $data['module_helper']  = getModuleHelper('create-user');

        return view('users.add-edit-user', $data);
     }

     /**
      * This method returns the roles based on the user type logged in
      * @param  [type] $roles [description]
      * @return [type]        [description]
      */
     public function getUserRoles()
     {
        $roles                = \App\Role::pluck('display_name', 'id');
        return array_where($roles, function ($key, $value) {
          if(!checkRole(getUserGrade(1))) {
            if(!($value == 'Admin' || $value =='Owner'))
              return $value;
          }
          else 
            return $value;
        });
     }

     /**
      * Store a newly created resource in storage.
      *
      * @return Response
      */
     public function store(Request $request )
     {
       
        $columns = array(
        'name'     => 'bail|required',
        'username' => 'bail|required|unique:users,username',
        'email'    => 'bail|required|unique:users,email',
        'image'    => 'bail|mimes:png,jpg,jpeg|max:2048',
        );
        // dd($columns); 
        if(checkRole(getUserGrade(2))) 
          $columns['role_id']  = 'bail|required'; 
        
        // dd($columns);

        $this->validate($request,$columns);
          
        $role_id = getRoleData('student');
        
        if($request->role_id)
        $role_id        = $request->role_id;

        $user           = new User();
        $name           = $request->name;
        $user->name     = $name;
        $user->email    = $request->email;
        $password       = str_random(8);
        $user->password = bcrypt($password);
          DB::beginTransaction();
        try{

        if(checkRole(['parent']))
          $user->parent_id    = getUserWithSlug()->id;

        $user->role_id        = $role_id;
        $user->login_enabled  = 1;
        $slug                 = $user->makeSlug($name);
        $user->username       = $request->username;
        $user->slug           = $slug;
        $user->phone          = $request->phone;
        $user->address        = $request->address;
       
        $user->save();

        $user->roles()->attach($user->role_id);
        $this->processUpload($request, $user);

          $user_type = getRoleData($user->role_id);
       
        if($user_type == 'staff')
        {
          $staff               = new App\Staff();
          $staff->staff_id     = $staff->prepareStaffID($user->id);
          $staff->first_name   = $user->name;
          $staff->user_id      = $user->id;

          $staff->save();

          DB::commit();
          flash('success','record_added_successfully', 'success');
          // return redirect('users');  
        }
        
        if($user_type == 'student'){

          $student = new App\Student();
          $student->admission_no  = $student->preparestudentID($user->id);
          $student->first_name    = $user->name;
          $student->user_id       = $user->id;
          $student->save();
        }
           DB::commit();
        $message   = getPhrase('record_added_successfully_with_password ').' '.$password;
        $exception = 0;
       

       if(!sendEmail('registration', array('user_name'=>$user->name, 'username'=>$user->username, 'to_email' => $user->email, 'password'=>$password)))
       {
         $message  = getPhrase('record_added_successfully_with_password ').' '.$password;
        $message .= getPhrase('\nCannot_send_email_to_user, please_check_your_server_settings');
       }

      $exception = 1;
     
      $flash = app('App\Http\Flash');
      $flash->create('Success...!', $message, 'success', 'flash_overlay',FALSE);
       
        if(checkRole(['parent']))
        return redirect('dashboard');  

    }
    catch(Exception $ex)
    {
       DB::rollBack();
       if(getSetting('show_foreign_key_constraint','module'))
       {
        
          flash('oops...!', $ex->getMessage(), 'error');
       }
       else {
        
           flash('oops...!','please_check_your_email_master_settings', 'overlay');
       }
    }
       return redirect(URL_USERS."users");  


     }

     public function sendPushNotification($user)
     {
        if(getSetting('push_notifications', 'module')) {
          if(getSetting('default', 'push_notifications')=='pusher') {
              $options = array(
                    'name' => $user->name,
                    'image' => getProfilePath($user->image),
                    'slug' => $user->slug,
                    'role' => getRoleData($user->role_id),
                );

            pushNotification(['owner','admin'], 'newUser', $options);
          }
          else {
            $this->sendOneSignalMessage('New Registration');
          }
        }
     }

     /**
      * This method sends the message to admin via One Signal
      * @param  string $message [description]
      * @return [type]          [description]
      */
     public function sendOneSignalMessage($new_message='')
     {
        $gcpm = new OneSignalApp();
      
      $message = array(
             "en" => $new_message,
             "title" => 'New Registration',
             "icon" => "myicon",
             "sound" => "default"
            );
          $data = array(
            "body" => $new_message,
             "title" => "New Registration",
          );  
          
          $gcpm->setDevices(env('ONE_SIGNAL_USER_ID'));
          $response = $gcpm->sendToAll($message,$data);
     }

    


     protected function processUpload(Request $request, User $user)
     {
         if ($request->hasFile('image')) {
          
          $imageObject = new ImageSettings();
          
          $destinationPath      = $imageObject->getProfilePicsPath();
          $destinationPathThumb = $imageObject->getProfilePicsThumbnailpath();
          
          $fileName = $user->id.'.'.$request->image->guessClientExtension();
          ;
          $request->file('image')->move($destinationPath, $fileName);
          $user->image = $fileName;
         
          Image::make($destinationPath.$fileName)->fit($imageObject->getProfilePicSize())->save($destinationPath.$fileName);
         
          Image::make($destinationPath.$fileName)->fit($imageObject->getThumbnailSize())->save($destinationPathThumb.$fileName);
          $user->save();
        }
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
      return URL_USERS;
    }

     /**
      * Display the specified resource.
      *
      *@param  unique string  $slug
      * @return Response
      */
     public function show($slug)
     {
        //
     }



     /**
      * Show the form for editing the specified resource.
      *
      * @param  unique string  $slug
      * @return Response
      */
     public function edit($slug)
     {  
      
        $record = User::where('slug', $slug)->get()->first();

        if(!isEligible($slug))
          return back();
       
        if($isValid = $this->isValidRecord($record))
         return redirect($isValid);
       /**
        * Validate the non-admin user wether is trying to access other user profile
        * If so return the user back to previous page with message
        */
       
        if(!isEligible($slug))
          return back();
        

        /**
         * Make sure the Admin or staff cannot edit the Admin/Owner accounts
         * Only Owner can edit the Admin/Owner profiles
         * Admin can edit his own account, in that case send role type admin on condition
         */
        
     $UserOwnAccount = FALSE;
     if(\Auth::user()->id == $record->id)
      $UserOwnAccount = TRUE;
    
      if(!$UserOwnAccount)  {
        $current_user_role = getRoleData($record->role_id);

        if((($current_user_role=='admin' || $current_user_role == 'owner') ))
        {
          if(!checkRole(getUserGrade(1))) {
            prepareBlockUserMessage();
            return back();
          }
        }
      }

        $data['record']             = $record;
        $data['roles']              = $this->getUserRoles();

        if($UserOwnAccount && checkRole(['admin']))
          $data['roles'][getRoleData('admin')] = 'Admin';
        $data['active_class']       = 'users';
        $data['title']              = getPhrase('edit_user');
        $data['layout']             = getLayout();
        return view('users.add-edit-user', $data);
     }



     /**
      * Update the specified resource in storage.
      *
      * @param  int  $id
      * @return Response
      */
     public function update(Request $request, $slug)
     {

        $record     = User::where('slug', $slug)->get()->first();
        $role_name = getRoleData($record->role_id);
         // dd($role_name);
        $validation = [
        'name'      => 'bail|required',
        'email'     => 'bail|required|unique:users,email,'.$record->id,
        'image'     => 'bail|mimes:png,jpg,jpeg|max:2048',
        ];

        if(!isEligible($slug))
        {
          return back();
        }

        if(checkRole(getUserGrade(2)))
          $validation['role_id'] = 'bail|required|integer';
        

        $this->validate($request, $validation);

        $name = $request->name;
        $previous_role_id = $record->role_id;
         if(!env('DEMO_MODE')) {
          if($name != $record->name)
            $record->slug = $record->makeSlug($name);
        }

        $record->name = $name;
        $record->email = $request->email;

        if(checkRole(getUserGrade(2)))
          if($record->role_id!=3){
           if($request->role_id==3){
                $staff               = new App\Staff();
                $staff->staff_id     = $staff->prepareStaffID($record->id);
                $staff->first_name   = $name;
                $staff->user_id      = $record->id;
                $staff->save();
           }
         }
       $record->role_id  = $request->role_id;
       $record->phone    = $request->phone;
       $record->address  = $request->address;

        $record->save();

        if(checkRole(getUserGrade(2)))
        {
          /**
           * Delete the Roles associated with that user
           * Add the new set of roles
           */
         
       if(!env('DEMO_MODE')) {
          DB::table('role_user')
          ->where('user_id', '=', $record->id)
          ->where('role_id', '=', $previous_role_id)
          ->delete();
         $record->roles()->attach($request->role_id);
        }
        }

        $this->processUpload($request, $record);
        flash('success','record_updated_successfully', 'success');
        
       return redirect(URL_USERS_EDIT.$record->slug);
      }



     /**
      * Remove the specified resource from storage.
      *
      * @param  unique string  $slug
      * @return Response
      */
    /**
     * Delete Record based on the provided slug
     * @param  [string] $slug [unique slug]
     * @return Boolean 
     */
    public function delete($slug)
    {
         if(!checkRole(getUserGrade(2)))
        {
          prepareBlockUserMessage();
          return back();
        }
        
        $record = User::where('slug', $slug)->first();
        $role = getRoleData($record->role_id);
        /**
         * Check if user is having any pending records in library
         * If the user is staff, check if the user is allocated to any course-subject
         */
        DB::beginTransaction();
        try{
          $libraryIssue = new App\LibraryIssue();
          $books_taken = $libraryIssue->isUserHavingBookings($record->id);

          if($books_taken==0){
            
            $allocated_course = 0;
            if($role=='staff'){
              $allocated_course = App\CourseSubject::isStaffAllocatedToCourse($record->id);
            }
            if($allocated_course==0){
           if(!env('DEMO_MODE')) {
          
          $imageObject = new ImageSettings();
          $destinationPath      = $imageObject->getProfilePicsPath();
          $destinationPathThumb = $imageObject->getProfilePicsThumbnailpath();
           
          $dependent_record = null;
          $role_name = getRoleData($record->role_id);
          if($role_name == 'student')
            $dependent_record = App\Student::where('user_id','=',$record->id)->first();
          else if($role_name=='staff')
            $dependent_record = App\Staff::where('user_id','=',$record->id)->first();
          
            $image_path = $record->image;
            $record->delete();
            if($dependent_record)
            $dependent_record->delete();

            $this->deleteFile($image_path, $destinationPath);
            $this->deleteFile($image_path, $destinationPathThumb);
             DB::commit();
          }

            $response['status'] = 1;
            $response['message'] = getPhrase('record_deleted_successfully');
        }
        else{
            $response['status'] = 0;
            $response['message'] = getPhrase('staff_is_allocated_to_some_course'); 
        }
      }
        else{
              $response['status'] = 0;
            $response['message'] = getPhrase('this_user_have_to_return').' '.$books_taken.' '.getPhrase('items_in_library');
        }
      }
        catch (Exception $e) {
           DB::rollBack();
                 $response['status'] = 0;
           if(getSetting('show_foreign_key_constraint','module'))
            $response['message'] =  $e->getMessage();
           else
            $response['message'] =  getPhrase('this_record_is_in_use_in_other_modules');
       }
        return json_encode($response);
      
   }



    public function deleteFile($record, $path, $is_array = FALSE)
    {
      
      if(env('DEMO_MODE')) {
        return ;
       }

        $files = array();
        $files[] = $path.$record;
        File::delete($files);
    }

 

    public function listUsers($role_name)
    {
      $role = getRoleData($role_name);
      
      $users = User::where('role_id', '=', $role)->get();
      
      $users_list =  array();
      
      foreach ($users as $key => $value) {
        $r = array('id'=>$value->id, 'text' => $value->name, 'image' => $value->image);
            array_push($users_list, $r);
      }
      return json_encode($users_list);
    }
    
    /**
     * This method is show the promotion details of a student
     */

     public function transfers($slug)
    {   

        $record                      = User::where('slug', $slug)->get()->first();
        $studentdata                 = Student::where('user_id','=',$record->id)->get()->first();

        if(empty($studentdata->academic_id)||empty($studentdata->course_parent_id)||empty($studentdata->course_id)){

          flash('Oops...!','Your Admission Details Are Not Updated', 'overlay');
            return redirect()->back();
        }

        $course_time                 = Course::where('id','=',$studentdata->course_id)->select('course_dueration')->first();
        $having_semisters            = Course::where('id','=',$studentdata->course_id)->get()->first();
        $data['course_time']         = $course_time->course_dueration;
        $data['having_semisters']    = $having_semisters;
        $student_data                = StudentPromotion::where('user_id','=',$record->id)->get();
        $data['student_data']        = $student_data;
        $data['title']               = getPhrase('transfer_details');
        $data['active_class']        = 'users';
        $data['record']              = $record;
        $data['layout']              = getLayout();

      return view('users.user-transfers',$data);
     }
   /**
    * This method return the student library history
    * @param  [string] $slug [description]
    * @return Responses      
    */
     public function student_librarydetails($slug)
     { 

        if(!checkRole(getUserGrade(14)))
        {
          prepareBlockUserMessage();
          return back();
        }
        $record                 = User::where('slug', $slug)->get()->first();
        $data['title']          = getPhrase('library_books_details');
        $data['record']         = $record;
        $data['active_class']   = 'library';
        $data['layout']         = getLayout();


        return view('users.users-libraryhistory',$data);
     }

     public function getlibraryhistory($user_id)
     {
        $records = array();
          
        $records =   LibraryIssue::where('user_id','=',$user_id)
        ->select(['id','library_asset_no','master_asset_id','issued_on','due_date','issue_type','return_on'])
        ->orderBy('updated_at','desc')
        ->get();

        return Datatables::of($records)

        ->editColumn('master_asset_id', function($records) {

          $record =  LibraryMaster::where('id','=',$records->master_asset_id)->get()->first();
          $data ='';
          $data = $record->title;
          return $data;
          
        })
        
        ->editColumn('return_on', function($records) {
          
          if($records->return_on!='')
            return $records->return_on;
          else
            return '-';
          
        })  

        ->editColumn('issue_type', function($records) {
          
          return ucfirst($records->issue_type);
          
        })          
        ->removeColumn('id')
        ->make();

     }

    public function details($slug)
    {
        $record     = User::where('slug', $slug)->get()->first();
         if($record==null){
          flash('Ooops','Undefined User','overlay');
          return back();
         }
         if($record->role_id!=5){
          flash('Ooops','You Have No Permission To Access','overlay');
          return back();
         }

         $name     = $record->name;
        $data['role_name']   = getRoleData($record->role_id);
       
        if($isValid = $this->isValidRecord($record))
         return redirect($isValid);
       
       /**
        * Validate the non-admin user wether is trying to access other user profile
        * If so return the user back to previous page with message
        */

        if(!isEligible($slug))
          return back();

        $data['record']      = $record;
       


         $user = $record;
            //Overall performance Report
            $resultObject = new App\QuizResult();
            $records = $resultObject->getOverallSubjectsReport($user);
            $color_correct          = getColor('background', rand(0,999));
            $color_wrong            = getColor('background', rand(0,999));
            $color_not_attempted    = getColor('background', rand(0,999)); 
            $correct_answers        = 0;
            $wrong_answers          = 0;
            $not_answered           = 0;

            foreach($records as $record) {
                $record = (object)$record;
                $correct_answers    += $record->correct_answers;
                $wrong_answers      += $record->wrong_answers;
                $not_answered       += $record->not_answered;

           } 

            $labels = [getPhrase('correct'), getPhrase('wrong'), getPhrase('not_answered')];
            $dataset = [$correct_answers, $wrong_answers, $not_answered];
            $dataset_label[] = 'lbl';
            $bgcolor  = [$color_correct,$color_wrong,$color_not_attempted];
            $border_color = [$color_correct,$color_wrong,$color_not_attempted];
            $chart_data['type'] = 'pie'; 
            //horizontalBar, bar, polarArea, line, doughnut, pie
            $chart_data['title'] = getphrase('overall_performance');  

            $chart_data['data']   = (object) array(
                    'labels'            => $labels,
                    'dataset'           => $dataset,
                    'dataset_label'     => $dataset_label,
                    'bgcolor'           => $bgcolor,
                    'border_color'      => $border_color
                    );
                
            $data['chart_data'][] = (object)$chart_data;
            
            //Best scores in each quizzes
            $records = $resultObject->getOverallQuizPerformance($user);
            $labels = [];
            $dataset = [];
            $bgcolor = [];
            $bordercolor = [];
            
            foreach($records as $record) {
                $color_number = rand(0,999);
                $record = (object)$record;
                $labels[] = $record->title;
                $dataset[] = $record->percentage;
                $bgcolor[] = getColor('background',$color_number);
                $bordercolor[] = getColor('border', $color_number);
           } 

            $labels = $labels;
            $dataset = $dataset;
            $dataset_label = getPhrase('performance');
            $bgcolor  = $bgcolor;
            $border_color = $bordercolor;
            $chart_data['type'] = 'bar'; 
            //horizontalBar, bar, polarArea, line, doughnut, pie
            $chart_data['title'] = getPhrase('best_performance_in_all_quizzes');

            $chart_data['data']   = (object) array(
                    'labels'            => $labels,
                    'dataset'           => $dataset,
                    'dataset_label'     => $dataset_label,
                    'bgcolor'           => $bgcolor,
                    'border_color'      => $border_color
                    );
                
            $data['chart_data'][] = (object)$chart_data;

        $data['ids'] = array('myChart0', 'myChart1');
        $data['title']         = $name.' '.getPhrase('details');
        $data['layout']        = getLayout();
         $data['active_class'] = 'users';
        if(checkRole(['parent']))
          $data['active_class'] = 'children';
        if(checkRole(['student']))
          $data['active_class'] = 'analysis';
        $data['right_bar']          = TRUE;
     
      $data['right_bar_path']     = 'student.exams.right-bar-performance-chart';
      $data['right_bar_data']     = array('chart_data' => $data['chart_data']);

        return view('users.user-details', $data);
        
    }

    /**
     * This method loads the staff profile page which also contains dashboard
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function staffDetails($slug)
    {

      
       if(!checkRole(getUserGrade(3)))
        {
          prepareBlockUserMessage();
          return back();
        }

        if(!isEligible($slug))
          return back();
        
        $record     = User::where('slug', $slug)->get()->first();
         if($record==null){
          flash('Ooops','Undefined User','overlay');
          return back();
         }
         if($record->role_id!=3){
          flash('Ooops','You Have No Permission To Access','overlay');
          return back();
         }
       
        if($isValid = $this->isValidRecord($record))
         return redirect($isValid);
       
       /**
        * Validate the non-admin user wether is trying to access other user profile
        * If so return the user back to previous page with message
        */

        if(!isEligible($slug))
          return back();
        $data['role_name']   = getRoleData($record->role_id);
        $data['record']      = $record;
        $data['title']        = $record->name.' '.getPhrase('details');
        $data['layout']        = getLayout();
        $data['active_class'] = 'users';
 

        return view('users.staff-details', $data);
        
    }

    /**
     * This method will show the page for change password for user
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function changePassword($slug)
    {

       $record = User::where('slug', $slug)->get()->first();
       
        if($isValid = $this->isValidRecord($record))
         return redirect($isValid);
       /**
        * Validate the non-admin user wether is trying to access other user profile
        * If so return the user back to previous page with message
        */

        if(!isEligible($slug))
          return back();

        $data['record']             = $record;
        $data['active_class']       = 'profile';
        $data['title']              = getPhrase('change_password');
        $data['layout']             = getLayout();
        return view('users.change-password.change-view', $data);
    }
    
    /**
     * This method updates the password submitted by the user
     * @param  Request $request [description]
     * @return [type]           [description]
     */
     public function updatePassword(Request $request)
    {

      
        $this->validate($request, [
            'old_password' => 'required',
            'password'     => 'required|confirmed',
        ]);

        $credentials = $request->only(
            'old_password', 'password', 'password_confirmation'
        );
        $user = \Auth::user();
        
        
        if (Hash::check($credentials['old_password'], $user->password)){

            $user->password = bcrypt($credentials['password']);
            $user->save();

            flash('success','password_updated_successfully', 'success');
            return redirect(URL_USERS_CHANGE_PASSWORD.$user->slug);

        }else {

            flash('Oops..!','old_and_new_passwords are not same', 'error');
            return redirect()->back();            
       }
  }

  /**
    * Display a Import Users page
    *
    * @return Response
    */
     public function importUsers($role = 'student')
     {
        if(!checkRole(getUserGrade(2)))
        {
          prepareBlockUserMessage();
          return back();
        }
      
        $data['records']      = FALSE;
        $data['active_class'] = 'users';
        $data['heading']      = getPhrase('users');
        $data['title']        = getPhrase('import_users');
        $data['academic_years'] = addSelectToList(getAcademicYears());
        $data['layout']        = getLayout();
        return view('users.import.import', $data);
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
      DB::beginTransaction();
       try{
        if(Input::hasFile('excel')){
          $path = Input::file('excel')->getRealPath();
          $data = Excel::load($path, function($reader) {
          })->get();
          $user_record = array();
          $users =array();
          $isHavingDuplicate = 0;
          $role_id = getRoleData('student');
          if(!empty($data) && $data->count()){
            
            foreach ($data as $key => $value) {

              foreach($value as $record)
              {
                unset($user_record);
            
                $user_record['username'] = $record->username;
                $user_record['name'] = $record->name;
                $user_record['email'] = $record->email;

                $user_record['password'] = $record->password;
                $user_record['phone'] = $record->phone;
                $user_record['address'] = $record->address;
                $user_record['role_id'] = $role_id;
                
                $user_record['academic_id'] = $record->academic_id;
                $user_record['course_parent_id'] = $record->course_parent_id;
                $user_record['course_id'] = $record->course_id;
                $user_record['first_name'] = $record->first_name;
                $user_record['last_name'] = $record->last_name;
                $user_record['middle_name'] = $record->middle_name;
                $user_record['date_of_birth'] = $record->date_of_birth;
                $user_record['date_of_join'] = $record->date_of_join;
                $user_record['gender'] = $record->gender;
                $user_record['current_year'] = $record->current_year;
                $user_record['current_semister'] = $record->current_semister;

                $user_record = (object)$user_record;

                $failed_length = count($failed_list);
                if($this->isRecordExists($record->username, 'username'))
                {

                  $isHavingDuplicate = 1;
                  $temp = array();
                 $temp['record'] = $user_record;
                 $temp['type'] ='Record already exists with this name';
                 $failed_list[$failed_length] = (object)$temp;
                  continue;
                }

                if($this->isRecordExists($record->email, 'email'))
                {
                  $isHavingDuplicate = 1;
                  $temp = array();
                 $temp['record'] = $user_record;
                 $temp['type'] ='Record already exists with this email';
                 $failed_list[$failed_length] = (object)$temp;
                  continue;
                }
               
                $users[] = $user_record;
              
              }
            
            }
             if(!env('DEMO_MODE')) {
              if($this->addUser($users)){
                  $success_list = $users;
                DB::commit();
              }
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
       DB::rollBack();
       if(getSetting('show_foreign_key_constraint','module'))
       {

          flash('oops...!',$e->getMessage(), 'error');
       }
       else {
          flash('oops...!',$e->getMessage(), 'error');
       }
     }

        // URL_USERS_IMPORT_REPORT
       $data['failed_list']   =   $failed_list;
       $data['success_list']  =    $success_list;
       $data['records']      = FALSE;
       $data['layout']      = getLayout();
       $data['active_class'] = 'users';
       $data['heading']      = getPhrase('users');
       $data['title']        = getPhrase('report');
      
       return redirect(URL_USERS_IMPORT);
 
     }

public function getFailedData()
{
  return $this->excel_data;
}

public function downloadExcel()
{
    Excel::create('users_report', function($excel) {
      $excel->sheet('Failed', function($sheet) {
      $sheet->row(1, array('Reason','Name', 'Username','Email','Password','Phone','Address'));
      $data = $this->getFailedData();
      $cnt = 2;
      foreach ($data['failed'] as $data_item) {
        $item = $data_item->record;
        $sheet->appendRow($cnt++, array($data_item->type, $item->name, $item->username, $item->email, $item->password, $item->phone, $item->address));
      }
    });

    $excel->sheet('Success', function($sheet) {
      $sheet->row(1, array('Name', 'Username','Email','Password','Phone','Address'));
      $data = $this->getFailedData();
      $cnt = 2;
      foreach ($data['success'] as $data_item) {
        $item = $data_item;
        $sheet->appendRow($cnt++, array($item->name, $item->username, $item->email, $item->password, $item->phone, $item->address));
      }

    });

    })->download('xlsx');

    return TRUE;
}
     /**
      * This method verifies if the record exists with the email or user name
      * If Exists it returns true else it returns false
      * @param  [type]  $value [description]
      * @param  string  $type  [description]
      * @return boolean        [description]
      */
     public function isRecordExists($record_value, $type='email')
     {
        return User::where($type,'=',$record_value)->get()->count();
     }

     public function addUser($users)
     {
      foreach($users as $request) {
        $user           = new User();
        $name           = $request->name;
        $user->name     = $name;
        $user->email    = $request->email;
        $user->username    = $request->username;
        $user->password = bcrypt($request->password);

        $user->role_id        = $request->role_id;
        $user->login_enabled  = 1;
        $user->slug           = $user->makeSlug($name);
        $user->phone          = $request->phone;
        $user->address        = $request->address;

        $user->save();

        $user->roles()->attach($user->role_id);
          
          $current_year     = (int)$request->current_year;
          $current_semister = (int)$request->current_semister;

          $student = new App\Student();
          $student->admission_no = $student->preparestudentID($user->id);
          $student->roll_no = $student->prepareRollNo($user->slug, $request->academic_id, $request->course_parent_id, $request->course_id, $current_year, $current_semister);


          $student->academic_id = (int)$request->academic_id;
          $student->course_parent_id = (int)$request->course_parent_id;
          $student->course_id = (int)$request->course_id;

          $student->first_name = $request->first_name;
          $student->middle_name = $request->middle_name;
          $student->last_name = $request->last_name;
          $student->date_of_birth = $request->date_of_birth;
          $student->date_of_join = $request->date_of_join;
          $student->gender = $request->gender;
          $student->current_year = $current_year;
          $student->current_semister = $current_semister;
          $student->user_id = $user->id;

          $student->save();

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
        }
       return true;
     }

  /**
   * This method shows the user preferences based on provided user slug and settings available in table.
   * @param  [type] $slug [description]
   * @return [type]       [description]
   */
  public function settings($slug)
  {


         if(!checkRole(getUserGrade(13)))
        {
          prepareBlockUserMessage();
          return back();
        }
        
       $record = User::where('slug', $slug)->get()->first();
       
        if($isValid = $this->isValidRecord($record))
         return redirect($isValid);
       /**
        * Validate the non-admin user wether is trying to access other user profile
        * If so return the user back to previous page with message
        */
        

        if(!isEligible($slug))
          return back();
        

        /**
         * Make sure the Admin or staff cannot edit the Admin/Owner accounts
         * Only Owner can edit the Admin/Owner profiles
         * Admin can edit his own account, in that case send role type admin on condition
         */
        
     $UserOwnAccount = FALSE;
     if(\Auth::user()->id == $record->id)
      $UserOwnAccount = TRUE;
    
      if(!$UserOwnAccount)  {
        $current_user_role = getRoleData($record->role_id);

        if((($current_user_role=='admin' || $current_user_role == 'owner') ))
        {
          if(!checkRole(getUserGrade(1))) {
            prepareBlockUserMessage();
            return back();
          }
        }
      }

       $data['record']       = $record;
       $data['quiz_categories']   = App\QuizCategory::get();
       $data['lms_category'] = App\LmsCategory::get();
       $data['layout']       = getLayout();
       $data['active_class'] = 'users';
       $data['heading']      = getPhrase('account_settings');
       $data['title']        = getPhrase('account_settings');
       return view('users.account-settings', $data);

} 
  
  /**
   * This method updates the user preferences based on the provided categories
   * All these settings will be stored under Users table settings field as json format
   * @param  Request $request [description]
   * @param  [type]  $slug    [description]
   * @return [type]           [description]
   */
  public function updateSettings(Request $request, $slug)
  {
        $record = User::where('slug', $slug)->get()->first();
       
        if($isValid = $this->isValidRecord($record))
         return redirect($isValid);
       /**
        * Validate the non-admin user wether is trying to access other user profile
        * If so return the user back to previous page with message
        */
       
        if(!isEligible($slug))
          return back();
        

        /**
         * Make sure the Admin or staff cannot edit the Admin/Owner accounts
         * Only Owner can edit the Admin/Owner profiles
         * Admin can edit his own account, in that case send role type admin on condition
         */
        
     $UserOwnAccount = FALSE;
     if(\Auth::user()->id == $record->id)
      $UserOwnAccount = TRUE;
    
      if(!$UserOwnAccount)  {
        $current_user_role = getRoleData($record->role_id);

        if((($current_user_role=='admin' || $current_user_role == 'owner') ))
        {
          if(!checkRole(getUserGrade(1))) {
            prepareBlockUserMessage();
            return back();
          }
        }
      }

    $options = [];
    if($record->settings)
    {
      $options =(array) json_decode($record->settings)->user_preferences;
      
    }

    $options['quiz_categories'] = [];
    $options['lms_categories']  = [];
    if($request->has('quiz_categories')) {
    foreach($request->quiz_categories as $key => $value)
      $options['quiz_categories'][] = $key;
    }
    if($request->has('lms_categories')) {
      foreach($request->lms_categories as $key => $value)
        $options['lms_categories'][] = $key;
    }
    
    $record->settings = json_encode(array('user_preferences'=>$options));
    $record->save();
    flash('success','record_updated_successfully', 'success');
     return back();
  }  



  
  /**
 * This method provides information for the 
 * exams with details like academic id, course parent id 
 * and course id with year and semister details to fill in excel
 * @param  Request $request [description]
 * @return [type]           [description]
 */
public function getExcelUploadInformation(Request $request)
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

      
     $course_record = App\Course::where('id','=',$course_id)->first();
     $course_parent_record = App\Course::where('id', '=', $course_parent_id)->first();
     $academic_record = App\Academic::where('id','=',$academic_id)->first();
     $records['academic_id'] = $academic_record->id;
     $records['course_id'] = $course_record->id;
     $records['course_parent_id'] = $course_parent_record->id;
     $records['year'] = $year;
     $records['semister'] = $semister;
 
    
    return $records;
}

}
