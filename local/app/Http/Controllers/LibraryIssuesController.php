<?php

namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\LibraryAssetType;
use App\LibraryMaster;
use App\LibrarySettings;
use App\libraryInstance;
use App\LibraryIssue;
use App\User;
use App\Student;
use Yajra\Datatables\Datatables;
use DB;
use Auth;
use Image;
use ImageSettings;
use Illuminate\Support\Facades\Validator;
use Response;
use Carbon\Carbon;
class LibraryIssuesController extends Controller
{


	 public function __construct()
    {
    	$this->middleware('auth');
    }


    
    public function users($role_name = 'student')
    {  

         if(!checkRole(getUserGrade(9)))
      {
        prepareBlockUserMessage();
        return back();
      }
        if(!checkRole(getUserGrade(15))){
        $data['active_class']       = 'library';
          }
        elseif(checkRole(getUserGrade(15)) && $role_name=='staff'){
          $data['active_class']     = 'staff';  
        }
        else{
          $data['active_class']     = 'students';  
        }
        $data['user_type']          = $role_name;
        $data['layout']             = getLayout();
        if($role_name =='student'){
        $data['title']              = getPhrase('student_users');
         }
          if($role_name =='staff'){
        $data['title']              = getPhrase('staff_users');
         }
        
        if($role_name == 'student')
        $data['table_columns']      = ['roll_no', 'image', 'first_name', 'last_name', 'email'];
        
        else if($role_name == 'staff')
        $data['table_columns']      = ['staff_id', 'image', 'first_name', 'last_name', 'email'];
        $data['module_helper']      = getModuleHelper('library-users-list');

        return view('library.users.list', $data);        
    }

    public function getUsers($role_name='student')
    {
         if(!checkRole(getUserGrade(9)))
      {
        prepareBlockUserMessage();
        return back();
      }

        $records = array();
        if($role_name == 'student') {
         $records = Student::join('users','users.id', '=', 'students.user_id')
         ->where('students.academic_id','!=','')
         ->where('students.course_parent_id','!=','')
         ->where('students.course_id','!=','')
         ->where('students.roll_no','!=','')
         ->where('students.current_year','!=','-1')
         ->where('students.current_semister','!=','-1')
         ->select(['roll_no','users.image','first_name','last_name','users.email','users.slug']);

        return Datatables::of($records)
        ->editColumn('image', function($records){
            return '<img src="'.getProfilePath($records->image).'"  />';
        })
           ->editColumn('roll_no', function($records){
            return '<a href="'.URL_LIBRARY_ISSUES.$records->slug.'">'.$records->roll_no.'</a>';
        })
         ->removeColumn('slug')
         ->make(true);

        }
        else if($role_name == 'staff') {

         $records = App\Staff::join('users','users.id','=','staff.user_id')
         ->where('staff.course_parent_id','!=','')
         ->where('staff.course_id','!=','')
         ->where('status','!=',0)
            ->select(['staff.staff_id','users.image','staff.first_name','staff.last_name','users.email','users.slug' ]);

        return Datatables::of($records)
        ->editColumn('image', function($records){
            return '<img src="'.getProfilePath($records->image).'"  />';
        })
           ->editColumn('staff_id', function($records){
            return '<a href="'.URL_LIBRARY_ISSUES.$records->slug.'">'.$records->staff_id.'</a>';
        })

        ->removeColumn('slug')
         ->make(true);
        }


        
    }

    public function issueAsset($slug)
    {
      if(!checkRole(getUserGrade(9)))
      {
        prepareBlockUserMessage();
        return back();
      }
         $record = User::getRecordWithSlug($slug);  
         if($isValid = $this->isValidRecord($record))
            return redirect($isValid);      
         
         $role = getRoleData($record->role_id);
         

            $data['active_class']       = 'library';
            $data['user']               = $record;
            
            if($role == 'student')
                $data['student']            = $record->student;
            
            if($role=='staff')
                $data['staff']            = $record->staff;
            
            $data['title']              = getPhrase('issue_asset');

            if($role == 'student')
            $data['table_columns']      = ['roll_no', 'image', 'first_name', 'last_name', 'email'];
            
            if($role == 'staff')
            $data['table_columns']      = ['staff_id', 'image', 'first_name', 'last_name', 'email'];
            
            $data['role']               = $role;
           $data['layout']               = getLayout();
          $data['module_helper']      = getModuleHelper('library-users-issue-book');


            return view('library.users.issue', $data);                      


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
    	return URL_LIBRARY_USERS;
    }

    public function getReference(Request $request)
    {
    	
    	 $term = strtolower($request->term);

    
    
    $list = App\LibraryInstance::where('asset_no','like','%'.$term.'%') 
                ->where('status', '=', 'available')
                ->where('asset_type', '=', 'general')
                ->where('asset_type', '!=', 'reference')
               ->get();
            
    $return_array = array();

    foreach ($list as $l) {
            $return_array[] = array('value' => $l->asset_no, 'id' =>$l->id);
    }
   
    return Response::json($return_array);
    }


    public function getstaffReference(Request $request)
    {
        
         $term = strtolower($request->term);

    
    
    $list = App\LibraryInstance::where('asset_no','like','%'.$term.'%') 
                ->where('status', '=', 'available')
                ->where('asset_type', '=', 'staff')
                ->where('asset_type', '!=', 'reference')
               ->get();
            
    $return_array = array();

    foreach ($list as $l) {
            $return_array[] = array('value' => $l->asset_no, 'id' =>$l->id);
    }
   
    return Response::json($return_array);
    }


    public function getMasterDetails(Request $request)
    {
    	$asset_id  = $request->asset_id;
    	$user_id   = $request->user_id;
    	$instance  = App\LibraryInstance::where('id','=',$asset_id)->first();
    	$asset     = $instance->masterRecord;
    	$asset_type = $asset->assetType;
    	$details   = '';
    	if($asset){
    		$author = $asset->author;
    		$publisher = $asset->publisher;

	    	$details  = '<li><span>'.getPhrase('title').'</span> <strong>'.$asset->title.'</strong></li>';
	    	$details .= '<li><span>ISBN</span> <strong>'.$asset->isbn.'</strong></li>';
	    	$details .= '<li><span>'.getPhrase('edition').'</span> <strong>'.$asset->edition.'</strong></li>';
	    	$details .= '<li><span>'.getPhrase('author').'</span> <strong>'.$author->author.'</strong></li>';
	    	$details .= '<li><span>'.getPhrase('publisher').'</span> <strong>'.$publisher->publisher.'</strong></li>';
	    	$details .= '<li><span>'.getPhrase('total').'</span> <strong>'.$asset->total_assets_count.'</strong></li>';
	    	$details .= '<li><span>'.getPhrase('available').'</span> <strong>'.$asset->total_assets_available.'</strong></li>';
    	}
    	
    	$librarySettings =  getLibrarySettings();
    	/**
    	 * The follwoing call will check the eligiblity of that user
    	 * with respective to asset requested to issue
    	 * That will return 2 objects 'message' and is_eligible
    	 * The message will contain the message to display
    	 * is_eligible (boolen) with dicide to show issue button or not
    	 */
    	$eligiblity = (object) $this->getEligiblityDetails($user_id, $asset);

    	$instance_details = '';
    	if($instance)
    	{
    		$instance_details .= '<li><span>'.getPhrase('category').'</span> <strong>'.ucfirst($asset_type->asset_type).'</strong></li>';
    		$instance_details .= '<li><span>'.getPhrase('reference_no.').'</span> <strong>'.$instance->asset_no.'</strong></li>';
    		$instance_details .= '<li><span>'.getPhrase('type').'</span> <strong>'.ucfirst($instance->asset_type).'</strong></li>';
    		$instance_details .= '<li><span>'.getPhrase('status').'</span> <strong>'.ucfirst($instance->status).'</strong></li>';
    		$instance_details .= '<li><span>'.getPhrase('eligiblity').'</span> <strong>'.$eligiblity->message.'</strong></li>';

    		if($eligiblity->is_eligible)
    		{
    			$instance_details .='<input type="hidden" name="master_asset_id" value="'.$asset->id.'" />';
    			$instance_details .='<input type="hidden" name="library_instance_id" value="'.$instance->id.'" />';
    			$instance_details .='<input type="hidden" name="user_id" value="'.$user_id.'" />';
    		}

    	}


    	$button = '';
    	if($eligiblity->is_eligible)
    	{
    		$button = '<button onClick="alert(/"hello jack/");" class="btn btn-lg btn-primary button">'.getPhrase('issue').'</button>
						';
    	}


    	$imagepath = $librarySettings->libraryImagepath.$asset->image;
        $imagepath = IMAGE_PATH_UPLOAD_EXAMSERIES_DEFAULT;
        if($asset->image)
            $imagepath = IMAGE_PATH_UPLOAD_LIBRARY.$asset->image;

		$data['image'] = '<img class="img-responsive" src="'.$imagepath.'" />';
		$data['master_details'] = $details;
		$data['instance_details'] = $instance_details;
		$data['button'] = $button;
		 
    	return Response::json($data);
    }

    /**
     * Returns the Eligiblity Cretria based on the following conditions
     * The user should not reach the maximum number of record issues specified by admin
     * The user should not take the same record if it has been already issued
     * @param  [type] $user_id [userID from users table]
     * @param  [type] $asset   [Master Library Record]
     * @return [type]          [Returns array with 2 values, message(string) and is_eligible(boolen)]
     */
    public function getEligiblityDetails($user_id, $asset)
    {
    	/**
    	 * Student eligiblity for this asset issue
    	 */
    	$user_record = App\User::where('id','=',$user_id)->first();
        $role = getRoleData($user_record->role_id);
    	$current_records = (new LibraryIssue())->getCurrentIssuedRecords($user_id);
        
        $student_maximum_issues = getSetting('maximum_issues_student','library_settings');
        if($role=='staff')
        $student_maximum_issues = getSetting('maximum_issues_staff','library_settings');
        
    	$message = '<p>The user is eligible to take '. ($student_maximum_issues - count($current_records)) . ' item(s)</p>';
    	$is_eligible = TRUE;
    	if($student_maximum_issues <= count($current_records))
    	{
    		$is_eligible = FALSE;
    	}

    	/**
    	 * Check if user is attempting to take same master record
    	 */
    	 
    	if(count($current_records)>0 && $is_eligible)
    	{
    		foreach($current_records as $record) {
    			if($asset->id == $record->master_asset_id)
    			{
    				  
    				$is_eligible = FALSE;
    				$message .='<p style="color:red">The same item is already issued</p>';
    				break;
    			}
    		}
    	}

    	return array('message' => $message, 'is_eligible' => $is_eligible);
    }

    public function store(Request $request)
    {
    	  

    	$this->validate($request, [
    		'master_asset_id' 		=> 'bail|required|integer',
    		'library_instance_id' 	=> 'bail|required|integer',
    		'user_id'				=> 'bail|required|integer',
    		]);
    	
    	// $librarySettings = getLibrarySettings();
        $student_maximum_days_to_return = getSetting('maximum_days_to_return_student','library_settings');
    	$user = User::where('id','=',$request->user_id)->first();
    	$record = new LibraryIssue();
    	$record->master_asset_id 		= $request->master_asset_id;
    	$record->library_instance_id 	= $request->library_instance_id;
    	$record->library_asset_no 		= $request->library_asset_no;
    	$record->user_id 				= $request->user_id;
    	$record->issue_type 			= 'issue';
    	$record->issued_on 				= Carbon::now();
    	$record->due_date 				= Carbon::now()
    									->addDays($student_maximum_days_to_return);
    	$record->record_updated_by 		= Auth::user()->id;

    	$record->save();

    	//Update Instance and Master records status and count

    	(new App\LibraryInstance())->updateInstanceRecord($record->library_instance_id, 'issued');

    	flash('success','asset_issued_successfully', 'success');
       return redirect('library/issue/'.$user->slug);
    }

    /**
     * This method is to return an asset the following operation need to take place
     * Update status in asset issues table
     * Update status in asset instances
     * Update count in asset masters
     * Redirect user to this view
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function returnAsset(Request $request)
    {
      if(!checkRole(getUserGrade(9)))
      {
        prepareBlockUserMessage();
        return back();
      }
        $user_id        = $request->user_id;
        $issue_id       = $request->issue_id;
        $instance_id    = $request->instance_id;
        $master_id      = $request->master_id;
        $record = LibraryIssue::where('id','=',$issue_id)->get()->first();
        
        //Validate if the same user has taken this record?
        if($record->user_id != $user_id)
        {
            flash('error','asset_not_belongs_to_this_user', 'error');
            return redirect(URL_LIBRARY_ISSUES.$slug);
        }

        $record->issue_type = 'return';
        $record->return_on = Carbon::now();
        $record->record_updated_by = Auth::user()->id;
        $record->save();
        
        (new App\LibraryInstance())->updateInstanceRecord($record->library_instance_id, 'available');
        flash('success','record_updated_successfully', 'success');
       return redirect(URL_LIBRARY_LIBRARYDASHBOARD_BOOKS);
    } 

     public function returnStaffAsset(Request $request)
    { 
         if(!checkRole(getUserGrade(9)))
      {
        prepareBlockUserMessage();
        return back();
      }

        $user_id        = $request->user_id;
        $issue_id       = $request->issue_id;
        $instance_id    = $request->instance_id;
        $master_id      = $request->master_id;
        $record = LibraryIssue::where('id','=',$issue_id)->get()->first();
        
        //Validate if the same user has taken this record?
        if($record->user_id != $user_id)
        {
            flash('error','asset_not_belongs_to_this_user', 'error');
            return redirect(URL_LIBRARY_ISSUES.$slug);
        }

        $record->issue_type = 'return';
        $record->return_on = Carbon::now();
        $record->record_updated_by = Auth::user()->id;
        $record->save();
        
        (new App\LibraryInstance())->updateInstanceRecord($record->library_instance_id, 'available');
        flash('success','record_updated_successfully', 'success');
       return redirect(URL_LIBRARY_LIBRARYDASHBOARD_BOOKS_STAFF);
    }


}
