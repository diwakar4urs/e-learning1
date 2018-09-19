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
							<li><a  href="{{URL_COURSES_DASHBOARD}}">{{ getPhrase('master_setup_dashboard')}}</a></li>
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
								
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						
						<div class="pull-right messages-buttons">
							 
							<a href="{{URL_TOPICS_IMPORT}}" class="btn  btn-primary button helper_step4" >{{ getPhrase('import')}}</a>
							<a href="{{URL_TOPICS_ADD}}" class="btn  btn-primary button helper_step1" >{{ getPhrase('create')}}</a>
							 
						</div>
						<h1>{{ $title }}</h1>
					</div>
					<div class="panel-body packages">
						<div > 
						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
							<thead>
								<tr>
									 
								 
									<th id="helper_step2">{{ getPhrase('subject')}}</th>
									<th>{{ getPhrase('parent')}}</th>
									<th>{{ getPhrase('topic (id)')}}</th>
									<th>{{ getPhrase('description')}}</th>
									 
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
  
 @include('common.datatables', array('route'=>'topics.dataTable'))
 @include('common.deletescript', array('route'=>URL_TOPICS_DELETE))

@stop
