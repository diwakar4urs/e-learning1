@extends($layout)
@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a  href="{{URL_SETTINGS_DASHBOARD}}">{{ getPhrase('master_settings')}}</a></li>
							<li><a href="{{URL_MASTERSETTINGS_RELIGIONS}}">{{ getPhrase('religions')}}</a> </li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<!-- /.row -->
				
				<div class="panel panel-custom">
					<div class="panel-heading">
						<div class="pull-right messages-buttons">
							<a href="{{URL_MASTERSETTINGS_RELIGIONS}}" class="btn  btn-primary button" >{{ getPhrase('list')}}</a>
						</div>
					<h1>{{ $title }}  </h1>
					</div>
					<div class="panel-body form-auth-style" id="app">
					<?php $button_name = getPhrase('create'); ?>
					@if ($record)
					 <?php $button_name = getPhrase('update'); ?>
						{{ Form::model($record, 
						array('url' => URL_MASTERSETTINGS_RELIGIONS_EDIT. $record->slug, 
						'method'=>'patch','name'=>'formReligion ', 'novalidate'=>'')) }}
					@else
						{!! Form::open(array('url' => URL_MASTERSETTINGS_RELIGIONS_ADD, 'method' => 'POST','name'=>'formReligion ', 'novalidate'=>'')) !!}
					@endif

					 @include('mastersettings.religions.form_elements', array('button_name'=> $button_name),
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
