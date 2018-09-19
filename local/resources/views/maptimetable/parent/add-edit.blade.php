@extends($layout)

@section('header_scripts')
<link href="{{CSS}}ajax-datatables.css" rel="stylesheet">
@stop

@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="{{URL_TIMETABLE_DASHBOARD}}">  {{ getPhrase('timetable_dashboard')}}</a></li> 
							<li><a href="{{URL_MAP_TIMINGSET_PARENT}}">{{ getPhrase('parentmaps')}}</a> </li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<!-- /.row -->
				
				<div class="panel panel-custom">
					<div class="panel-heading">
						<div class="pull-right messages-buttons">
							<a href="{{URL_MAP_TIMINGSET_PARENT}}" class="btn  btn-primary button" >{{ getPhrase('list')}}</a>
						</div>
					<h1>{{ $title }}  </h1>
					</div>
					<div class="panel-body" id="app">
					<?php $button_name = getPhrase('create'); ?>
					@if ($record)
					 <?php $button_name = getPhrase('update'); ?>
						{{ Form::model($record, 
						array('url' => URL_MAP_TIMINGSET_PARENT_EDIT.$record->slug, 
						'method'=>'patch','name'=>'formParentMap')) }}
					@else
						{!! Form::open(array('url' => URL_MAP_TIMINGSET_PARENT_ADD, 'method' => 'POST','name'=>'formParentMap')) !!}
					@endif

					 @include('maptimetable.parent.form_elements', array('button_name'=> $button_name),
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
 @include('common.validations')

 @stop