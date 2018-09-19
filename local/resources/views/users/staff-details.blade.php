 @extends($layout)
 @section('header_scripts')

@stop
@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i> </a> </li>
								
							@if(checkRole(getUserGrade(2)))
							<li><a href="{{URL_USERS_DASHBOARD}}">{{getPhrase('users_dashboard')}}</a></li>
							<li><a href="{{URL_USERS."staff"}}">{{ getPhrase('staff_users') }}</a> </li>
							@endif
							
							@if(checkRole(getUserGrade(7)))
							<li><a href="{{URL_PARENT_CHILDREN}}">{{ getPhrase('users') }}</a> </li>
							@endif

							<li>{{ $title }} </li>
						</ol>
					</div>
				
				</div>

<div class="panel panel-custom">
				 	<div class="panel-heading">						<h1>{{ getPhrase('details_of').' '.$record->name }}</h1>					</div>
					<div class="panel-body">
						<div class="profile-details text-center">
							<div class="profile-img"><img src="{{ getProfilePath($record->image,'profile')}}" alt=""></div>
							<div class="aouther-school">
								<h2>{{ $record->name}}</h2>
								<p><span>{{$record->email}}</span></p>
								
							</div>

						</div>
						<hr>
						<div class="row">
						<div class="col-lg-3 col-md-6">
						<div class="card card-blue text-xs-center">
						<div class="card-block">
							<h4 class="card-title">
							<i class="fa fa-paper-plane-o"></i></h4>
							<p class="card-text">{{ getPhrase('lesson_plans')}}</p>
						</div>
							<a class="card-footer text-muted" href="{{URL_LESSION_PLANS_DASHBOARD.$record->slug}}">{{ getPhrase('view_details')}}</a>
						</div>
						</div>



						<div class="col-lg-3 col-md-6">
						<div class="card card-yellow text-xs-center">
						<div class="card-block">
							<h4 class="card-title">
							<i class="fa fa-book"></i></h4>
							<p class="card-text">{{ getPhrase('library_history')}}</p>
						</div>
							<a class="card-footer text-muted" href="{{URL_USER_LIBRARY_DETAILS.$record->slug}}">{{ getPhrase('view_details')}}</a>
						</div>
						</div>

						<div class="col-lg-3 col-md-6">
						<div class="card card-green text-xs-center">
						<div class="card-block">
							<h4 class="card-title">
							<i class="fa fa-calendar"></i></h4>
							<p class="card-text">{{ getPhrase('timetable')}}</p>
						</div>
							<a class="card-footer text-muted" href="{{URL_TIMETABLE_STAFF.$record->slug}}">{{ getPhrase('view_details')}}</a>
						</div>
						</div>
					</div>
					</div>
						 
						</div>
						 
 
					</div>
				</div>
				</div>
			<!-- /.container-fluid -->
</div>
@endsection
 

@section('footer_scripts')
 


@stop
