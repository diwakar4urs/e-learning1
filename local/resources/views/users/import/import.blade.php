@extends($layout)

@section('content')
<div id="page-wrapper" ng-controller="TabController">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							@if(checkRole(getUserGrade(2)))
							<li><a href="{{URL_USERS."all"}}">{{ getPhrase('users')}}</a> </li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
							@else
							<li class="active">{{$title}}</li>
							@endif
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<!-- /.row -->
				
	<div class="panel panel-custom col-lg-12">
					<div class="panel-heading">
					@if(checkRole(getUserGrade(2))) 
						<div class="pull-right messages-buttons">
							 
							<a href="{{URL_USERS."all"}}" class="btn  btn-primary button" >{{ getPhrase('list')}}</a>
							 
						</div>
						@endif
					<h1>{{ $title }}  </h1>
					</div>
					<div class="row">
						<div class="col-md-4">
					<div class="panel-body text-center">
					
					<a href="{{DOWNLOAD_LINK_USERS_IMPORT_EXCEL}}" class="btn btn-info">{{getPhrase('download_template')}}
					</a>
					
					<?php $button_name = getPhrase('upload'); ?>
					
						{!! Form::open(array('url' => URL_USERS_IMPORT, 'method' => 'POST', 'novalidate'=>'','name'=>'formUsers ', 'files'=>'true')) !!}
					

	 
				 
					<fieldset >
					<label class="margintop30">Upload Excel</label>
						{{-- {{ Form::label('excel', getphrase('upload_excel')) }} --}}
						 
						
					{!! Form::file('excel', array('class'=>'form-control','id'=>'excel_input', 'accept'=>'.xls,.xlsx', 'required'=>'true')) !!}
							 
							 
					 
					</fieldset>
	 
					
						<div class="buttons text-center">
							<button class="btn btn-lg btn-primary button" 
							ng-disabled='!formUsers.$valid'>{{ $button_name }}</button>
						</div>

					 
					{!! Form::close() !!}
					</div>
				</div>
				<div class="col-md-8">
						<h4>{{ getPhrase('information_helper_for_excel_data')}}</h4>

						  @include('common.year-selection-view', array('class'=>'custom-row-6'))
						  <div class="row">
						  <div class="col-md-12 vertical-scroll" >
						  
						  <table class='table' ng-if="result_data">
						  <thead>
						  	<th>Academic ID</th>
						  	<th>Course parent ID</th>
						  	<th>Course ID</th>
						  	<th>Year</th>
						  	<th>Semester</th>
						  	
						  </thead>	
						  <tbody>

						  	<tr>
						  		<td>@{{result_data.academic_id}}</td>
						  		<td>@{{result_data.course_parent_id}}</td>
						  		<td>@{{result_data.course_id}}</td>
						  		<td>@{{result_data.year}}</td>
						  		<td>@{{result_data.semister}}</td>
						  		
						  	</tr>
						  </tbody>
						  </table>	
						  </div>
						  	
						  </div>
					</div>
			</div>

				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
@endsection

@section('footer_scripts')
 @include('common.validations')
   @include('common.alertify')
   @include('users.import.scripts.js-scripts')
 <script>
 	var file = document.getElementById('excel_input');

file.onchange = function(e){
    var ext = this.value.match(/\.([^\.]+)$/)[1];
    switch(ext)
    {
        case 'xls':
        case 'xlsx':
     
            break;
        default:
              alertify.error("{{getPhrase('file_type_not_allowed')}}");
            this.value='';
    }
};
 </script>
@stop