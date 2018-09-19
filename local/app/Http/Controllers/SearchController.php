<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
class SearchController extends Controller
{
    public function index()
    {
    	$data['active_class']         = 'users';
      $data['title']                = getPhrase('search_student');
      $data['user']                 = Auth::user();
        
      $data['right_bar']            = TRUE;
   
      $data['right_bar_path']       = 'search.student.right-bar';
      $data['right_bar_data']       = array('chart_data' =>'' );
        
      $data['layout']               = getLayout();

        return view('search.student.search-view', $data); 
    }
}
