@extends($layout)
@section('header_scripts')
{!! Charts::assets() !!}
@stop
@section('content')

<div id="page-wrapper">
			<div class="container-fluid">
			<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							 
							<li><i class="fa fa-home"></i> {{ $title}}</li>
						</ol>
					</div>
				</div>

				 <div class="row">
				   <div class="col-md-3">
						<div class="card card-green text-xs-center helper_step5">
							<div class="card-block">
								<h4 class="card-title">
									<i class="fa fa-users" aria-hidden="true"></i>

								</h4>
								<p class="card-text">{{ getPhrase('users')}}</p>
							</div>
							<a class="card-footer text-muted" href="{{URL_USERS_DASHBOARD}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					
					<div class="col-md-3">
						<div class="card card-blue text-xs-center helper_step2">
							<div class="card-block">
								<h4 class="card-title">
									<i class="fa fa-university" aria-hidden="true"></i>
								</h4>
								<p class="card-text">{{ getPhrase('academics')}}</p>
							</div>
							<a class="card-footer text-muted" href="{{URL_ACADEMICOPERATIONS_DASHBOARD}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>

					<div class="col-md-3">
						<div class="card card-red text-xs-center helper_step3">
							<div class="card-block">
								<h4 class="card-title">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
								</h4>
								<p class="card-text">{{ getPhrase('exams')}}</p>
							</div>
							<a class="card-footer text-muted" href="{{URL_EXAMS_DASHBOARD}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>

					<div class="col-md-3">
						<div class="card card-yellow text-xs-center helper_step4">
							<div class="card-block">
								<h4 class="card-title">
									<i class="fa fa-leanpub" aria-hidden="true"></i>
								</h4>
								<p class="card-text">{{ 'LMS'}}</p>
							</div>
							<a class="card-footer text-muted" href="{{URL_LMS_DASHBOARD}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					
					
					<div class="col-md-3">
						<div class="card card-black text-xs-center helper_step6">
							<div class="card-block">
								<h4 class="card-title">
									<i class="fa fa-book" aria-hidden="true"></i>
								</h4>
								<p class="card-text">{{ getPhrase('library')}}</p>
							</div>
							<a class="card-footer text-muted" href="{{URL_LIBRARY_LIBRARYDASHBOARD}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-yellow text-xs-center helper_step7">
							<div class="card-block">
								<h4 class="card-title">
									<i class="fa fa-language" aria-hidden="true"></i>
								</h4>
								<p class="card-text">{{ getPhrase('languages')}}</p>
							</div>
							<a class="card-footer text-muted" href="{{URL_LANGUAGES_LIST}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-green text-xs-center helper_step8">
							<div class="card-block">
								<h4 class="card-title">
									<i class="fa fa-cog" aria-hidden="true"></i>
								</h4>
								<p class="card-text">{{ getPhrase('settings')}}</p>
							</div>
							<a class="card-footer text-muted" href="{{URL_SETTINGS_DASHBOARD}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					 <div class="col-md-3">
						<div class="card card-blue text-xs-center helper_step1">
							<div class="card-block">
								<h4 class="card-title">
									<i class="fa fa-cogs" aria-hidden="true"></i>
								</h4>
								<p class="card-text">{{ getPhrase('master_setup')}}</p>
							</div>
							<a class="card-footer text-muted" href="{{URL_COURSES_DASHBOARD}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					


                  </div>
		 
			<!-- /.container-fluid -->
 <div class="row">
				<?php $latest_students = App\User::getLatestUsersDashboard('student',8);?>   

				<div class="col-md-6 helper_step9">
              <!-- USERS LIST -->
              <div class="panel panel-primary">
					      <div class="panel-heading">
					      <a href="{{URL_USERS}}students" class="uppercase text-white pull-right">{{getPhrase('view_all')}}</a>
					      {{getPhrase('latest_students')}}</div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix list-unstyled">
                    @foreach($latest_students as $user)

                    <li>
                      <img src="{{ getProfilePath($user->image)}}" alt="User Image">
                      <a class="users-list-name" href="{{URL_USER_DETAILS.$user->slug}}">{{ucfirst($user->name)}}</a>
                      <span class="users-list-date">{{humanizeDate($user->created_at)}}</span>
                    </li>
                    @endforeach
                  </ul>
                  <!-- /.users-list -->
                </div>
             
                <!-- /.box-footer -->
              </div>
              <!--/.box -->
            </div>
 			<?php $latest_staff = App\User::getLatestUsersDashboard('staff',8);?> 
 			<div class="col-md-6 helper_step10">
              <!-- USERS LIST -->
              <div class="panel panel-primary">
					<div class="panel-heading" >
					 <a href="{{URL_USERS}}staff" class="uppercase text-white pull-right">{{getPhrase('view_all')}}</a>
					{{getPhrase('latest_staff')}}

					</div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix list-unstyled">
                    @foreach($latest_staff as $user)

                    <li>
                      <img src="{{ getProfilePath($user->image)}}" alt="User Image">
                      <a class="users-list-name" href="{{URL_STAFF_DETAILS.$user->slug}}">{{ucfirst($user->name)}}</a>
                      <span class="users-list-date">{{humanizeDate($user->created_at)}}</span>
                    </li>
                    @endforeach
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                 
              </div>
              <!--/.box -->
            </div>

 
				
		<?php 
		$online_payments = App\Payment::latestPayments('online',5);
	 
		?>
				
					<div class="col-md-12 helper_step11">
						@include('dashboard-elements.payments-information', 
						array(	'heading'	=> getPhrase('recent_online_payments'),
								'records'   => $online_payments
							 ))

					</div>
				

				<?php $offline_payments = App\Payment::latestPayments('offline',5);?>
				
					<div class="col-md-12 helper_step12">
	  					@include('dashboard-elements.payments-information', 
						array(	'heading'	=> getPhrase('recent_offline_payments'),
								'records'   => $offline_payments
							 ))
					</div>  
				 

	</div>
</div>
		<!-- /#page-wrapper -->

@stop

@section('footer_scripts')
 @include('common.chart', array($chart_data,'ids' =>$ids))
@stop
