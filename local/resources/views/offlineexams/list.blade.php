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
							{{-- @if($active_class=='academic') --}}
							<li><a href="{{URL_ACADEMICOPERATIONS_DASHBOARD}}">{{getPhrase('academic_operations')}}</a> </li>
							{{-- @endif --}}

							{{-- @if($active_class=='exams')
							<li><a href="{{URL_EXAMS_DASHBOARD}}">{{getPhrase('exams_dashboard')}}</a> </li>
							@endif --}}
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>

				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						
						<div class="pull-right messages-buttons helper_step1">
							<a href="{{URL_OFFLINE_EXAMS_IMPORT_MARKS}}" class="btn  btn-primary button" >{{ getPhrase('import_excel')}}</a>
						</div>
					 
						<h1>{{ $title }}</h1>
					</div>
					<div class="panel-body packages">
						<div > 
						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
							<thead>
								<tr >
									<th id="helper_step2">{{ getPhrase('exam')}} (ID)</th>
									<th>{{ getPhrase('category')}}</th>
									<th>{{ getPhrase('subject')}}</th>
									<th>{{ getPhrase('maximum_marks')}}</th>
									<th>{{ getPhrase('pass_percentage')}}</th>
									<th>{{ getPhrase('start_date')}}</th>
									<th>{{ getPhrase('end_date')}}</th>
									<th id="helper_step3">{{ getPhrase('action')}}</th>
									
									
								</tr>
							</thead>
							 
						</table>
						</div>

					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
@endsection
 

@section('footer_scripts')
 
 @include('common.datatables', 
 array('route'=>'offlineexams.dataTable' ))
 @include('common.deletescript',
  array('route'=>URL_OFFLINE_EXAMS_DELETE))

@stop
