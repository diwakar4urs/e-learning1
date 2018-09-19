@extends('layouts.admin.adminlayout')
 
@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="/"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="/library/authors">{{ getPhrase('authors')}}</a> </li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
				@include('errors.errors')	
				<div class="panel panel-custom" >
					<div class="panel-heading">
						<div class="pull-right messages-buttons">
							<a href="/library/authors" class="btn  btn-primary button" >{{ getPhrase('list')}}</a>
						</div>
					<h1>{{ $title }}  </h1>
					</div>
					<div class="panel-body" >
					<?php $button_name = getPhrase('create'); ?>
					@if ($record)
					 <?php $button_name = getPhrase('update'); ?>
						{{ Form::model($record, 
						array('url' => ['library/authors/edit', $record->slug], 
						'method'=>'patch')) }}
					@else
						{!! Form::open(array('url' => 'library/authors/add', 'method' => 'POST')) !!}
					@endif

					 @include('library.authors.form_elements', 
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
 

@stop
 