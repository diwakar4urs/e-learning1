@extends('layouts.admin.adminlayout')
@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a  href="{{URL_COURSES_DASHBOARD}}">{{ getPhrase('master_setup_dashboard')}}</a></li>
							<li><a href="{{URL_SUBJECTS}}">{{ getPhrase('subjects')}}</a> </li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<!-- /.row -->
				
				<div class="panel panel-custom col-lg-6 col-lg-offset-3">
					<div class="panel-heading">
						<div class="pull-right messages-buttons helper_step1">
							<a href="{{URL_SUBJECTS}}" class="btn  btn-primary button" >{{ getPhrase('list')}}</a>
						</div>
					<h1>{{ $title }}  </h1>
					</div>
					<div class="panel-body" id="app">
					<?php $button_name = getPhrase('create'); ?>
					@if ($record)
					 <?php $button_name = getPhrase('update'); ?>
						{{ Form::model($record, 
						array('url' => URL_SUBJECTS_EDIT.'/'. $record->slug, 
						'method'=>'patch', 'name'=>'formSubjects ', 'novalidate'=>'')) }}
					@else
						{!! Form::open(array('url' => URL_SUBJECTS_ADD, 'method' => 'POST', 'name'=>'formSubjects ', 'novalidate'=>'')) !!}
					@endif

					 @include('mastersettings.subjects.form_elements', 
					 array('button_name'=> $button_name),
					 array())
					 
					{!! Form::close() !!}
					 

					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
@stop
@section('footer_scripts')
 <script>
 /**
  * This method validates the maximum and pass marks of a given subject
  * @return {[type]} [description]
  */
 function validateMarks()
 {

 	
    $internalmarks = $('#internal_marks');
 	$externalmarks = $('#external_marks');
 	external_marks = parseInt($externalmarks.val(),10);
 	internal_marks = parseInt($internalmarks.val(),10);
    


 	$maxmarks      = $('#maximum_marks');
 	$passmarks     = $('#pass_marks');
 	maximum_marks  = parseInt($maxmarks.val(),10);
 	pass_marks     = parseInt($passmarks.val(),10);

 	
 	

 	
 	//Compare the Maximum mark and Pass mark and give tha appropriate message
 	if(pass_marks > maximum_marks)
 	{
 		alert('{{getPhrase("pass_marks_cannot_be_greater_than_maximum_marks")}}');
 		$passmarks.val();
 	}
 
 }

 </script>
  @include('common.validations');
 @stop