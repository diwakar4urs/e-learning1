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
							<li><a href="{{URL_COURSES_DASHBOARD}}">{{getPhrase('master_setup_dashboard')}}</a></li>
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
								
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						
						<div class="pull-right messages-buttons">
							 
							<a href="{{URL_MASTERSETTINGS_COURSE_SUBJECTS_ADD}}" class="btn  btn-primary button helper_step1" >{{ getPhrase('add_or_edit_course_subjects')}}</a>
							 
						</div>
						<h1>{{ $title }}</h1>
					</div>
					<div class="panel-body packages">
						<div > 
						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
							<thead>
								<tr>
									 
									<th id="helper_step2">{{ getPhrase('academic_year')}}</th>
									<th>{{ getPhrase('branch')}}</th>
									<th>{{ getPhrase('course')}}</th>
									<th id="helper_step3">{{ getPhrase('action')}}</th>
								</tr>
							</thead>
							 
						</table>
						{{csrf_field()}}
						</div>

					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
@endsection
 

@section('footer_scripts')
	<script src="{{JS}}angular.js"></script>
	<script src="{{JS}}scripts/courseSubjects.js"></script>

 @include('common.datatables', array('route'=> URL_MASTERSETTINGS_COURSE_SUBJECTS_AJAXLIST.$slug, 'route_as_url' => 1))

@stop
