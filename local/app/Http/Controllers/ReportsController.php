<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App;
use App\Http\Requests;
use App\User;
use App\GeneralSettings as Settings;
use App\QuizResult;
use App\Quiz;
use App\QuestionBank;
use Image;
use ImageSettings;
use Yajra\Datatables\Datatables;
use DB;
use Illuminate\Support\Facades\Hash;
use Input;

class ReportsController extends Controller
{
    public function __construct()
    {
         $currentUser = \Auth::user();
     
         $this->middleware('auth');
    
    }

    /**
     * This method shows the results of the quiz
     *
     * @param      <type>  $exam_slug    The exam slug
     * @param      <type>  $result_slug  The result slug
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function viewExamAnswers($exam_slug, $result_slug)
    {
         // dd($result_slug);
    	$exam_record = Quiz::getRecordWithSlug($exam_slug);
    	if($isValid = $this->isValidRecord($exam_record))
        	return redirect($isValid); 

         $result_record = QuizResult::getRecordWithSlug($result_slug);
         $user_details   = App\User::where('id','=',$result_record->user_id)->get()->first();

        if($isValid = $this->isValidRecord($result_record))
        	return redirect($isValid); 


       
        $prepared_records        = (object) $exam_record
                                    ->prepareQuestions($exam_record->getQuestions());
        $data['questions']       = $prepared_records->questions;
        $data['subjects']        = $prepared_records->subjects;
                                    
        $data['academic_years']        = addSelectToList(\App\Academic::pluck('academic_year_title', 'id'));
        $data['exam_record']        = $exam_record;
        $data['result_record']      = $result_record;
        $data['user_details']        = $user_details;
        $data['active_class']       = 'analysis';
        $data['title']              = $exam_record->title.' '.getPhrase('answers');
   
        $data['layout']             = getLayout();
    	return view('student.exams.results.answers', $data);
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
    	return URL_STUDENT_EXAM_CATEGORIES;
    }


   /**
     * This method returns a view with academic details of the the slug user
     *
     * @param      <type>  $slug   The slug
     */
    public function viewAcademicResultsOfStudent($slug)
    {
      $user_record                = User::where('slug','=',$slug)->first();
      $data['active_class']       = 'analysis';
      $data['title']              = getPhrase('overall_subject_wise_analysis');
      $data['user']               = $user_record;
      $data['academic_years']     = addSelectToList(\App\Academic::pluck('academic_year_title', 'id'));
      $userid                     = $user_record->id;
      $data['layout']             = getLayout();
      $data['userrecord']          = $user_record;
      

      return view('student.reports.selection-view', $data);  
    }

    /**
     * This method will return the list of available categories
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     <type>                    The exam categories.
     */
    public function getExamCategories(Request $request)
    {
        $academic_id        = $request->academic_id;
        $course_parent_id   = $request->course_parent_id;
        $course_id          = $request->course_id;
        $year               = $request->year;
        $semister               = $request->semister;
        $user_id               = $request->user_id;
       
        $categories = APP\QuizResult::join('quizzes', 'quizzes.id', '=', 'quizresults.quiz_id')
        ->join('quizcategories', 'quizzes.category_id','=','quizcategories.id')
        ->where('quizresults.year', '=',$year)
        ->where('quizresults.semister', '=',$semister)
        ->where('quizresults.user_id', '=',$user_id)
        ->where('quizresults.academic_id', '=',$academic_id)
        ->where('quizresults.course_id', '=',$course_id)
        ->where('quizzes.applicable_to_specific', '=',1)

        ->select(['category', 'quizcategories.id as id', 'quizcategories.description as description'])
        ->groupBy('quizcategories.id')
        ->get();
       
        return json_encode($categories);
    }


    public function getExamsByCategory(Request $request)
    {
        $academic_id        = $request->academic_id;
        $course_parent_id   = $request->course_parent_id;
        $course_id          = $request->course_id;
        $year               = $request->year;
        $semister           = $request->semister;
        $category_id        = $request->category_id;
        $user_id            = $request->user_id;

        $quizzes = APP\QuizResult::join('quizzes', 'quizzes.id', '=', 'quizresults.quiz_id')
        ->join('quizcategories', 'quizzes.category_id','=','quizcategories.id')
        ->where('quizresults.year', '=',$year)
        ->where('quizresults.semister', '=',$semister)
        ->where('quizresults.academic_id', '=',$academic_id)
        ->where('quizresults.course_id', '=',$course_id)
        ->where('quizzes.category_id', '=',$category_id)
        ->where('quizresults.user_id', '=', $user_id)
        ->select(['category', 'quizcategories.id as id', 
                    'quizcategories.description as description', 
                    'quizzes.id as quiz_id', 'quizzes.title',
                    'quizresults.marks_obtained','quizresults.total_marks',
                    'quizresults.percentage','quizresults.exam_status',
                    'quizresults.slug as result_slug','quizresults.updated_at',
                    'quizzes.slug as quiz_slug'
                    ])
        ->get();
        
        return json_encode($quizzes);
    }



}
