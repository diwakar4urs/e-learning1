<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\Http\Requests;
use App\User;
use App\Staff;
use App\Course;
use App\GeneralSettings as Settings;
use Carbon\Carbon;
class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index()
    {
        $data['record']       = FALSE;
        $data['active_class'] = 'users';
        $data['layout'] = getLayout();
      
        $data['title']        = getPhrase('add_users');
        return view('users.staff.add-edit-staff', $data);
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
      
        $userRecord = User::where('slug', $slug)->get()->first();

        $data['userRecord']         = $userRecord;
        $phone_number               = $userRecord->phone;
        $staffRecord                = Staff::where('user_id', $userRecord->id)->get()->first();
        
        $data['join_date']          =  isset($staffRecord->date_of_join) ?  $staffRecord->date_of_join:'';
        $data['birth_date']         = isset($staffRecord->date_of_birth) ? $staffRecord->date_of_birth : '';
        if($staffRecord->course_parent_id!=0 && $staffRecord->course_id!=0){
        $course_parent_name            = Course::where('id','=',$staffRecord->course_parent_id)->
        select('course_title')->first();
        $data['course_parent_name']    = $course_parent_name->course_title;

        $course_name                   = Course::where('id','=',$staffRecord->course_id)->
        select('course_title')->first();
        $data['course_name']     = $course_name->course_title;
         }
        $staffObject                = new Staff();
        $data['staffID']            = $staffObject->prepareStaffID($userRecord->id); 
        $data['record']             = $staffRecord;
        $data['countries']          = (new Settings())->getCountries();
        $data['active_class']       = 'users';
        $data['tab_active']         = $tab;
        $list                       = App\Course::getCourses(0);
        $data['courses_parent_list']=  addSelectToList(array_pluck($list, 'course_title', 'id'));
        $data['courses_list']       = array();

        if(isset($staffRecord->course_parent_id))
        {
           $list                 = App\Course::getCourses($staffRecord->course_parent_id);
           $data['courses_list'] = array_pluck($list, 'course_title', 'id');
        }
        $selected_course = null;
        $data['user_name']           = $userRecord->name;
        $data['ph_no']              = $phone_number;
        $data['layout']              = getLayout();

        return view('users.staff.add-edit-staff', $data);
    }

 /**
     * Update general details
     * @param  Request $request [Input form request]
     * @param  [type]  $id      [Staff Record ID]
     * @return [type]           [redirect to next page]
     */
    public function updateGeneralDetails(Request $request, $id)
    {
        $this->validate($request, [
        'date_of_join'  => 'bail|required|max:20|',
        
        'job_title'     => 'bail|required|max:20|',
        'qualification' => 'bail|required|max:20|',
        'total_experience_years' 
                        => 'bail|required|between:0,20|',
         'total_experience_month' 
                        => 'bail|required|between:0,12|'
        ]);

        $staff          = Staff::find($id);
        $slug           = User::where('id',$staff->user_id)
                             ->pluck('slug')->first();
       
        $staff->date_of_join             = $request->date_of_join;
        $staff->course_parent_id         = $request->course_parent_id;
        $staff->course_id                = $request->course_id;
        $staff->job_title                = $request->job_title;
        $staff->qualification            = $request->qualification;
        $staff->total_experience_years   = $request->total_experience_years;
        $staff->total_experience_month   = $request->total_experience_month;
        $staff->experience_information   = $request->experience_information;
        $staff->other_information        = $request->other_information;
        
        $staff->save();
        flash('success','record_updated_successfully', 'success');
        return redirect('staff/profile/edit/'.$slug.'/personal');

    }

     /**
     * Update personel details
     * @param  Request $request [Input form request]
     * @param  [type]  $id      [Staff Record ID]
     * @return [type]           [redirect to next page]
     */
    public function updatePersonalDetails(Request $request, $id)
    {
         
        $this->validate($request, [
        'first_name'  => 'bail|required|max:20|',
        'date_of_birth' => 'bail|required|',
        ]);

        $staff                  = Staff::find($id);
        $slug                   = User::where('id',$staff->user_id)
                                     ->pluck('slug')->first();
        $staff->first_name      = $request->first_name;
        $staff->middle_name     = $request->middle_name;
        $staff->last_name       = $request->last_name;
        $staff->gender          = $request->gender;
        $staff->blood_group     = $request->blood_group;
        $staff->date_of_birth   = $request->date_of_birth;    
        $staff->fathers_name    = $request->fathers_name;    
        $staff->mothers_name    = $request->mothers_name;    
        $staff->nationality     = $request->nationality;    
        $staff->mother_tongue  = $request->mother_tongue;    
        $staff->save();
        flash('success','record_updated_successfully', 'success');
        return redirect('staff/profile/edit/'.$slug.'/contact');

    }


    /**
     * Update personel details
     * @param  Request $request [Input form request]
     * @param  [type]  $id      [Staff Record ID]
     * @return [type]           [redirect to next page]
     */
    public function updateContactDetails(Request $request, $id)
    {
         
        $this->validate($request, [
        'address_lane1'     => 'bail|required|max:50|',
        'city'              => 'bail|required|max:50',
        'state'             => 'bail|required|max:50',
        'country'           => 'bail|required',
        'zipcode'           => 'bail|required',
        'mobile'            => 'bail|required|numeric',
        ]);

        $staff                  = Staff::find($id);
        $slug                   = User::where('id',$staff->user_id)
                                     ->pluck('slug')->first();
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
        return redirect('staff/profile/edit/'.$slug.'/personal');
    }

    public function show($slug)
    {
        $userRecord                 = User::where('slug', $slug)->get()->first();
        $staffRecord                = Staff::where('user_id', $userRecord->id)->get()->first();
        $data['user_record']        = $userRecord;
        $data['staff_record']       = $staffRecord;
        $data['department']         = \App\Department::find($staffRecord->department_id)->first();
        $data['active_class']       = 'users';
        $data['title']              = getPhrase('staff_profile');        
        return view('users.staff.staff-profile', $data);
    }


}
