@extends($layout)

@section('header_scripts')
<link href="{{CSS}}animate.css" rel="stylesheet">
@stop

@section('custom_div')
<div ng-controller="courseSubjectsController" ng-init="ingAngData({{$items}})">
@stop

@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a  href="{{URL_COURSES_DASHBOARD}}">{{ getPhrase('master_setup_dashboard')}}</a></li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<!-- /.row -->
				
				<div class="panel panel-custom">
					<div class="panel-heading">
						<div class="pull-right messages-buttons">
							<a href="{{URL_MASTERSETTINGS_COURSE}}" class="btn  btn-primary button" >{{ getPhrase('courses_list')}}</a>
						</div>
					<h1>{{ $title }}  </h1>
					</div>
					<div class="panel-body" ng-controller="courseSubjectsController">
					<?php $button_name = getPhrase('update'); ?>
				 
						{!! Form::open(array('url' => URL_MASTERSETTINGS_COURSE_SUBJECTS_LOAD, 'method' => 'POST')) !!}
				 

					 @include('mastersettings.course-subjects.form_elements', 
					 array('button_name'=> $button_name),
					 array(
							'academic_years'		=> $academic_years,
					))
					 
					{!! Form::close() !!}


					@if($loadYears)
					{!! Form::open(array('url' => URL_MASTERSETTINGS_COURSE_SUBJECTS_ADD, 'method' => 'POST')) !!}
				 

					 @include('mastersettings.course-subjects.form_elements', 
					 array('button_name'=> $button_name),
					 array(
							'academic_years'		=> $academic_years,
					))
					 
					{!! Form::close() !!}

					@endif
					 

					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
@stop

 
@section('footer_scripts')
	<script src="{{JS}}angular.js"></script>
	@include('mastersettings.course-subjects.scripts.js-scripts')
@stop

@section('custom_div_end')
</div>
@stop