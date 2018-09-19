@extends('layouts.admin.adminlayout')
<link href="{{CSS}}animate.css" rel="stylesheet">

@section('content')
 
<div id="page-wrapper" ng-controller="MapTimingsetController" ng-init="initAngData({{$items}})">

            <div class="container-fluid">

                <!-- Page Heading -->

                <div class="row">

                    <div class="col-lg-12">

                        <ol class="breadcrumb">

                            <li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
                            <li><a href="{{URL_TIMETABLE_DASHBOARD}}">  {{ getPhrase('timetable_dashboard')}}</a></li> 
                           <li class="active">{{isset($title) ? $title : ''}}</li>

                        </ol>

                    </div>

                </div>

                    @include('errors.errors')

                <!-- /.row -->
                   <div class="panel panel-custom" >

                    <div class="panel-heading">

                    <h1>{{ $title }}  </h1>

                    </div>

                    {{ Form::model($record, 
                        array('url' => URL_MAP_TIMINGSET_ADD.$record->slug, 
                        'method'=>'post','name'=>'formMaptimetable','novalidate'=>'')) }}

                    <div class="panel-body" >

                  
           
           <div>
              <div class="panel-body packages">
                        <div class="table-responsive"> 
                        <table class="table table-striped table-bordered datatable" cellspacing="0" width="50%">
                            <thead>
                                <tr>
                                    <th>{{ getPhrase('day')}}  <span class="text-red">*</span></th>

                                    <th>{{ getPhrase('timing_set')}} <span class="text-red">*</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($days as $dayno => $dayname)
                                <tr>
                              
                                      <td>
                                         {{$dayname}}
                                      </td>

                                    <td >
                                       <select name="timeset[{{$dayno}}]" 
                                            class="form-control">
                                        @foreach($timingsets as $key=>$value)
                                        <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    </td>

                                </tr>
                                    @endforeach 
                            </tbody>

                           </table>
                        </div>

                    </div>
            </div>
 
               
                <input type="hidden" name="parentmap_data" value="{{$parentmap_data->id}}">
                   
              
               <div class="row" >

                           <fieldset class="form-group col-md-4">
                            
                             {{ Form::label('academic_year', getphrase('academic_year')) }}
                            <span class="text-red">*</span>
                             {{Form::select('academic_id', $academic_years, null, 
                        [   'class'     => 'form-control', 
                            "id"        => "select_academic_year",
                            "ng-model"  => "academic_year",
                            "ng-change" => "getParentCourses(academic_year)",
                            
                            'ng-class'=>'{"has-error": formMaptimetable.academic_year.$touched && formMaptimetable.academic_year.$invalid}',
                        ])}}

                             
                        <div class="validation-error" ng-messages="formMaptimetable.academic_year.$error" >
                            {!! getValidationMessage()!!}
                            {!! getValidationMessage('number')!!}
                        </div>
                    </fieldset> 
                     <fieldset class="form-group col-md-4" ng-if="academic_year"    >
                        
                        <span class="text-red">*</span>
                         <label for="course_parent_id">{{getPhrase('category')}}</label>
                            <select 
                            name="course_parent_id" 
                            id="course_parent_id" 
                            class="form-control" 
                            ng-model="course_parent_id" 
                            ng-change="getChildCourses(academic_year, course_parent_id)"
                                                     >
                            <option value="">{{getPhrase('select')}}</option>
                            <option ng-repeat="option in parent_courses" value="@{{option.id}}">
                            @{{option.course_title}}</option>
                            </select>
                        <div class="validation-error" ng-messages="formMaptimetable.cost.$error" >
                            {!! getValidationMessage()!!}
                            {!! getValidationMessage('number')!!}
                        </div>
                </fieldset>

                <fieldset ng-if="parent_selected" class="form-group col-md-4">
                           
                           <label for="course_id">{{getPhrase('course')}}</label>
                            <select 
                            name="course_id" 
                            id="course_id" 
                            class="form-control" 
                            ng-model="course_id" 
                            ng-change="prepareYears(course_id)"                           
                            >
                            <option value="">{{getPhrase('select')}}</option>
                             <option ng-repeat="option in courses" value="@{{option.id}}">@{{option.course_title}}</option>
                            </select>
                        </fieldset>
                </div>
                </div>


<div ng-if="parent_selected" class="row">
    <div class="col-md-6">
        <div class="exam-year-selection"
         class='containerVertical' id="target"  ng-drop="true" ng-drop-success="onDropComplete($data,$event)"
        >
            <ul class="list-unstyled year-selection-list selected-list">
                <li ng-repeat="item in target_items" id="@{{'target_items'-item.id}}">
                    
                    
                    <span>Course: <strong>@{{item.course_title}}</strong> </span>
                    <span>Year:<strong> @{{item.year}}</strong></span> 
                    <input type="hidden" name="selected_list[]" value="@{{item.id}}">
                    
                <i class="fa fa-trash text-danger pull-right" ng-click="removeItem(item.id, target_items, 'target_items')"></i>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-md-6">
        <div class="exam-year-selection">
            <ul class="list-unstyled year-selection-list list">
     
                <li ng-repeat="year in source_items" ng-if="year!=null" ng-drag="true" ng-drag-data="year" ng-drag-success="onDragComplete($data,$event)" id="@{{'source_items-'+year.id}}">
                <span><strong>Year:</strong> @{{year.year}}</span> </li>
             
            </ul>
        </div>
    </div>
</div>
                 <div class="buttons text-center">
                            <button class="btn btn-lg btn-success button"
                            ng-disabled='!formMaptimetable.$valid'>{{getphrase('submit')}}</button>
                        </div>


                    {!! Form::close() !!}

                    </div>
                </div>

            </div>
    </div>

        <!-- /#page-wrapper -->

@stop

@section('footer_scripts')

@include('maptimetable.scripts.map-scripts', array('quiz_record'=>$record))

 @include('common.validations', array('isLoaded'=>FALSE))
@include('common.alertify')
 <script src="{{JS}}moment.min.js"></script>


@stop

 

 