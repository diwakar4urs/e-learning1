@extends('layouts.admin.adminlayout')
@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="/"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="/departments">{{ getPhrase('departments')}}</a> </li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<!-- /.row -->
				
				<div class="panel panel-custom">
					<div class="panel-heading">
						<div class="pull-right messages-buttons">
							 
							<a href="/departments" class="btn  btn-primary button" >{{ getPhrase('list')}}</a>
							 
						</div>
					<h1>{{ getPhrase('add_department')}}  </h1>
					</div>
					<div class="panel-body">
					<?php $button_name = getPhrase('create'); ?>
					@if ($department)
					 <?php $button_name = getPhrase('update'); ?>
						{{ Form::model($department, 
						array('url' => ['departments/edit-department', $department->slug], 
						'method'=>'patch')) }}
					@else
						{!! Form::open(array('url' => 'departments/add-department', 'method' => 'POST')) !!}
					@endif

					 @include('departments.form_elements', array('button_name'=> $button_name));
					 
					{!! Form::close() !!}
					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
@stop