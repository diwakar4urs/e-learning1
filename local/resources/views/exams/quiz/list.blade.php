@extends('layouts.admin.adminlayout')

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
							<li><a  href="{{URL_EXAMS_DASHBOARD}}">{{ getPhrase('exams_dashboard')}}</a></li>

							<li>{{ $title }}</li>

						</ol>

					</div>

				</div>

				<!-- /.row -->

				<div class="panel panel-custom">

					<div class="panel-heading">

						<div class="pull-right messages-buttons helper_step1">

							<a href="{{URL_QUIZ_ADD}}" class="btn  btn-primary button" >{{ getPhrase('create')}}</a>

						</div>

						<div class="pull-right messages-buttons helper_step2">

							<a href="{{URL_EXAM_SERIES}}" class="btn  btn-primary button" >{{ getPhrase('create_series')}}</a>

						</div>

						<h1>{{ $title }}</h1>

					</div>

					<div class="panel-body packages">

						<div > 

						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">

							<thead>

								<tr>

									
									<th>{{ getPhrase('type')}}</th>
									
									<th id="helper_step3">{{ getPhrase('title')}} (ID)</th>

									<th>{{ getPhrase('duration')}}</th>

									<th>{{ getPhrase('category')}}</th>

									<th>{{ getPhrase('is_paid')}}</th>

									<th>{{ getPhrase('total_marks')}}</th>

									

									<th id="helper_step4">{{ getPhrase('action')}}</th>

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

 @include('common.datatables', array('route'=>URL_QUIZ_GETLIST, 'route_as_url' => TRUE))

 @include('common.deletescript', array('route'=>URL_QUIZ_DELETE))

@stop

