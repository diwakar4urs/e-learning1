@extends('layouts.admin.adminlayout')
 
@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="{{URL_LIBRARY_LIBRARYDASHBOARD}}">{{ getPhrase('library_dashboard')}}</a></li>
							<li><a href="{{URL_LIBRARY_MASTERS}}">{{ getPhrase('masters')}}</a></li>
							<li><a href="{{URL_LIBRARY_COLLECTIONS}}{{ $master_record->slug}}">{{ $master_record->title.' '.getPhrase('collections')}}</a></li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<!-- /.row -->
				<?php 

				 	$librarySettings = getLibrarySettings();
				

				?>
				<div class="panel panel-custom" ng-controller="angLibraryController">
					<div class="panel-heading">
						<div class="pull-right messages-buttons">
                            <a href="{{URL_LIBRARY_COLLECTIONS}}{{ $master_record->slug}}" class="btn btn-primary button helper_step1">{{ $master_record->title.' '.getPhrase('collections')}}</a>						</div>
					<h1>{{ $title }}  </h1>
					</div>
					<div class="panel-body" >
					<?php $button_name = getPhrase('create'); ?>
				   @if($record)
				   <?php $button_name =  getphrase('update');?>
				   {{ Form::model($record,array('url'=>URL_LIBRARY_COLLECTIONS_EDIT.$master_record->slug,'method'=>'patch')) }}
				   @else
					{!! Form::open(array('url' => URL_LIBRARY_COLLECTIONS_ADD.$master_record->slug, 'method' => 'POST')) !!} 
                   @endif

					<div class="row">
						 <fieldset class="form-group col-md-4">
							
							{{ Form::label('series_prefix', getphrase('series_prefix')) }}
							<span class="text-red">*</span>
							 <div class="input-group">
	      						<div class="input-group-addon">{{getSetting('library_series_prefix','library_settings')}}</div>
							{{ Form::text('series_prefix', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'A1001', 'ng-model'=>'prefix')) }}
							</div>
						</fieldset>

						<fieldset class="form-group col-md-4">
							{{ Form::label('from', getphrase('from')) }}
							<span class="text-red">*</span>
							{{ Form::text('from', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '1', 'ng-model'=>'from')) }}
						</fieldset>
						<fieldset class="form-group col-md-4">
							{{ Form::label('to', getphrase('to')) }}
							<span class="text-red">*</span>
							{{ Form::text('to', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '100', 'ng-model'=>'to')) }}
						</fieldset>
					
					</div>
					<div class="row">
					<?php $collectionTypes = (new App\librarySettings())->getCollectionTypes();
						?>
						<fieldset class="form-group col-md-4">
							{{ Form::label('asset_type', getphrase('type')) }}
							<span class="text-red">*</span>
							{{Form::select('asset_type', $collectionTypes, null, ['class'=>'form-control'])}}
						</fieldset>

					 	<fieldset ng-if="from!=null" class="form-group col-md-4">
							{{ Form::label('to', 'Number Preview') }}
							<input type="text" class="form-control" readonly value="{{$librarySettings->prefix}} @{{ prefix }} @{{ from }}">
						</fieldset>

						<fieldset ng-if="from!=null" class="form-group col-md-4">
							{{ Form::label('to', '&nbsp; &nbsp;') }}
							<input type="text" class="form-control" readonly value="{{$librarySettings->prefix}} @{{ prefix }} @{{ to }}">
						</fieldset>
						
					</div>
					<div class="buttons text-center">
							<button class="btn btn-lg btn-primary button">{{ getPhrase('generate') }}</button>
						</div>
					{!! Form::close() !!}
					</div>

				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
@stop
@section('footer_scripts')
 <script src="{{JS}}angular.js"></script>
 <script src="{{JS}}scripts/libraryMaster.js"></script>

@stop
 