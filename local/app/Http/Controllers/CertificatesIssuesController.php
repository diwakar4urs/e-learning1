<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use \App;
use App\CertificateIssue;
use Auth;
use App\Student;
use App\Category;
use App\StudentPromotion;
use App\Course;
use DB;
use Exception; 
class CertificatesIssuesController extends Controller
{
 
    /**
     * This method will fetch the list of issue records for user
     * @param  Request $request [description]
     * @return boolean          [description]
     */
    public function isIssued(Request $request)
    {
    	$user_id 			      = $request->user_id;
    	$current_year 		  = $request->current_year;
    	$current_semister 	= $request->current_semister;	
      $certificate_type   = $request->certificate_type;

        
        $library_issue = new App\LibraryIssue();
        $books_need_to_return  = $library_issue->isUserHavingBookings($user_id);
        $records = [];
        if($books_need_to_return<=0 || $certificate_type=='bonafide')
        {
            $records = App\CertificateIssue::where('user_id', '=', $user_id)
        
                    ->where('certificate_type', '=', $certificate_type)
                    ->get();
        }
        $final_records['certificate_type']     = $request->certificate_type;
        $final_records['records']              = $records;
        $final_records['books_need_to_return'] = $books_need_to_return;

    	return json_encode($final_records);
    }

    /**
     * This method will issue the certificate as printable copy
     * Before showing the printable copy, this will update the database
     * as issuing this certificate
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function issueCertificate(Request $request)
    {

       $user_id          = $request->user_id;
       $student_userid   = $request->user_id;
       $country_name     = 'NA';

       $student_data     = App\Student::where('user_id','=',$student_userid)->get()->first();

       if(isset($student_data->nationality)){
            $country          = DB::table('countries')
                                    ->where( 'country_code','=',$student_data->nationality)
                                    ->first();
          if($country)
            $country_name = $country->country_name;

        }

       $categoryname     = App\Category::where('id','=',$student_data->category_id)->get()->first();

        $records         = App\User::join('students', 'users.id' ,'=', 'students.user_id')  
        ->join('academics','academics.id','=','students.academic_id') 
        ->join('courses','courses.id','=','students.course_id')
        ->where('users.id',$user_id)
        ->select(['students.id as student_id','students.user_id as id','users.name', 'roll_no','admission_no', 'course_title','blood_group','mobile','home_phone','image','academic_year_title', 'current_year', 'current_semister','course_dueration','fathers_name', 'gender','address_lane1', 'city','state','is_having_semister'])
        ->first();

    if($request->certificate_type=='tc')
    {   
        $joined_classdetails = App\StudentPromotion::where('user_id','=',$student_data->user_id)
       ->where('type','=','admission')
       ->get()->first();


        $joined_class_academicname = App\Academic::where('id','=',$joined_classdetails->from_academic_id)->select('academic_year_title')->first();
        

        $joined_class   = App\Course::where('id','=',$joined_classdetails->from_course_id)->get()->first();


        $last_study_classdetails = App\StudentPromotion::where('user_id','=',$student_data->user_id)
      ->where('type','=','completed')
       ->get()->first();

       $last_study_academicname = null;
       $last_class_study = null;
       if($last_study_classdetails) {
        $last_study_academicname = App\Academic::where('id','=',$last_study_classdetails->to_academic_id)->select('academic_year_title')->first();

        $last_class_study = App\Course::where('id','=',$last_study_classdetails->to_course_id)->get()->first();
      }

        $data['categoryname']              = $categoryname;

        $data['country_name']              = $country_name;
        
        $data['joined_class']              = $joined_class;

        $data['joined_classdetails']       = $joined_classdetails;

        $data['joined_class_academicname'] = $joined_class_academicname;

        $data['last_class_study']          = $last_class_study;

        $data['last_study_classdetails']   = $last_study_classdetails;

        $data['last_study_academicname']   = $last_study_academicname;
        
        $this->updateIssue($request, $records);

        $tc_no = CertificateIssue::where('student_id','=',$student_data->id)->get()->first();
        $data['tc_no']          = $tc_no;
        $data['student_data']   = $student_data;


        return view('certificates.html-templates.transfer-certificates.tc-template',$data);
    }

        $data['title']        = getPhrase('id_card_generation');
        $data['record']       = $records;
        $data['name']         = $records->name;
        $data['fathers_name'] = $records->fathers_name;
        
        $data['gender_title'] = ($records->gender=='male') ? ' He ' : ' She ';
        $data['child_title']  = ($records->gender=='male') ? ' son of ' : ' daughter of ';
        
        $data['address']      = $records->address_lane1;
        $course_title         = $records->course_title;

        if($records->course_dueration>1)
        {
            $course_title    .= getPhrase('year').' '.$records->current_year;

            if($records->is_having_semister > 0)

            $course_title    .= getPhrase('semester').' '.$records->current_semister;
        }

        $data['course_title'] = $course_title;
       $reference_no =  $this->updateIssue($request, $records);

        // $temp = $this->getContentTemplate($data);

          $content = \Blade::compileString($this->getContentTemplate($reference_no));

        $result = $this->render($content, $data);
         
         return $result;

    }

    /**
     * This method will update the record submitted as a parameter
     * @param  Request $request     [description]
     * @param  [type]  $user_record [description]
     * @return [type]               [description]
     */
    public function updateIssue(Request $request, $user_record)
    {    

    	$issueObject 					          = new App\CertificateIssue();
    	$issueObject->certificate_type 	= $request->certificate_type;
      $issueObject->reason 			      = $request->purpose;
      $issueObject->user_id           = $user_record->id;
      $issueObject->student_id        = $user_record->student_id;
      $issueObject->roll_no           = $user_record->roll_no;
      $issueObject->academic_year_title    = $user_record->academic_year_title;
      $issueObject->course_title      = $user_record->course_title;

        if($user_record->course_dueration>1){
    	$issueObject->current_year 		  = $user_record->current_year;
    	$issueObject->current_semister 	= $user_record->current_semister;
        }
      $issueObject->current_year      = 1;
      $issueObject->current_semister  = 0;

    	$issueObject->reference_no 		  = $this->prepareReferenceNo($user_record);
    	$issueObject->issued_by 		    = Auth::user()->id;
    	$issueObject->save();

        return $issueObject->reference_no;
    }

    /**
     * This method will create the reference number for the certificate
     * It is prepared by USERID-YEAR-MONTH-DAY-HOUR format
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function prepareReferenceNo($user)
    {
    	return $user->id.'-'.date('ymdH');
    }

     /**
     * This method is going print a TC certificate according to enter the details in Tc From
     and also save the data into database
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function tcDetails(Request $request)
    {   
        $data['serial_no']         = $request->serial_no;
        $data['admission_no']      = $request->admission_no;
        $data['student_name']      = $request->student_name;
        $data['fathername']        = $request->fathername;
        $data['mothername']        = $request->mothername;
        $data['nation']            = $request->nation;
        $data['caste']             = $request->caste;
        $data['joining_date']      = $request->joining_date;
        $data['joining_class']     = $request->joining_class;
        $data['date_of_birth']     = $request->date_of_birth;
        $data['last_class_study']  = $request->last_class_study;
        $data['exam_details']      = $request->exam_details;
        $data['exam_status']       = $request->exam_status;
        $data['promotion_class']   = $request->promotion_class;
        $data['working_days']      = $request->working_days;
        $data['present_days']      = $request->present_days;
        $data['ncc']               = $request->ncc;
        $data['activities']        = $request->activities;
        $data['conduct']           = $request->conduct;
        $data['apply_date']        = $request->apply_date;
        $data['reason']            = $request->reason;
        $data['remarks']           = $request->remarks;

        $tc_data                   = json_encode($data);

        $issueObject                    = App\CertificateIssue::where('id','=',$request->tc_id)->first();
        $issueObject->certificate_data  = $tc_data;
        $issueObject->save();

        $data['tcprint_details']   = $request;

        $view     = \View::make('certificates.html-templates.transfer-certificates.tc-template-print',$data);
        $contents = $view->render();

        return $contents;
        
      }

        /**
     * Returns the template html code by forming header, body and footer
     * @param  [type] $template [description]
     * @return [type]           [description]
     */
    public function getContentTemplate($reference_no)
    {
        $content = getSetting('content', 'bonafide_content');
        
        $view = \View::make('certificates.html-templates.bonafide.bonafide-certificate', [
                                                'content' => $content, 
                                                'reference_no' =>$reference_no
                                                ]);

        return $view->render();
    }

        /**
     * Prepares the view from string passed along with data
     * @param  [type] $__php  [description]
     * @param  [type] $__data [description]
     * @return [type]         [description]
     */
    public function render($__php, $__data)
    {
        $obLevel = ob_get_level();
        ob_start();
        extract($__data, EXTR_SKIP);
        try {
            eval('?' . '>' . $__php);
        } catch (Exception $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw $e;
        } catch (Throwable $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw new FatalThrowableError($e);
        }
        return ob_get_clean();
    }
}
