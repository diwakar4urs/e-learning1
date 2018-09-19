<?php

namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Course;
use Yajra\Datatables\Datatables;
use DB;
use Exception;
class CourseController extends Controller
{
       
    public function __construct()
    {
    	$this->middleware('auth');
    }
    
    /**
     * This method will display the courses dashboard
     */

     public function coursesdashboard()
    {

      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
      
      $data['active_class']       = 'master_settings';
      $data['title']              = getPhrase('master_setup_dashboard');
      $data['layout']             = getLayout();
      $data['module_helper']      = getModuleHelper('mastersetup-dashboard');
      return view('courses.dashboard', $data);  
       
    }

    /**
     * Course listing method
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $data['active_class']       = 'master_settings';
        $data['title']              = getPhrase('course list');
        $data['layout']             = getLayout();
        $data['module_helper']      = getModuleHelper('courses-list');
        return view('mastersettings.course.list', $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable()
    {
         $records = Course::select([ 'parent_id', 'course_title','course_code','course_dueration','grade_system','is_having_semister','is_having_elective_subjects','slug', 'id'])
         ->orderBy('updated_at','desc');
        
        return Datatables::of($records)
        ->addColumn('action', function ($records) {
           $editSemister = '';
           if($records->parent_id)
           {
           	if ($records->is_having_semister) {
           		$editSemister = '<li><a href="'.URL_MASTERSETTINGS_COURSE_EDIT_SEMISTER.'/'.$records->slug.'"><i class="icon-packages"></i>'.getPhrase("edit_semisters").'</a></li>';
           		}
           }


            return '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="'.URL_MASTERSETTINGS_COURSE_EDIT.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>
                            '.$editSemister.'
                            <li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="fa fa-trash"></i>'. getPhrase("delete").'</a></li>
                        </ul>
                    </div>';
            })
        ->editColumn('course_title', function($records){
            return $records->course_title.' ('.$records->id.')';
        })
        
       ->editColumn('parent_id', function($records){
        
          return ($records->parent_id == 0) ? '<i class="fa fa-check text-success"></i>' : 
          Course::getCourseRecord($records->parent_id)['course_title'];
        })

        ->editColumn('course_dueration', function($records){
        	return 

        	($records->parent_id) ? $records->course_dueration .' '.getPhrase('years') : '-';
        })
         ->editColumn('grade_system', function($records){

           if($records->grade_system!='percentage')
          return strtoupper($records->grade_system);
           else
          return ucfirst($records->grade_system);

            
        })
        ->editColumn('is_having_semister', function($records){
        	return ($records->parent_id) ? ($records->is_having_semister) ? getPhrase('yes') : getPhrase('no') : 
        	'-';
        })
        ->editColumn('is_having_elective_subjects', function($records){
        	return ($records->parent_id) ? ($records->is_having_elective_subjects) ? getPhrase('yes') : getPhrase('no') : '-';
        })
        ->removeColumn('id')
        ->removeColumn('slug')
        ->make();
    }

    /**
     * This method loads the create view
     * @return void
     */
    public function create()
    {
    	$data['record']         	    = FALSE;
    	$data['active_class']           = 'master_settings';
    	$list 						    = Course::getCourses(0);
    	$data['course_parent_list']	    = array_pluck($list, 'course_title', 'id');
    	$data['course_parent_list'][0]	= 'Parent';
        $data['title']                  = getPhrase('add_course');
    	$data['layout']                 = getLayout();
        $data['module_helper']          = getModuleHelper('create-course');
 
      	return view('mastersettings.course.add-edit', $data);
    }

    /**
     * This method loads the edit view based on unique slug provided by user
     * @param  [string] $slug [unique slug of the record]
     * @return [view with record]       
     */
    public function edit($slug)
    {
    	$record = Course::where('slug', $slug)->get()->first();
    	$data['record']       		= $record;
    	$list 						= Course::getCourses(0);
    	$data['course_parent_list']	= array_pluck($list, 'course_title', 'id');
    	$data['course_parent_list'][0]	= 'Parent';
    	$data['active_class']       = 'master_settings';
        $data['title']              = getPhrase('edit_course');
        $data['layout']              = getLayout();
    	return view('mastersettings.course.add-edit', $data);
    }

    /**
     * Update record based on slug and reuqest
     * @param  Request $request [Request Object]
     * @param  [type]  $slug    [Unique Slug]
     * @return void
     */
    public function update(Request $request, $slug)
    {

        $record                 = Course::where('slug', $slug)->get()->first();
        
          $this->validate($request, [
       	 'course_title'          => 'bail|required|max:60',
         'course_code'           => 'bail|required|max:20|unique:courses,course_code,'.$record->id,
         'parent_id'          	 => 'bail|required|integer',
         'course_dueration'      => 'bail|required|integer',
          ]);

        $name 					        = $request->course_title;
       
       /**
        * Check if the title of the record is changed, 
        * if changed update the slug value based on the new title
        */
        if($name != $record->course_title)
            $record->slug = $record->makeSlug($name,TRUE);
    	
     
     /**
      * Check if semisters or years information is changed
      * if changed, modify the coursesemisters table
      */
    	if($record->is_having_semister)
    	{
    		if($request->is_having_semister)
    		{
    			if ($request->course_dueration != $record->course_dueration) {
    				//Reset semisters 
    				//1 Delete all
    				//2 Create as per the dueration
    				$record->course_dueration		= $request->course_dueration;
    				$this->createSemisters($record, TRUE);
    			}
    		}
    		else
    		{
    			/**
    			 * Removed semisters option, so delete the records
    			 */
    			$this->resetSemisters($record);
    		}
    	}
    	else if($request->is_having_semister)
    	{
    		/**
    		 * Currently added semisters option, so crate semister records
    		 */
    		$record->course_dueration		= $request->course_dueration;
    		$this->createSemisters($record);
    	}

        $record->course_title = $name;
        $record->course_code			= $request->course_code;
        $record->parent_id				= $request->parent_id;
        $record->course_dueration		= $request->course_dueration;
        $record->grade_system			= $request->grade_system;
        $record->is_having_semister		= $request->is_having_semister;
        $record->is_having_elective_subjects = $request->is_having_elective_subjects;
        $record->description 			= $request->description;
        $record->save();


    	flash('success','record_updated_successfully', 'success');
    	return redirect('mastersettings/course');
    }

    /**
     * This method adds record to DB
     * @param  Request $request [Request Object]
     * @return void
     */
    public function store(Request $request)
    {
     $rules =[
          'course_title'          => 'bail|required|max:60',
          'course_code'           => 'bail|required|max:20|unique:courses,course_code',
          'parent_id'              => 'bail|required|integer'
          ];
       $this->validate($request, $rules);
        $record = new Course();     
        $name                           = $request->course_title;
        $record->course_title           = $name;
        $record->slug                   = $record->makeSlug($name, TRUE);
        $record->course_code            = $request->course_code;
        $record->parent_id              = $request->parent_id;
        $record->course_dueration       = 1;
        $record->grade_system           = 0;
        $record->is_having_semister     = 0;
        $record->is_having_elective_subjects = 0;
        $record->description            = $request->description;

        if($request->parent_id!=0){

            $rules   =[
               'course_dueration'      => 'bail|required|integer'
            ];

        $record->course_dueration            = $request->course_dueration;
        $record->grade_system                = $request->grade_system;
        $record->is_having_semister          = $request->is_having_semister;
        $record->is_having_elective_subjects = $request->is_having_elective_subjects;
        }

        
          $record->save();



        if($record->is_having_semister)
        {
        	$this->createSemisters($record);
        }

        flash('success','record_added_successfully', 'success');
    	return redirect('mastersettings/course');
    }

    /**
     * Delets the records with the sent record
     * @param  [type] $record [request/database row object]
     * @return [type]         [description]
     */
    public function resetSemisters($record)
    {
        if(!env('DEMO_MODE')) {
    	   DB::table('coursesemisters')->where('course_id', '=', $record->id)->delete();
        }
    }

    /**
     * Creates the semisters based on the dueration
     * @param  [type]  $record [request/database row object]
     * @param  boolean $reset  [If true, first delets the semisters based on course Id]
     * @return [type]          [description]
     */
    public function createSemisters($record, $reset = FALSE)
    {
    	if($reset)
    	{
    		$this->resetSemisters($record);
    	}

    	for($year = 1; $year <= $record->course_dueration; $year++)
        	{
        		$coursesem = new App\CourseSemister();
        		$coursesem->course_id 	= $record->id;
        		$coursesem->year 		= $year;
        		$coursesem->total_semisters	= 0;
				$coursesem->save();        		
        	}
    }

    /**
     * Delete Record based on the provided slug
     * @param  [string] $slug [unique slug]
     * @return Boolean 
     */
    public function delete($slug)
    {
        try{
        if(!env('DEMO_MODE')) {
            $is_eligible_to_delete = TRUE;
            $record = Course::where('slug', $slug)->first();
            if($record->parent_id==0) {
                // This course is a parent course, so check if any 
                // child courses available with this course id.
                // If available, do not delete this course record
                $count = Course::where('parent_id', '=', $record->id)->count();
                if($count>0)
                    $is_eligible_to_delete = FALSE;
            }
            if($is_eligible_to_delete) {
                $record->delete();
                $response['status'] = 1;
                $response['message'] = getPhrase('record_deleted_successfully');
            }
            else {
                $response['status'] = 0;
                $response['message'] = getPhrase('this_record_is_in_use_in_other_modules');    
            }
           }
           else{
             $response['status'] = 1;
            $response['message'] = getPhrase('record_deleted_successfully');
           }
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
     * This method loads the edit view based on unique slug provided by user
     * @param  [string] $slug [unique slug of the record]
     * @return [view with record]       
     */
    public function editSemisters($slug)
    {
    	$record = Course::where('slug', $slug)->get()->first();

    	$data['records']       		= $record->semisters;
    	 
    	$data['active_class']       = 'master_settings';
        $data['title']              = getPhrase('edit_semister');
        $data['module_helper']          = getModuleHelper('edit-semister');
    	return view('mastersettings.course.edit-semisters', $data);
    }

    /**
     * Update semisters information for the selected course
     * @param  Request $request  [Contains the list of KEY Value Pairs]
     * @return [type]            [description]
     */
    public function updateSemisters(Request $request)
    {
    	$input = $request->all();
    	foreach($input as $key => $val)
    	{
    		if(is_numeric($key))
    		{
    			$rec = App\CourseSemister::find($key);
    			$rec->total_semisters = $val;
    			$rec->save();
    		}
    	}
 		flash('success', 'record_updated_successfully', 'success');
    	return redirect('mastersettings/course');
    }
}
