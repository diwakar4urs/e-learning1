@extends('layouts.admin.adminlayout')

<link href="{{CSS}}plugins/datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">	

@section('custom_div')
<?php 
$data = null;
if($record) {
 
	$data = $timingset;
	
}
?>
<div ng-controller="timigsetController" ng-init="intilizeData({{$data}})">
 
<?php $button_name = getPhrase('create'); ?>
					@if ($record)
					 <?php $button_name = getPhrase('update'); ?>
						{{ Form::model($record, 
						array('url' => URL_TIMINGSET_EDIT.'/'.$record->slug, 
						'method'=>'patch', 'name'=>'formTimingset ', 'novalidate'=>'')) }}
					@else
						{!! Form::open(array('url' => URL_TIMINGSET_ADD, 'method' => 'POST', 'name'=>'formTimingset ', 'novalidate'=>'')) !!}
					@endif
@stop

@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="{{URL_ACADEMICOPERATIONS_DASHBOARD}}">  {{ getPhrase('academic_operatons')}}</a></li> 
							<li><a href="{{URL_TIMETABLE_DASHBOARD}}">  {{ getPhrase('timetable_dashboard')}}</a></li> 
							<li><a href="{{URL_TIMINGSET}}">{{ getPhrase('timing_sets')}}</a> </li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
				@include('errors.errors')	

				<div class="row">
				<div class="panel panel-custom col-lg-12 ">
					<div class="col-md-7">
						<div class="panel-heading">
						<div class="pull-right messages-buttons">
							<a href="{{URL_TIMINGSET}}" class="btn  btn-primary button helper_step1" >{{ getPhrase('list')}}</a>
						</div>
					<h1>{{ $title }}  </h1>
					</div>
					<div class="panel-body " >
	

					 @include('timetable.timingset.form_elements', 
					 array('button_name'=> $button_name),
					 array('record' => $record))
					
					</div>
					</div>
					<div class="col-md-5">
						
						@include('timetable.timingset.right-bar')
					</div>
					</div>
				</div>
				 
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
@stop
@section('footer_scripts')
  <script src="{{JS}}bootstrap-toggle.min.js"></script>   
  @include('common.alertify')
  @include('timetable.timingset.scripts.js-scripts');
  @include('common.validations', array('isLoaded'=>1));
  <script src="{{JS}}moment.min.js"></script>
  <script src="{{JS}}plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
 <script>
 
      $(function () {
        $('.datetimepicker').datetimepicker({
        	  format: 'HH:mm',
        	  stepping: 10,
        });
        
    });
 </script>

@stop
 
@section('custom_div_end')
{!! Form::close() !!}
</div>
@stop