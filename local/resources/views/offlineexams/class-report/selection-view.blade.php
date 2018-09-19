@extends($layout)

@section('header_scripts')

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
                      <li>
                        <a href="{{URL_ACADEMICOPERATIONS_DASHBOARD}}">
                            {{getPhrase('academic_operations')}}
                        </a>
                    </li>
                   
                    <li>
                        
                            {{$title}}
                        
                    </li>
                </ol>
            </div>
        </div>
         {!! Form::open(array('url' => URL_PRINT_CLASS_OFFLINE_MARKS_REPORT, 'method' => 'POST', 'name'=>'htmlform ','target'=>'_blank', 'id'=>'htmlform', 'novalidate'=>'')) !!}

    <div class="panel panel-custom">
            <div class="panel-heading">
                <h1>
                    {{getPhrase('select_details')}}
                 
                </h1>
            </div>
            <div class="panel-body instruction">

            <?php 
            $user = Auth::user();

            $role_name = getRoleData($user->role_id);
            
            $param = array('class'=>'custom-row-6');
            if($role_name=='student') {

                $param = array('user_slug'=>$user->slug, 
                                'class'=>'custom-row-6');
            }
        ?>
                @include('common.year-selection-view', $param)

                    <fieldset  class="form-group">
                         <label for = "offline_quiz_category_id">{{getPhrase('category')}}</label>
                        <select 
                        name      = "offline_quiz_category_id" 
                        id        = "offline_quiz_category_id" 
                        class     = "form-control" 
                        ng-model  = "offline_quiz_category_id" 
                        ng-change = "getStudentMarks112()"
                        ng-options= "option.id as option.title for option in quiz_categories track by option.id">
                        <option value="">{{getPhrase('select')}}</option>
                        </select>
                    </fieldset>

                <hr>
                       
   <div ng-show="result_data.length>0" class="row">

   <div class="col-sm-4 col-sm-offset-8">
            <div class="input-group">
                    <input type="text" ng-model="search" class="form-control input-lg" placeholder="{{getPhrase('search')}}" name="search" />
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
        </div>
   </div>
   <br>
 
    <div class="row vertical-scroll">
    <h4 ng-if="result_data.students.length>0" >@{{course_title}}</h4>
    <table ng-if="result_data.students.length>0" class="table table-bordered" style="border-collapse: collapse;">
    <thead>
        <th style="border:1px solid #000;">{{getPhrase('name')}}</th>
        
        <th style="border:1px solid #000;">{{getPhrase('roll_no')}}</th>
        <th style="border:1px solid #000;" ng-repeat="subject in subjects">@{{subject.subject_code}} (@{{subject.total_marks}})</th>
        <th style="border:1px solid #000;">AVG. %</th>
        
    </thead>
    <tbody>
    <tr ng-repeat="student in students | filter:search track by $index">
        <td style="border:1px solid #000;"><a href="{{URL_USER_DETAILS}}@{{student.slug}}">@{{student.name}}</a></td>
        
        <td style="border:1px solid #000;">@{{student.roll_no}}</td>
        
         <td style="border:1px solid #000; text-align: center;" ng-repeat="marks_record in student.marks">@{{marks_record.score.marks_obtained}}</td>
        <td style="border:1px solid #000;">
       
        <div class="progress">
          <div  ng-class="{'progress-bar progress-bar-success':student.average>=75, 'progress-bar progress-bar-warning':student.average<75 && student.average>=50, 'progress-bar progress-bar-danger':student.average<50 && student.average>=0}" role="progressbar" aria-valuenow="@{{student.average}}"
          aria-valuemin="0" aria-valuemax="100" style="width:@{{student.average}}%">
            @{{student.average}}%
          </div>
        </div>

        </td>
    </tr> 
    </tbody>
    </table>
</div>
 
<div ng-if="result_data.students.length<=0"  class="text-center" >{{getPhrase('no_data_available')}}</div> 
<br>
<a ng-if="result_data.students.length>0"  class="btn btn-primary" ng-click="printIt()">Print</a>
  </div>
</div>
                </hr>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}

@stop
 
@section('footer_scripts')

  @include('offlineexams.class-report.scripts.js-scripts')
    
@stop