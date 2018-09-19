@extends($layout)
@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a  href="{{URL_EXAMS_DASHBOARD}}">{{ getPhrase('exams_dashboard')}}</a></li>
							<li><a href="{{URL_OFFLINEEXMAS_QUIZ_CATEGORIES}}">{{ getPhrase('offline_quiz_categories')}}</a> </li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<!-- /.row -->
				
				<div class="panel panel-custom">
					<div class="panel-heading">
						<div class="pull-right messages-buttons helper_step1">
							<a href="{{URL_OFFLINEEXMAS_QUIZ_CATEGORIES}}" class="btn  btn-primary button" >{{ getPhrase('list')}}</a>
						</div>
					<h1>{{ $title }}  </h1>
					</div>
					<div class="panel-body form-auth-style" id="app">
					<?php $button_name = getPhrase('create'); ?>
					@if ($record)
					 <?php $button_name = getPhrase('update'); ?>
						{{ Form::model($record, 
						array('url' => URL_OFFLINEEXMAS_QUIZ_CATEGORIES_EDIT. $record->slug, 
						'method'=>'patch','name'=>'formOfflineQuizCategory ', 'novalidate'=>'')) }}
					@else
						{!! Form::open(array('url' => URL_OFFLINEEXMAS_QUIZ_CATEGORIES_ADD, 'method' => 'POST','name'=>'formOfflineQuizCategory ', 'novalidate'=>'')) !!}
					@endif

					 @include('offlineexams.quizcategories.form_elements', array('button_name'=> $button_name),
					 array())
					 
					{!! Form::close() !!}
					 

					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
@stop

  @include('common.validations')
