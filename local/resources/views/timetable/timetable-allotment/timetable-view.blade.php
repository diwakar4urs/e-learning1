@extends($layout)

@section('header_scripts')
<link href="{{CSS}}animate.css" rel="stylesheet"> 

@stop
@section('custom_div')
<div ng-controller="TimetableController" ng-init="ingAngData()">
@stop
@section('content')
<div id="page-wrapper" >
    <div class="container-fluid">
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
                        <a href="{{URL_TIMETABLE_DASHBOARD}}">
                            {{getPhrase('timetable_dashboard')}}
                        </a>
                    </li>
                    <li>
                        
                            {{$title}}
                        
                    </li>
                </ol>
            </div>
        </div>
    
        
        {!! Form::open(array('url' => URL_UPDATE_TIMETABLE, 'method' => 'POST', 'name'=>'idCards ', 'novalidate'=>'')) !!}
        <div class="panel panel-custom  academia_visiblelist_fix" data-spy="affix" 
        data-offset-top="0"  >
            <div class="panel-heading" >
                <h1>
                    {{getPhrase('select_details')}}
                 
                 <div class="pull-right">
                <button class="btn btn-primary" type="submit" ng-show = "showCalender">{{getPhrase('update')}}</button> &nbsp;

                 <a href="javascript:void(0);" class="btn btn-danger" type="button"  data-toggle="modal" data-target="#author_profile" ng-show = "showCalender" >{{getPhrase('print')}}</a>
                </div>
                </h1>
            </div>
            
            <div class="panel-body instruction vertical-scroll" id="window_auto_height" >
           <div class="pull-right">
            <a  href="{{URL_TIMETABLE_VIEW}}" 
                class="btn btn-link btn-zindextop"
                ng-click="toggleCalender()"
                ng-show = "showCalender"
                > {{getPhrase('back')}} </a>
                </div>
                
               
    @include('timetable.timetable-allotment.selection-view')

    @include('timetable.timetable-allotment.calender-view')
 
<br>
  </div>
</div>
   {!! Form::close() !!}                         
                       
                    
                </hr>
 {!! Form::open(array('url' => URL_TIMETABLE_PRINT, 'method' => 'POST', 'name'=>'idCards ', 'novalidate'=>'','target'=>'_blank')) !!}
<div class="modal fade" id="author_profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{getPhrase('print_timetable')}}</h4>
                </div>
                <div class="modal-body">
                {{ Form::label('notes', getphrase('enter_notes')) }} ({{getPhrase('this_will_be_displayed_bottom_of_the_timetable')}}) 
                    <textarea class="form-control ckeditor" name="notes" id="notes" ></textarea>
                    <input type="hidden" name="academic_id" value="@{{selected_academic_id}}">
                    <input type="hidden" name="course_id" value="@{{selected_course_id}}">
                    <input type="hidden" name="year" value="@{{selected_year}}">
                    <input type="hidden" name="semister" value="@{{selected_semister}}">
                    
                </div>
                <div class="modal-footer text-center">
                    <button  type="submit" class="btn btn-success button btn-lg">Give a Print</button>
                </div>
            </div>
        </div>
    </div>

   {!! Form::close() !!}  


            </div>
        </div>
    </div>
</div>

@stop
 
@section('footer_scripts')

  
    @include('timetable.timetable-allotment.scripts.js-scripts')
    @include('common.alertify')
    @include('common.editor')
    @include('common.affix-window-size-script')
@stop

@section('custom_div_end')
</div>
@stop