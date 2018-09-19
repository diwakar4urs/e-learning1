<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use \App;
use App\QuizResult;
class QuizResultsController extends Controller
{
    // 
    
    public function index()
    {
    	if(!checkRole(getUserGrade(2)))
        {
          prepareBlockUserMessage();
          return back();
        }
      
        $data['records']      = FALSE;
        $data['active_class'] = 'academic_operations';
        $data['heading']      = getPhrase('offline_marks');
        $data['title']        = getPhrase('import_marks');
        $data['layout']        = getLayout();
        return view('mastersettings.subjects.import.import', $data);	
    }

 
}
