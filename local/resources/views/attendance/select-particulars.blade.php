@extends($layout)
@section('header_scripts')
<link href="{{CSS}}plugins/datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">   

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
                    @if($role_name!='staff')
                    <li>
                        <a href="{{URL_ACADEMICOPERATIONS_DASHBOARD}}">
                            {{getPhrase('academic_operations')}}
                        </a>
                    </li>
                    @endif
                    <li>{{getphrase('particulars')}}</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        <div class="panel panel-custom">
            <div class="panel-heading">
                <h1>
                    {{getPhrase('select_details')}}
              
                </h1>
            </div>
            <div class="panel-body instruction">
              


                <div class="row">
                <div class="col-md-6">
                <h3>{{ getPhrase('general_instructions') }}</h3>
                        <ul class="guide">
                            <li>
                                <span class="answer">
                                    <i class="mdi mdi-check">
                                    </i>
                                </span>
                                {{getPhrase('present')}}
                            </li>
                            <li>
                                <span class="notanswer">
                                    <i class="mdi mdi-close">
                                    </i>
                                </span>
                                {{getPhrase('absent')}}
                            </li>
                            <li>
                                <span class="marked">
                                    <i class="mdi mdi-eye">
                                    </i>
                                </span>
                                {{getPhrase('leave')}}
                            </li>
                            
                        </ul>
                    </div>
                     {!! Form::open(array('url' => URL_STUDENT_ATTENDENCE_ADD.$userdata->slug, 'method' => 'POST')) !!}


                     @if($role_name!='staff')

                    <div class="col-md-6">

                    @include('common.year-selection-view')

                 </div>

                 @else

                 <div class ="col-md-6">

                 <fieldset class="form-group col-md-12">
                        {{ Form::label('select_subject', getphrase('select_subject')) }}
                        
                        <span class="text-red">*</span>

                        {{Form::select('course_subject_id',$subjects,  null, 
                        [   'class'     => 'form-control',
                            
                            'id'        =>'select_academic_year'
                           
                        ])}}
                        </fieldset>
                        
            

                    <?php 
                    $number_of_class=[];
                    $maximum_classes = 8;

                    for($class_number = 1; $class_number<=$maximum_classes; $class_number++)
                    $number_of_class[$class_number]=$class_number; ?>

            <fieldset  class="form-group col-md-12">
               {{ Form::label('class', getphrase('total_class')) }}
                     <span class="text-red">*</span>               
                {{Form::select('total_class',$number_of_class,  null, 
                                    ['class'=>'form-control'])}}
                    </fieldset>

                        <fieldset class="form-group col-md-12">
                                     
                        {{ Form::label('attendance_date', getphrase('attendance_date')) }}
                        <div class="input-group date" data-date="{{date('Y/m/d')}}" data-provide="datepicker" data-date-format="{{getDateFormat()}}">
                        {{ Form::text('attendance_date', $value = date('Y/m/d') , $attributes = array('class'=>'form-control', 'placeholder' => '2015/7/17', 'id'=>'dp')) }}
                            <div class="input-group-addon">
                                <span class="mdi mdi-calendar"></span>
                            </div>
                        </div>
                        </fieldset>
            
                </div>

                @endif

                <hr>
                       
                            
                                <div class="text-center">
                                    <button type="submit" class="btn button btn-lg btn-primary">
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
 
 <script src="{{JS}}moment.min.js"></script>

  <script src="{{JS}}plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
 <script>
    
     $(function () {
        $('#dp').datetimepicker({
               format: 'YYYY-MM-DD',
                maxDate: 'now'
            
            });
    });
 </script>
    @include('attendance.scripts.js-scripts')
    
@stop