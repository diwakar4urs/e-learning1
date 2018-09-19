@extends($layout)
 
@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="{{URL_LIBRARY_LIBRARYDASHBOARD}}">{{ getPhrase('library_dashboard')}}</a></li>
							<li><a href="{{URL_LIBRARY_MASTERS}}">{{ getPhrase('library_masters')}}</a></li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')
			 
				<div class="panel panel-custom" ng-controller="angLibraryController">
					<div class="panel-heading">
						<div class="pull-right messages-buttons">
							<a href="{{URL_LIBRARY_MASTERS}}" class="btn  btn-primary button" >{{ getPhrase('list')}}</a>
						</div>
					<h1>{{ $title }}  </h1>
					</div>
					<div class="panel-body" >
					<?php $button_name = getPhrase('create'); ?>
					@if ($record)
					 <?php $button_name = getPhrase('update'); ?>
						{{ Form::model($record, 
						array('url' => URL_LIBRARY_MASTERS_EDIT.$record->slug, 
						'method'=>'patch', 'files' => 'true','name'=>'formQuiz ', 'novalidate'=>'')) }}
					@else
						{!! Form::open(array('url' => URL_LIBRARY_MASTERS_ADD, 'method' => 'POST', 'files' => 'true','name'=>'formQuiz ', 'novalidate'=>'')) !!}
					@endif
					
					 @include('library.library-masters.form_elements', 
					 array('button_name'=> $button_name),
					 array('authors' 		=> $authors,
					 		'publishers' 	=> $publishers,
					 		'asset_types' 	=> $asset_types,
					 		'record' 		=> $record,
					 		))
					 		
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

 <script src="{{JS}}angular.js"></script>
 

@stop
 