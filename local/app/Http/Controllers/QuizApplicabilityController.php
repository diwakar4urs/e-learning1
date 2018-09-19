<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App;
use App\Http\Requests;
use App\QuizApplicability;
class QuizApplicabilityController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    
}
