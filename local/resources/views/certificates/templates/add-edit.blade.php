@extends('layouts.admin.adminlayout')
 

@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->

				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a  href="{{URL_SETTINGS_DASHBOARD}}">{{ getPhrase('master_settings')}}</a></li>
							<li><a href="{{URL_MASTERSETTINGS_CERTIFICATE_TEMPLATES}}">{{ getPhrase('certificate_templates') }}</a> </li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
				@include('errors.errors')	
			 <div class="panel panel-custom col-lg-6 col-lg-offset-3">				<div class="panel-heading">						<div class="pull-right messages-buttons">
							<a href="{{URL_MASTERSETTINGS_CERTIFICATE_TEMPLATES}}" class="btn  btn-primary button" >{{ getPhrase('list')}}</a>
						</div>
					<h1>{{ $title }}  </h1>
					</div>
					<div class="panel-body" >
					<?php $button_name = getPhrase('create'); ?>
					@if ($record)
					 <?php $button_name = getPhrase('update'); ?>
						{{ Form::model($record, 
						array('url' => URL_MASTERSETTINGS_CERTIFICATE_TEMPLATES_EDIT.$record->slug, 
						'method'=>'patch','novalidate'=>'','name'=>'formCertificates ')) }}
					@else
						{!! Form::open(array('url' => URL_MASTERSETTINGS_CERTIFICATE_TEMPLATES_ADD, 'method' => 'POST', 'files' => true,'novalidate'=>'','name'=>'formCertificates ')) !!}
					@endif

					 @include('certificates.templates.form_elements', 
					 array('button_name'=> $button_name),
					 array('record' => $record))
					{!! Form::close() !!}
					</div>

				</div>
			</div>
		</div>
@stop
@section('footer_scripts')

	@include('common.validations')
	@include('common.editor')
@stop
 