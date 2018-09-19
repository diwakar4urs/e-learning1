@extends($layout)

@section('header_scripts')

<link rel="stylesheet" type="text/css" href="{{CSS}}select2.css">
@stop
@section('content')
<div id="page-wrapper" ng-controller="staffController">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
						<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							 <li><a href="{{URL_USERS_DASHBOARD}}">{{getPhrase('users_dashboard')}}</a></li>
							<li><a href="{{URL_USERS."users"}}">{{ getPhrase('all_users')}}</a> </li>
							<li class="active">{{getPhrase('staff_profile')}}</li>
						</ol>
					</div>
				</div>


					@include('errors.errors')
				<!-- /.row -->
				
				<div class="panel panel-custom">
					<div class="panel-heading">
						<div class="pull-right messages-buttons">
							 
							<a href="{{URL_USERS."staff"}}" class="btn  btn-primary button" >{{ getPhrase('staff_list')}}</a>
							 
						</div> 
						<h1>{{ getPhrase('update')}} {{$user_name}} {{ getPhrase('profile')}}</h1>
					</div>
					<div class="panel-body">


						<ul class="nav nav-tabs add-student-tabs">


							<li class="{{isActive($tab_active, 'general')}}"><a data-toggle="tab" href="#academic_details">{{ getPhrase('general_details')}}</a></li>
							
							<li class="{{isActive($tab_active, 'personal')}}" ><a data-toggle="tab" href="#personal_details">{{ getPhrase('personal_details')}}</a></li>
							
							<li  class="{{isActive($tab_active, 'contact')}}" ><a data-toggle="tab" href="#contact_details">{{ getPhrase('contact_details')}}</a></li>
							
						</ul>
						<div class="tab-content tab-content-style">
							
					@include('users.staff.staff-general-details-fields', 
					array('tab_active' => $tab_active, 'record' => $record ,'courses_list'=>$courses_list, 'courses_parent_list'=>$courses_parent_list))
							@include('users.staff.staff-personel-details-fields', 
									array('tab_active' => $tab_active, 'record' => $record,'countries' => $countries))
							@include('users.staff.staff-contact-details-fields', 
									array('tab_active' => $tab_active, 'record' => $record))
							
						</div>
					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
@stop

@section('footer_scripts')
	<script src="{{JS}}bootstrap-datepicker.min.js"></script>
 
	@include('users.staff.scripts.js-scripts')

@stop