@extends('layouts.admin.adminlayout')
@section('header_scripts')

@stop
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li>
                        <a href="{{url('/')}}">
                            <i class="mdi mdi-home">
                            </i>
                        </a>
                    </li>
                    <li>
                        <a href="/">
                            {{getPhrase('attendance')}}
                        </a>
                    </li>
                     
                </ol>
            </div>
        </div>
        <!-- /.row -->
        <div class="panel panel-custom">
            <div class="panel-heading">
                <h1>
                    Instruction
                    <span class="pull-right text-italic">
                        Please read the following instructions carefully
                    </span>
                </h1>
            </div>
            <div class="panel-body instruction">
                <div class="row">
                    <div class="col-md-12">
                        <h2>
                            {{getPhrase('exam_name')}}:
                            <a href="javascript:void(0);">
                                {{$title}}
                            </a>
                        </h2>
                        <h3>
                            General Instruction:
                        </h3>
                        <ol>
                            <li>
                                Total of   minutes duration will be given to attempt all the questions.
                            </li>
                            <li>
                                The clock has been set at the server and the countdown timer at the top right corner of your screen will display the time remaining for you to complete the exam. When the clock runs out the exam ends by default - you are not required to end or submit your exam.
                            </li>
                            <li>
                                The question palette at the right of screen shows one of the following statuses of each of the questions numbered:
                            </li>
                        </ol>
                        <ul class="guide">
                            <li>
                                <span class="answer">
                                    <i class="mdi mdi-check">
                                    </i>
                                </span>
                                You have answered the question.
                            </li>
                            <li>
                                <span class="notanswer">
                                    <i class="mdi mdi-close">
                                    </i>
                                </span>
                                You have not answered the question.
                            </li>
                            <li>
                                <span class="marked">
                                    <i class="mdi mdi-eye">
                                    </i>
                                </span>
                                You have answered the question but have marked the question for review.
                            </li>
                            <li>
                                <span class="notvisited">
                                    <i class="mdi mdi-eye-off">
                                    </i>
                                </span>
                                You have not visited the question yet.
                            </li>
                        </ul>
                    </div>
                </div>
                <hr>
                    <div class="form-group row">
                        {!! Form::open(array('url' => 'exams/student/start-exam/', 'method' => 'POST')) !!}
                        <div class="col-md-12">
                            <input checked="" id="free" name="option" required="true" type="checkbox">
                                <label for="free">
                                    <span class="fa-stack checkbox-button">
                                        <i class="mdi mdi-check active">
                                        </i>
                                    </span>
                                    The computer provided to me is in proper working condition. I have read and understood the instructions given above.
                                </label>
                                <div class="text-center">
                                    <button class="btn button btn-lg btn-primary">
                                        START Exam
                                    </button>
                                </div>
                            </input>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </hr>
            </div>
        </div>
    </div>
</div>
@endsection
 

@section('footer_scripts')
  
 

@stop
