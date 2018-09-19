@extends($layout)

@section('header_scripts')

<link href="{{CSS}}bootstrap-datepicker.css" rel="stylesheet">
@stop

@section('content')
<div id="page-wrapper" ng-controller="academicAttendance">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li>
                        <a href="{{PREFIX}}">
                            <i class="mdi mdi-home">
                            </i>
                        </a>
                    </li>
                     <li>
                        <a href="{{URL_ACADEMICOPERATIONS_DASHBOARD}}">
                            {{getPhrase('academic_operations')}}
                        </a>
                    </li>
                    <li>
                        <a href="{{URL_OFFLINE_EXAMS}}">
                            {{getPhrase('offline_exmas')}}
                        </a>
                    </li>
                    <li>
                        {{getPhrase('selection_details')}} 
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        <div class="panel panel-custom">
            <div class="panel-heading">
                <h1>
                    {{$examtitle}}
                    
                </h1>
            </div>
            <div class="panel-body instruction">
                <div class="row">
                
                     {!! Form::open(array('url' => URL_OFFLINE_EXAMS_ADD, 'method' => 'POST')) !!}
                     
                   
                  <div class ="col-md-6">

                 <fieldset class="form-group col-md-12">
                        {{ Form::label('select_subject', getphrase('select_course')) }}
                        
                        <span class="text-red">*</span>

                        {{Form::select('quiz_applicability_id',$quizzes,  null, 
                        [   'class'     => 'form-control',
                            
                            'id'        =>'select_academic_year'
                           
                        ])}}
                        </fieldset>
                        </div>
                </div>
                
                       <div class="text-center">
                                    <button type="submit" class="btn button btn-lg btn-success">
                                        {{getPhrase('get_details')}}
                                    </button>
                                </div>
                            
                        
                        {!! Form::close() !!}
                    
                </hr>
            </div>
        </div>
    </div>
</div>
@stop
 
 

@section('footer_scripts')
<script src="{{JS}}datepicker.min.js"></script>
 <script src="{{JS}}bootstrap-toggle.min.js"></script>   
 <script>
      $('.input-daterange').datepicker({
        autoclose: true,
        startDate: "0d",
         format: '{{getDateFormat()}}',
     });
 </script>
    
@stop