<?php
namespace App\Http\Controllers;
use \App;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Quiz;
use App\Subject;
use App\QuestionBank;
use App\QuizCategory;
use Yajra\Datatables\Datatables;
use DB;
use Auth;
use Exception;

class QuizController extends Controller
{
         
    public function __construct()
    {
      $this->middleware('auth');
    }

    protected  $examSettings;

    public function setExamSettings()
    {
        $this->examSettings = getExamSettings();
    }

    public function getExamSettings()
    {
        return $this->examSettings;
    }
     /**
      * This menthod will dispaly the quizzes dashboard
      * @return [type] [description]
      */
       public function quizdashboard()
    {

      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
      
      $data['active_class']       = 'exams';
      $data['title']              = getPhrase('exams_dashboard');
      $data['layout']             = getLayout();
      $data['module_helper']      = getModuleHelper('exams-dashboard');
      return view('exams.dashboard', $data);  
       
    }
     /**
     * Course listing method
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

        $data['active_class']       = 'exams';
        $data['title']              = getPhrase('quizzes');
        $data['module_helper']      = getModuleHelper('quiz-list');
      return view('exams.quiz.list', $data);
    }

    /**
     * This method returns the datatables data to view
     * @return [type] [description]
     */
    public function getDatatable($slug = '')
    {

      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

        $records = array();
         
        if($slug=='')
        {
          $records = Quiz::join('quizcategories', 'quizzes.category_id', '=', 'quizcategories.id')
            ->select(['type','title', 'dueration', 'quizcategories.category', 'is_paid', 'total_marks','tags','quizzes.slug','quizzes.id as quiz_id' ])
         

          ->orderBy('quizzes.updated_at', 'desc');
             

        }
        else {
            $category = QuizCategory::getRecordWithSlug($slug);
            $records = Quiz::join('quizcategories', 'quizzes.category_id', '=', 'quizcategories.id')
            ->select(['type','title', 'dueration', 'quizcategories.category', 'is_paid', 'total_marks','tags','quizzes.slug', 'quizzes.id as quiz_id' ])
            ->where('quizzes.category_id', '=', $category->id)
            ->orderBy('quizcategories.updated_at', 'desc');
        }


        return Datatables::of($records)
        ->addColumn('action', function ($records) {
         
          $link_data = '<div class="dropdown more">
                        <a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                           <li><a href="'.URL_QUIZ_UPDATE_QUESTIONS.$records->slug.'"><i class="fa fa-spinner" aria-hidden="true"></i>'.getPhrase("update_questions").'</a></li>
                            <li><a href="'.URL_QUIZ_EDIT.'/'.$records->slug.'"><i class="fa fa-pencil"></i>'.getPhrase("edit").'</a></li>';
                            
                           $temp = '';
                           if(checkRole(getUserGrade(1))) {
                    $temp .= ' <li><a href="javascript:void(0);" onclick="deleteRecord(\''.$records->slug.'\');"><i class="fa fa-trash"></i>'. getPhrase("delete").'</a></li>';
                      }
                    
                    $temp .='</ul></div>';


                    $link_data .=$temp;
            return $link_data;
            })
        ->editColumn('type',function($records){
          return ucfirst($records->type);
        })
        ->editColumn('is_paid', function($records)
        {
            return ($records->is_paid) ? '<span class="label label-primary">'.getPhrase('paid') .'</span>' : '<span class="label label-success">'.getPhrase('free').'</span>';
        })
        ->editColumn('title',function($records)
        {
          return '<a href="'.URL_QUIZ_UPDATE_QUESTIONS.$records->slug.'">'.$records->title.' ('.$records->quiz_id.')'.'</a>';
        })
        ->removeColumn('quiz_id')
        ->removeColumn('slug')
        ->removeColumn('tags')
         
        ->make();
    }

    /**
     * This method loads the create view
     * @return void
     */
    public function create()
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }
      $data['record']           = FALSE;
      $data['active_class']     = 'exams';
      $data['categories']       = array_pluck(QuizCategory::all(), 'category', 'id');
      $data['offline_categories'] = array_pluck(App\OfflineQuizCategories::
                                  where('status','=',1)->get(), 'title', 'id');
      $data['instructions']     = array_pluck(App\Instruction::all(), 'title', 'id');
      $data['subjects']         = array_pluck(App\Subject::all(), 'subject_title', 'id');
      $data['academic_years']   = addSelectToList(getAcademicYears());
      $data['items']            = json_encode(
                              array(
                                'academic_years'=>\App\Academic::select(['id', 'academic_year_title'])->get()
                                ));
      $data['title']            = getPhrase('create_quiz');
      $data['module_helper']    = getModuleHelper('create-quiz');
      return view('exams.quiz.add-edit', $data);
    }

    /**
     * This method loads the edit view based on unique slug provided by user
     * @param  [string] $slug [unique slug of the record]
     * @return [view with record]       
     */
    public function edit($slug)
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

      $record = Quiz::getRecordWithSlug($slug);
      if($isValid = $this->isValidRecord($record))
        return redirect($isValid);

      $data['record']           = $record;
      $data['active_class']     = 'exams';
      $data['settings']         = FALSE;
      $data['offline_categories'] = array_pluck(App\OfflineQuizCategories::
                                  where('status','=',1)->get(), 'title', 'id');

      $data['instructions']     = array_pluck(App\Instruction::all(), 'title', 'id');
      $data['categories']       = array_pluck(QuizCategory::all(), 'category', 'id');
      $data['title']            = getPhrase('edit_quiz');
      $data['subjects']         = array_pluck(App\Subject::all(), 'subject_title', 'id');
      $data['academic_years']   = addSelectToList(\App\Academic::pluck('academic_year_title', 'id'));
      
      $items = App\QuizApplicability::join('academics', 'academics.id', '=', 'quizapplicability.academic_id')
              ->join('courses', 'courses.id', '=', 'quizapplicability.course_id')
              ->where('quiz_id', '=', $record->id)
              ->select(['academic_id','academic_year_title', 'course_parent_id', 'course_id','course_title', 'year', 'semister','course_dueration'])
              ->get();

     
      $data['items']            = json_encode(
                              array(
                                'academic_years'=>\App\Academic::select(['id', 'academic_year_title'])->get(),
                                'available_items' => $items 
                                )
                              );
        $data['module_helper']      = getModuleHelper('create-quiz');

      return view('exams.quiz.add-edit', $data);
    }

    /**
     * Update record based on slug and reuqest
     * @param  Request $request [Request Object]
     * @param  [type]  $slug    [Unique Slug]
     * @return void
     */
    public function update(Request $request, $slug)
    {
      
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

      $record = Quiz::getRecordWithSlug($slug);
     $rules = [
         'title'               => 'bail|required|max:60' ,
         'dueration'           => 'bail|required|integer' ,
         ];
         
          $type                 = $request->type;

          $instructions_page_id = 0;
          $pass_percentage      = 0;
          $record->is_paid      = 0;
          $record->negative_mark= 0;
          $record->type         = $request->type;
          $record->instructions_page_id = App\Instruction::first()->id;

          if($type == 'online')
          {
              $rules['instructions_page_id']        = 'bail|required|integer' ;
              $rules['category_id']                 = 'bail|required|integer' ;
              $rules['pass_percentage']             = 'bail|required|numeric|max:100|min:1' ;
              $instructions_page_id = $request->instructions_page_id;
              $pass_percentage      = $request->pass_percentage;
              $record->is_paid      = $request->is_paid;
              $record->type         = $request->type;
              $record->having_negative_mark = 1;
              $record->negative_mark        = $request->negative_mark;
              $record->instructions_page_id = $request->instructions_page_id;


          }
           else {
            $record->offline_quiz_category_id = $request->offline_quiz_category_id;            
          }

         /**
        * Check if the title of the record is changed, 
        * if changed update the slug value based on the new title
        */
            $name = $request->title;
        if($name != $record->title)
            $record->slug = $record->makeSlug($name,TRUE);
      
       //Validate the overall request
       $this->validate($request, $rules);
        DB::beginTransaction();

      try
      {
        $name                    = $request->title;
        $record->title           = $name;
        $record->category_id     = $request->category_id;
        $record->dueration       = $request->dueration;
        $record->total_marks     = $request->total_marks;
        $record->pass_percentage = $request->pass_percentage;
        $record->tags            = '';
        $record->cost            = 0;
        $record->validity        = -1;
        if($record->is_paid) {
          $record->cost          = $request->cost;
          $record->validity      = $request->validity;
        }

        $record->publish_results_immediately            
                                 = $request->publish_results_immediately;
        $record->publish_results_immediately      
                      = 1;
        $record->start_date      = date( "Y-m-d H:i" , strtotime($request->start_date));

        $record->end_date         = date( "Y-m-d H:i" , strtotime($request->end_date));
        if(!$request->negative_mark)
          $record->having_negative_mark = 0;
        
        $record->description        = $request->description;
        $record->record_updated_by  = Auth::user()->id;
         $record->applicable_to_specific = $request->applicable_to_specific;
        $record->subject_id = $request->subject_id;
        $record->save();
        if($request->applicable_to_specific){
          $quizApplicability = new App\QuizApplicability();
           $quizApplicability->updateApplicability($record->id, $request->selected_list);
        }
       
        flash('success','record_updated_successfully', 'success');
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
          flash('oops...!','improper_data_in_the_question', 'error');
       }
     }
     if($type=='offline'){
      return redirect(URL_OFFLINE_EXAMS);
     }
     else{
      return redirect(URL_QUIZZES);
       }
    }

    /**
     * This method adds record to DB
     * @param  Request $request [Request Object]
     * @return void
     */
    public function store(Request $request)
    {
      if(!checkRole(getUserGrade(2)))
      {
        prepareBlockUserMessage();
        return back();
      }

      $rules = [
         'title'               => 'bail|required|max:60' ,
        
         'dueration'           => 'bail|required|integer' ,
         ];
          $record = new Quiz();
          $type                 = $request->type;

          $instructions_page_id = 0;
          $pass_percentage      = 0;
          $record->is_paid      = 0;
          $record->negative_mark= 0;
          $record->type         = $request->type;
          $record->instructions_page_id = App\Instruction::first()->id;
          
          if($type == 'online')
          {

              $rules['category_id']                 = 'bail|required|integer' ;
              $rules['instructions_page_id']        = 'bail|required|integer' ;
              $rules['pass_percentage']             = 'bail|required|integer|max:100|min:1' ;
              $instructions_page_id = $request->instructions_page_id;
              $pass_percentage      = $request->pass_percentage;
              $record->is_paid      = $request->is_paid;
              $record->type         = $request->type;
              $record->having_negative_mark = 1;
              $record->negative_mark        = $request->negative_mark;
              $record->instructions_page_id = $request->instructions_page_id;


          }
          else {
            
            $rules['offline_quiz_category_id']        = 'bail|required|integer' ;
            $record->offline_quiz_category_id = $request->offline_quiz_category_id;            
          }



        $this->validate($request, $rules);
        
        DB::beginTransaction();

      try
      {

        $name                    = $request->title;
        $record->title           = $name;
        $record->slug            = $record->makeSlug($name,TRUE);
        
        $record->category_id     = $request->category_id;
        $record->dueration       = $request->dueration;
        $record->total_marks     = $request->total_marks;
        $record->pass_percentage = $request->pass_percentage;
        $record->tags            = '';
        
        $record->cost            = 0;
        $record->validity        = -1;
        if($record->is_paid) {
          $record->cost          = $request->cost;
          $record->validity      = $request->validity;
        }

        $record->publish_results_immediately            
                                 = $request->publish_results_immediately;
        $record->publish_results_immediately      
                      = 1;
        $record->start_date           =  date( "Y-m-d H:i:s" , strtotime($request->start_date));
        $record->end_date             =  date( "Y-m-d H:i:s" , strtotime($request->end_date));
        if(!$request->negative_mark)
          $record->having_negative_mark = 0;
        
        $record->description        = $request->description;
        $record->record_updated_by  = Auth::user()->id;
        $record->applicable_to_specific = $request->applicable_to_specific;
        $record->subject_id = $request->subject_id;
        $record->save();
        
        $quizApplicability = new App\QuizApplicability();
        if($record->applicable_to_specific)
          $quizApplicability->updateApplicability($record->id, $request->selected_list);

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
          flash('oops...!','improper_data_submitted', 'error');
       }
     }
     if($type=='offline'){
      return redirect(URL_OFFLINE_EXAMS);
     }
     else{
      return redirect(URL_QUIZZES);
       }
    }
 
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
      /**
       * Delete the questions associated with this quiz first
       * Delete the quiz
       * @var [type]
       */
        $record = Quiz::where('slug', $slug)->first();
        try{
        
        if(!env('DEMO_MODE')) {
          $record->delete();
        }
        $response['status'] = 1;
        $response['message'] = getPhrase('record_deleted_successfully');
         } catch (Exception $e) {
            $response['status'] = 0;
           if(getSetting('show_foreign_key_constraint','module'))
            $response['message'] =  $e->getMessage();
          else
            $response['message'] =  getPhrase('this_record_is_in_use_in_other_modules');
         }
        return json_encode($response);

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
      return URL_QUIZZES;
    }


    /**
     * Returns the list of subjects based on the requested subject
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getSubjectData(Request $request)
    {

      $subject_id = $request->subject_id;
      $subject = Subject::where('id','=',$subject_id)->first();
      $topics = $subject
            ->topics()
            ->where('parent_id', '=', '0')
            ->get(['topic_name', 'id']);
      $questions = $subject->questions()->get(['id', 'subject_id', 'topic_id', 'question_type', 'question', 
                                               'marks', 'difficulty_level', 'status']);
      return json_encode(array('topics'=>$topics, 'questions'=>$questions, 'subject'=>$subject));
    }
    
    /**
     * Updates the questions in a selected quiz
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function updateQuestions($slug)
    {
       if(!checkRole(getUserGrade(2)))
       {
            prepareBlockUserMessage();
            return back();
        }

      /**
       * Get the Quiz Id with the slug
       * Get the available questions from questionbank_quizzes table
       * Load view with this data
       */
    $record = Quiz::getRecordWithSlug($slug);     
      $data['record']           = $record;
      $data['active_class']       = 'exams';
        $data['right_bar']          = TRUE;
        $data['right_bar_path']     = 'exams.quiz.right-bar-update-questions';
        
        $data['settings']           = FALSE;
        $previous_questions = array();
        if($record->total_questions > 0)
        {
            $questions = DB::table('questionbank_quizzes')
                            ->where('quize_id', '=', $record->id)
                            ->get();
            foreach($questions as $question)
            {
                $temp = array();
                $temp['id'] = $question->subject_id.$question->questionbank_id;
                $temp['subject_id'] = $question->subject_id;
                $temp['question_id'] = $question->questionbank_id;
                $temp['marks'] = $question->marks;
                
                $question_details = QuestionBank::find($question->questionbank_id);
                $subject = $question_details->subject;
                
                $temp['topic_id'] = $question_details->topic_id;
                $temp['question'] = $question_details->question;
                $temp['question_type'] = $question_details->question_type;
                $temp['difficulty_level'] = $question_details->difficulty_level;
                $temp['subject_title'] = $subject->subject_title;
                array_push($previous_questions, $temp);
            }
            $settings['questions']   = $previous_questions;
            $settings['total_marks'] = $record->total_marks;
            $data['settings']        = json_encode($settings);
        }
        
        
      $data['subjects']         = array_pluck(App\Subject::all(), 
                      'subject_title', 'id');

      $data['title']              = getPhrase('update_questions_for').' '.$record->title;
      $data['module_helper']      = getModuleHelper('update-questions-in-quiz');
      return view('exams.quiz.update-questions', $data);

    }

    public function storeQuestions(Request $request, $slug)
    {
     
        if(!checkRole(getUserGrade(2)))
        {
            prepareBlockUserMessage();
            return back();
        }

        $quiz = Quiz::getRecordWithSlug($slug); 

        $quiz_id    = $quiz->id;
        $questions  = json_decode($request->saved_questions);
        $marks = 0;
        $questions_to_update = array();
        foreach ($questions as $question) {
            $temp = array();
            $temp['subject_id'] = $question->subject_id;
            $temp['questionbank_id'] = $question->question_id;
            $temp['quize_id'] = $quiz_id;
            $temp['marks'] = $question->marks;
            $marks += $question->marks;
            array_push($questions_to_update, $temp);
        }
        $total_questions = count($questions_to_update);
        //Clear all previous questions
        if(!env('DEMO_MODE')) {
         DB::table('questionbank_quizzes')->where('quize_id', '=', $quiz_id)->delete();
        }
        //Insert New Questions
        DB::table('questionbank_quizzes')->insert($questions_to_update);
        $quiz->total_questions = $total_questions;
        $quiz->total_marks = $marks;
        $quiz->save();
        flash('success','record_updated_successfully', 'success');
        return redirect(URL_QUIZZES);
    }

}
