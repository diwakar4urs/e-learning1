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
    
        {!! Form::open(array('url' => URL_PRINT_CLASS_ATTENDANCE_REPORT, 'method' => 'POST', 'name'=>'htmlform ','target'=>'_blank', 'id'=>'htmlform', 'novalidate'=>'')) !!}

        
        <div class="panel panel-custom">
            <div class="panel-heading">
                <h1>
                    {{getPhrase('select_details')}}
                 
                </h1>
            </div>
            <div class="panel-body instruction">
                @include('common.year-selection-view', array('class'=>'custom-row-6'))
                <hr>
                       
   <div ng-show="result_data.length>0" class="row">

   <div class="col-sm-4 col-sm-offset-8">
            <div class="input-group">
                    <input type="text" ng-model="search" class="form-control input-lg" placeholder="{{getPhrase('search')}}" name="search" />
                    <span class="input-group-btn">
                        <button class="btn btn-primary btn-lg" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
        </div>
   </div>
   <br>
 <div class="row vertical-scroll" id="printable_data">
  
    <table ng-if="result_data.length>0" class="table table-bordered" style="border-collapse: collapse;">
    <thead>
        <th style="border:1px solid #000;">{{getPhrase('sno')}}</th>
        <th style="border:1px solid #000;" >{{getPhrase('name')}}</th>
        <th style="border:1px solid #000;">{{getPhrase('roll_no')}}</th>
        <th style="border:1px solid #000;">{{getPhrase('total_class')}}</th>
        <th style="border:1px solid #000;">{{getPhrase('present')}}</th>
        <th style="border:1px solid #000;">{{getPhrase('absent')}}</th>
        <th style="border:1px solid #000;">{{getPhrase('leave')}}</th>
        <th style="border:1px solid #000;">%</th>
        
    </thead>
    <tbody>
    <tr ng-repeat="user in result_data | filter:search track by $index">
        <td style="border:1px solid #000;">@{{user.sno}}</td>
        <td style="border:1px solid #000;"><a href="{{URL_USER_DETAILS}}@{{user.slug}}">@{{user.name}}</a></td>
        <td style="border:1px solid #000;">@{{user.roll_no}}</td>
        <td style="border:1px solid #000;">@{{user.total_classes}}</td>
        <td style="border:1px solid #000;">@{{user.present}}</td>
        <td style="border:1px solid #000;">@{{user.absent}}</td>
        <td style="border:1px solid #000;">@{{user.leave}}</td>
        <td style="border:1px solid #000;">
       
        <div class="progress">
          <div  ng-class="{'progress-bar progress-bar-success':user.percentage>=75, 'progress-bar progress-bar-warning':user.percentage<75 && user.percentage>=50, 'progress-bar progress-bar-danger':user.percentage<50 && user.percentage>=0}" role="progressbar" aria-valuenow="@{{user.percentage}}"
          aria-valuemin="0" aria-valuemax="100" style="width:@{{user.percentage}}%">
            @{{user.percentage}}%
          </div>
        </div>

        </td>
    </tr> 
    </tbody>
    </table>
</div>
 
<div ng-if="result_data.length==0" class="text-center" >{{getPhrase('no_data_available')}}</div> 
<br>
<a ng-if="result_data.length>0"  class="btn btn-primary" ng-click="printIt()">Print</a>
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

  
    @include('attendance.class-report.scripts.js-scripts')
    
@stop