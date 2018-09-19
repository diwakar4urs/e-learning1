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
							<li><a href="{{URL_LIBRARY_LIBRARYDASHBOARD}}">{{ getPhrase('library_dashboard')}}</a></li>

							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
								
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						<h1>{{ $title }}</h1>
					</div>
					<div class="panel-body packages">
						<div > 
						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%" id="users-table">
							<thead>
								<tr>
									@if($user_type=='student') 
									<th id="helper_step1">{{ getPhrase('roll_no')}}</th>
									@else
									<th id="helper_step1">{{ getPhrase('staff_id')}}</th>
									@endif
									<th>{{ getPhrase('image')}}</th>
									<th>{{ getPhrase('first_name')}}</th>
									<th>{{ getPhrase('last_name')}}</th>
									<th>{{ getPhrase('email')}}</th>

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
  
 @include('common.datatables', array('route'=>URL_LIBRARY_USERS_GETLIST.$user_type, 'route_as_url'=>'TRUE','extra_var'=>1,'user_type'=>$user_type))
 
@stop
