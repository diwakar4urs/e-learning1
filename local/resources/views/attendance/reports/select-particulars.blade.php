@extends($layout)

@section('header_scripts')
 
<link href="{{CSS}}bootstrap-datepicker.css" rel="stylesheet">
<link href="{{CSS}}fullcalendar.min.css" rel="stylesheet">
    <link href='{{CSS}}fullcalendar.print.css' rel='stylesheet' media='print' />
@stop
@section('custom_div')
<div ng-controller="TabController">
@stop
@section('content')
<div id="page-wrapper" ng-controller="TabController">
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
                   @if(checkRole(getUserGrade(2)))
                       <li><a href="{{URL_USERS_DASHBOARD}}">{{ getPhrase('users_dashboard') }}</a> </li>
                       

                    <li><a href="{{URL_USERS."student"}}">{{ getPhrase('student_users') }}</a> </li>
                    @endif

                        @if(checkRole(getUserGrade(7)))
                   <li><a href="{{URL_PARENT_CHILDREN}}">{{ getPhrase('children') }}</a> </li>
                   @endif
                   <li><a href="{{URL_USER_DETAILS.$userrecord->slug}}">{{ $userrecord->name }} {{getPhrase('details') }}</a> </li> 
                     
                   <li>{{ getPhrase('attendance_details') }} </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        <?php 
                $loggedInUser     = Auth::user();
                $loggedInUserRole = getRoleData($loggedInUser->role_id);

        ?>
        <div class="panel panel-custom">
            <div class="panel-heading">
                <h1>
                    {{getPhrase('select_details')}}
                 
                </h1>
            </div>
            <div class="panel-body instruction">
                 @include('common.year-selection-view',array('user_slug'=>$user->slug, 'class'=>'custom-row-6'))
                <hr>
                       
  

    <div class="row">
        <div class="col-md-12">
            <div id='calendar' class="attendance-event-calender" ></div>
            <br>
            <a ng-show="total_classes>0" href="javascript:void(0);" data-toggle="modal" data-target="#attendance_summary" class="btn btn-success btn-sm pull-right" >{{getPhrase('view_summary')}}</a>

        </div>

    </div>
<div class="modal fade" id="attendance_summary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{getPhrase('attendance_summary')}}</h4>
                </div>
                <div class="modal-body">

                    <div ng-if="year_selected">
                    <ul class="list-unstyled row">
                        <li class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-6 text-left">{{getPhrase('total_classes')}}:</div>
                                <div class="col-xs-6 text-center"><h3> @{{total_classes}}</h3></div>
                            </div>
                        </li>
                        <li class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-6 text-left">{{getPhrase('present')}}:</div>
                                <div class="col-xs-6 text-center"><h3> @{{present}}</h3></div>
                            </div>
                        </li>
                        <li class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-6 text-left">{{getPhrase('absent')}}:</div>
                                <div class="col-xs-6 text-center"><h3> @{{absent}}</h3></div>
                            </div>
                        </li>
                        <li class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-6 text-left">{{getPhrase('leave')}}:</div>
                                <div class="col-xs-6 text-center"><h3> @{{leave}}</h3></div>
                            </div>
                        </li>
                    </ul>
        </div>
                    
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-success button btn-lg" data-dismiss="modal">{{getPhrase('its_okay')}}</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="lessionplan_summary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{getPhrase('topics_completed')}}</h4>
                </div>
                <div class="modal-body attendance-calendar-report">

                    <div class="row" ng-if="year_selected">
<div class="col-md-12">   
 
  
   
     
         <div class="col-md-5">
             <div class="">
                <a href="#">
                  <img ng-if="topics_completed.user.image!=''" class="profile" 
                  src="{{IMAGE_PATH_PROFILE}}@{{topics_completed.user.image}}" 
                  alt="@{{topics_completed.user.name}}">
                  
                  <img ng-if="topics_completed.user.image==''" class="profile" 
                  src="{{IMAGE_PATH_PROFILE_DEFAULT_THUMBNAIL}}" 
                  alt="@{{topics_completed.user.name}}">

                </a>
              

                <h4 class="media-heading">@{{topics_completed.user.name}}</h4>
                <p class="">@{{ topics_completed.user.job_title}} | @{{topics_completed.user.qualification}} </p>
                <p><a href="mailto:@{{topics_completed.user.email}}">@{{topics_completed.user.email}}</a></p>
                </div>

         </div>
      
     <div class="col-md-7">
       <ul class="list-unstyled text-left attendance-calendar-report">
            <li class="title"><strong>@{{selected_subject_name}}</strong></li>

           <li ng-if="topics_completed.topic_data.length>0" ng-repeat="topic in topics_completed.topic_data"> <i class="fa color-gray fa-check" aria-hidden="true"></i> @{{topic.topic_name}} - @{{topic.completed_on}} </li>

           <li ng-if="topics_completed.topic_data.length==0"> {{getPhrase('no_data_available')}} </li>

       </ul>
     </div>
      
 
 
</div>
        </div>
                    
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-success button btn-lg" data-dismiss="modal">{{getPhrase('its_okay')}}</button>
                </div>
            </div>
        </div>
    </div>


        </div>
    </div>
</div>

@stop
 
 <?php
 $student_id = $student->id; ?>

@section('footer_scripts')
    @include('attendance.reports.scripts.js-scripts', array('student_id'=>$student_id, 'user'=>$user))
@stop
@section('custom_div_end')
</div>
@stop