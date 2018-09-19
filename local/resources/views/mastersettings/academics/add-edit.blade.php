@extends($layout)

@section('header_scripts')
<link href="{{CSS}}ajax-datatables.css" rel="stylesheet">
<link href="{{CSS}}plugins/datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">  
@stop

@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a  href="{{URL_COURSES_DASHBOARD}}">{{ getPhrase('master_setup_dashboard')}}</a></li>
							<li><a href="{{URL_MASTERSETTINGS_ACADEMICS}}">{{ getPhrase('academics')}}</a> </li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<!-- /.row -->
				
				<div class="panel panel-custom">
					<div class="panel-heading">
						<div class="pull-right messages-buttons helper_step2">
							<a href="{{URL_MASTERSETTINGS_ACADEMICS}}" class="btn  btn-primary button" >{{ getPhrase('list')}}</a>
						</div>
					<h1>{{ $title }}  </h1>
					</div>
					<div class="panel-body form-auth-style" id="app">
					<?php $button_name = getPhrase('create'); ?>
					@if ($record)
					 <?php $button_name = getPhrase('update'); ?>
						{{ Form::model($record, 
						array('url' => URL_MASTERSETTINGS_ACADEMICS_EDIT.$record->slug, 
						'method'=>'patch','name'=>'formAcademics ', 'novalidate'=>'')) }}
					@else
						{!! Form::open(array('url' => URL_MASTERSETTINGS_ACADEMICS_ADD, 'method' => 'POST','name'=>'formAcademics ', 'novalidate'=>'')) !!}
					@endif

					 @include('mastersettings.academics.form_elements', array('button_name'=> $button_name),
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
 

 <script src="{{JS}}moment.min.js"></script>

  <script src="{{JS}}plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script >
     $(function () {
        $('#dp1, #dp2').datetimepicker({
               format: 'YYYY-MM-DD',
            
            });
    });

</script>
 @stop