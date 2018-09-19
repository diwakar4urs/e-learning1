@extends($layout)

@section('header_scripts')
 
<link href="{{CSS}}bootstrap-datepicker.css" rel="stylesheet">
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
                       @endif

                    @if(checkRole(getUserGrade(2)))
                    <li><a href="{{URL_USERS."student"}}">{{ getPhrase('student_users') }}</a> </li>
                    @endif
                      
                      @if(checkRole(getUserGrade(7)))
                   <li><a href="{{URL_PARENT_CHILDREN}}">{{ getPhrase('children') }}</a> </li>
                   @endif
                  
                   <li><a href="{{URL_USER_DETAILS.$user->slug}}">{{ $user->name }} {{getPhrase('details') }}</a> </li> 
                   <li>{{ getPhrase('marks_details') }} </li>
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
                <div class="row">
                   
                         @include('common.year-selection-view',array(
                                'user_slug'=>$user->slug, 
                                'class'=>'custom-row-6'))
                </div>
                
                    
   <div ng-hide="show_div">
       {{getPhrase('no_data_available_with_the_selection')}}
   </div>
  <div class="row" ng-if="year_selected" ng-show="show_div">
  <div class="col-md-12">
<div class="row">
    <div class="col-md-9"><h2 >Select Category</h2></div>
    <div class="col-md-3">
      
    </div>
</div>
  </div>
    <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked nav-tabs nav-tabs-custom">
        <li  ng-repeat="category in exam_categories" ng-class="{ active: isSet(category.id) }">
            <a href ng-click="setTab(category.id)">@{{category.category}}</a>
        </li>
         
        </ul>
    </div>
 
    <div class="col-md-9">    
    <div class="table-responsive" ng-if="exam_list.length>0">
          <table class="table table-hover table-striped result-info-table">
            <thead>
            <tr>
                <th><strong>{{getPhrase('title')}}</strong></th>
                <th><strong>{{getPhrase("score")}}</strong></th>
                <th><strong>{{getPhrase('status')}}</strong></th>
                <th><strong>{{getPhrase('date_of_exam')}}</strong></th>
                <th><strong>{{getPhrase('action')}}</strong></th>
                </tr>
            </thead>  
            <tbody>
            <tr ng-repeat="exam in exam_list | filter:search track by $index">
                
                <td>@{{exam.title}}</td>
                <td>@{{exam.marks_obtained}}/@{{exam.total_marks}}</td>
                <td>@{{exam.exam_status|uppercase}} (@{{exam.percentage}})</td>
                <td>@{{exam.updated_at}}</td>
                <td>
                <a href="{{URL_STUDENT_EXAM_ANALYSIS_BYSUBJECT.$user->slug}}/@{{exam.quiz_slug}}/@{{exam.result_slug}}" target="_blank" class="btn btn-info btn-sm">{{getPhrase('analysis')}}</a>
                
                &nbsp;&nbsp;<a href="{{URL_RESULTS_VIEW_ANSWERS}}@{{exam.quiz_slug}}/@{{exam.result_slug}}" target="_blank" class="btn btn-success btn-sm">{{getPhrase('view_key')}}</a>
                </td>
                </tr>
            </tbody>
          </table>
        </div>


  </div>
</div>
                  
                </hr>
            </div>
        </div>
    </div>
</div>
@stop
 

@section('footer_scripts')

  
    @include('student.reports.scripts.js-scripts',array('user_slug'=>$user->slug,'user'=>$user))
    
@stop