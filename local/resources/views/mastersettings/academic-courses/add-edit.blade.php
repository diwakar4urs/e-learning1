@extends($layout)

@section('header_scripts')
<link href="{{CSS}}animate.css" rel="stylesheet">
@stop
@section('custom_div')
<div ng-controller="academicCourses" ng-init="ingAngData({{$items}})">
@stop

@section('content')
<div id="page-wrapper" >

			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="{{URL_COURSES_DASHBOARD}}">{{getphrase('master_setup_dashboard')}}</a></li>
							<li><a href="{{URL_MASTERSETTINGS_ACADEMICS}}">{{ getPhrase('academics')}}</a> </li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<!-- /.row -->
				
				<div class="panel panel-custom academia_visiblelist_fix" data-spy="affix" data-offset-top="0" >

				<div class="panel-heading">
						<div class="pull-right messages-buttons helper_step1">
							<a href="{{URL_MASTERSETTINGS_ACADEMICS}}" class="btn  btn-primary button" >{{ getPhrase('list')}}</a>
						</div>
					<h1>{{ $title }}  </h1>
					</div>
					<div class="panel-body vertical-scroll" id="app">
					<?php $button_name = getPhrase('create'); ?>
					
					 <?php $button_name = getPhrase('update'); ?>
						{{ Form::model($record, 
						array('url' => URL_MASTERSETTINGS_ACADEMICS_COURSES.$record->slug, 
						'method'=>'post')) }}
					 
    
        <div class="row">
        	<div class="col-md-12 helper_step2">
<h2 class="selected-item-title">{{$record->academic_year_title}}</h2>
       <div class='containerVertical' id="target"  ng-drop="true" ng-drop-success="onDropComplete($data,$event)">
       <div ng-if="!allocated_courses.length" class="subject-placeholder"> {{getPhrase('no_item_selected')}}</div>
           		<div ng-repeat="item in allocated_courses" class="items-sub" id="allocated_courses-@{{item.id}}">@{{item.course_title}}
           		<input type="hidden" name="selected_list[]" data-myname="@{{item.course_title}}" value="@{{item.id}}">
           		<input type="hidden" name="parent_list[]" value="@{{item.parent_id}}">
           		<i class="fa fa-trash text-danger pull-right" ng-click="removeItem(item,'{{$record->id}}')"></i>
           		</div>

       		 </div>

       		 </div>
        </div>
     <p>&nbsp;</p>
    <div class="text-center">
    	<button class="btn btn-primary btn-lg helper_step3">{{getPhrase('update')}}</button>

    </div>
 
					 
					{!! Form::close() !!}


					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->

	
@stop

@section('custom_div_end')
</div>
@stop

@section('footer_scripts')
@include('mastersettings.academic-courses.scripts.js-scripts')
@include('common.alertify')

@include('common.affix-window-size-script', array('newId'=>'app'))
 @stop