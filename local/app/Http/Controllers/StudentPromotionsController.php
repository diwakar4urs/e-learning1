<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use \App;
use StudentPromotion;
use Auth;
use Exception;
use DB;
class StudentPromotionsController extends Controller
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
        $data['active_class']       = 'academic';
        $data['academic_years']     = addSelectToList(getAcademicYears());
        $data['title']              = getPhrase('student_promotions');
        $data['layout']             = getLayout();
        $data['module_helper']      = getModuleHelper('student-transfers');
        return view('student-promotions.selection-view', $data);
    }

    /**
     * This method will transfer the students as per the specifications
     * submitted by admin
     * 1) This method will insert the records to 
     * studentpromotions table with clear details like
     * promoted or detained with specific reason submitted by admin
     * 2) It will update the students table with current_year and current_semister
     * columns for the specific user
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function transferStudents(Request $request)
    {
 
        if($request->is_completed==0) {

        $academic_id          = $request->academic_id;
        $course_parent_id     = $request->course_parent_id;
        $course_id            = $request->course_id;
        $from_year            = 1;
        $from_semister        = 0;

        $to_academic_id       = $request->to_academic_id;
        $to_course_id         = $request->to_course;
        $to_year              = 1;
        $to_semister          = 0;

        $from_course_record = App\Course::where('id', '=', $course_id)->first();
        $has_error = false;
        if($from_course_record)
        {
            if($from_course_record->course_dueration>1)
            {
                 $from_year            = $request->current_year;
            }
        }
        else {
            $has_error = true;
        }
        $to_course_record = App\Course::where('id', '=', $to_course_id)->first();
        $has_error = false;
        if($to_course_record)
        {
            if($to_course_record->course_dueration>1)
            {
                $to_year              = $request->to_year;
            }
        }
        else {
            $has_error = true;
        }

        if($has_error)
        {
            flash('oops...!','improper_selection', 'error');
            return redirect(URL_STUDENT_TRANSFERS);
        }

        $remarks              = $request->remarks;
        
       

        if($request->has('current_semister'))
            $from_semister = $request->current_semister;
        if($request->has('to_semister'))
            $to_semister = $request->to_semister;
        
        $record_updated_by    = Auth::user()->id;

        if(!$from_year)
            $from_year=1;
        if(!$to_year)
            $to_year=1;
 
        DB::beginTransaction();
      try{

        foreach($request->selected_list as $key => $record)
        {
            $studentObject  = App\Student::where('user_id','=',$key)->first();
            $promotionObject                       = new App\StudentPromotion();
            $promotionObject->user_id              = $key;
            $promotionObject->student_id           = $studentObject->id;
            $promotionObject->type                 = $record;
            $promotionObject->from_academic_id       = $academic_id;
            $promotionObject->from_course_parent_id  = $course_parent_id;
            $promotionObject->from_course_id         = $course_id; 
            $promotionObject->from_year            = $from_year;
            $promotionObject->from_semister        = $from_semister;


            $promotionObject->to_academic_id       = $to_academic_id;
            $promotionObject->to_course_parent_id  = $course_parent_id;
            $promotionObject->to_course_id         = $to_course_id;
            $promotionObject->to_year              = $to_year;
            $promotionObject->to_semister          = $to_semister;
            //Check if user got promoted or detained
            //If promoted, the toyear and tosemister should be 
            //current year and semister
            if($record=='detained')
            {
                 $promotionObject->to_academic_id  = $academic_id;
                 $promotionObject->to_course_id    = $course_id;
                 $promotionObject->to_year         = $from_year;
                 $promotionObject->to_semister     = $from_semister;
            }
           
            $promotionObject->remarks             = $remarks[$key];
            $promotionObject->description         = '';
            $promotionObject->record_updated_by   = $record_updated_by;
           
            $promotionObject->save();
            $studentObject->academic_id           = $to_academic_id;
            $studentObject->course_parent_id      = $course_parent_id;
            $studentObject->course_id             = $to_course_id;
            
            $studentObject->current_year          = $to_year;
            $studentObject->current_semister      = $to_semister;

            if($record=='detained')
            {
                $studentObject->academic_id           = $academic_id;
                $studentObject->course_parent_id      = $course_parent_id;
                $studentObject->course_id             = $course_id;
                $studentObject->current_year          = $from_year;
                $studentObject->current_semister      = $from_semister;
            }
            
            $studentObject->save();
        }

         flash('success','record_added_successfully', 'success');
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
          flash('oops...!','improper_selection', 'error');
       }
     }
  }
      else {

          DB::beginTransaction();
      try{
        $academic_id        = $request->academic_id;
        $course_parent_id   = $request->course_parent_id;
        $course_id          = $request->course_id;
        $from_year          = 1;
        $from_semister      = 0;
        if($request->has('current_year'))
           $from_year       = $request->current_year;

         if($request->has('current_semister'))
           $from_semister   = $request->current_semister;
        $to_year            = -1;
        $to_semister        = -1;
        $remarks            = $request->remarks;
        $record_updated_by  = Auth::user()->id;

        foreach($request->selected_list as $key => $record)
        {
            $studentObject                           = App\Student::where('user_id','=',$key)->first();
            
            $promotionObject                         = new App\StudentPromotion();
            $promotionObject->user_id                = $key;
            $promotionObject->student_id             = $studentObject->id;
            $promotionObject->type                   = 'completed';
            
            $promotionObject->from_academic_id       = $academic_id;
            $promotionObject->from_course_parent_id  = $course_parent_id;
            $promotionObject->from_course_id         = $course_id; 
            $promotionObject->from_year              = $from_year;
            $promotionObject->from_semister          = $from_semister;

            $promotionObject->to_academic_id         = $academic_id;
            $promotionObject->to_course_parent_id    = $course_parent_id;
            $promotionObject->to_course_id           = $course_id; 
            $promotionObject->to_year                = $from_year;
            $promotionObject->to_semister            = $from_semister;
            //Check if user got promoted or detained
            //If promoted, the toyear and tosemister should be 
            //current year and semister
            if($record=='detained')
            { 
                $promotionObject->type                = 'detained';
               }
           
            $promotionObject->remarks             = $remarks[$key];
            $promotionObject->description         = '';
            $promotionObject->record_updated_by   = $record_updated_by;
            $promotionObject->save();

            $studentObject->academic_id           = $academic_id;
            $studentObject->course_parent_id      = $course_parent_id;
            $studentObject->course_id             = $course_id;
            $studentObject->current_year          = '-1';

            $studentObject->current_semister      = '-1';

            //Check if user got promoted or detained
            //If promoted, the toyear and tosemister should be 
            //current year and semister
            if($record=='detained')
            {   
               
                $studentObject->academic_id           = $academic_id;
                $studentObject->course_parent_id      = $course_parent_id;
                $studentObject->course_id             = $course_id;
                $studentObject->current_year          = $from_year;
                $studentObject->current_semister      = $from_semister;
               
            }
            
            $studentObject->save();
        }

         flash('success','records_updated_successfully', 'success');
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
          flash('oops...!','improper_selection', 'error');
       }
     }

      }
       return redirect(URL_STUDENT_TRANSFERS);
       
    }

    public function transferSingleStudent(Request $request)
    {
        DB::beginTransaction();
      try{

        $user_id        = $request->user_id;
        $studentObject  = App\Student::where('user_id','=',$user_id)->first();
        $academic_id    = $request->academic_id;
        $course_id      = $request->course_id;
        $course_parent_id = $studentObject->course_parent_id;
        $from_year      =  $request->current_year;
        $from_semister  =  $request->current_semister;
        $to_year        = -1;
        $to_semister    = -1;
        $remarks        = '';
        $record_updated_by = Auth::user()->id;


        if($request->has('from_year'))
            $from_year = $request->from_year;
        if($request->has('from_semister'))
            $from_semister = $request->from_semister;
        
        if($request->has('remarks'))
            $remarks = $request->remarks;


            $promotionObject                       = new App\StudentPromotion();
            $promotionObject->user_id              = $user_id;
            $promotionObject->student_id           = $studentObject->id;
            $promotionObject->from_academic_id     = $academic_id;
            $promotionObject->from_course_parent_id  = $course_parent_id;
            $promotionObject->from_course_id       = $course_id;
            $promotionObject->to_academic_id       = $academic_id;
            $promotionObject->to_course_parent_id  = $course_parent_id;
            $promotionObject->to_course_id         = $course_id;
            $promotionObject->type                 = 'completed';
            $promotionObject->from_year            = $from_year;
            $promotionObject->from_semister        = $from_semister;
            $promotionObject->to_year              = $to_year;
            $promotionObject->to_semister          = $to_semister;
            $promotionObject->remarks              = $remarks;
            $promotionObject->description          = '';
            $promotionObject->record_updated_by    = $record_updated_by;

            $promotionObject->save();
            $studentObject->academic_id           = $academic_id;
            $studentObject->current_year          = '-1';

            $studentObject->current_semister      = '-1';

            $studentObject->save();
         flash('success','records_updated_successfully', 'success');
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
          flash('oops...!','internal_error', 'error');
       }
     }

     
       return redirect(URL_STUDENT_TRANSFERS);
       
    }
}
