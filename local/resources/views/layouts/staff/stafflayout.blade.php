<!DOCTYPE html>

<html lang="en" dir="{{ (App\Language::isDefaultLanuageRtl()) ? 'rtl' : 'ltr' }}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="{{getSetting('meta_description', 'seo_settings')}}">
	<meta name="keywords" content="{{getSetting('meta_keywords', 'seo_settings')}}">
	 
	<link rel="icon" href="{{IMAGE_PATH_SETTINGS.getSetting('site_favicon', 'site_settings')}}" type="image/x-icon" />
	<title>@yield('title') {{ isset($title) ? $title : getSetting('site_title','site_settings') }}</title>
	<!-- Bootstrap Core CSS -->
	 @yield('header_scripts')
	<link href="{{CSS}}bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="{{CSS}}bootstrap-datepicker.min.css">
	<link href="{{CSS}}sweetalert.css" rel="stylesheet" type="text/css">
	
	<!-- Morris Charts CSS -->
	<link href="{{CSS}}plugins/morris.css" rel="stylesheet">
	<!-- Proxima Nova Fonts CSS -->
	<link href="{{CSS}}proximanova.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="{{CSS}}{{getSetting('current_theme', 'site_settings')}}-theme.css" rel="stylesheet">
	<!-- Custom Fonts -->
	<link href="{{CSS}}custom-fonts.css" rel="stylesheet" type="text/css">
	<link href="{{CSS}}materialdesignicons.css" rel="stylesheet" type="text/css">
	{{-- <link href="{{FONTAWSOME}}font-awesome.min.css" rel="stylesheet" type="text/css"> --}}
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body ng-app="academia">
 @yield('custom_div')
 <?php 
 $class = '';
 if(!isset($right_bar))
 	$class = 'no-right-sidebar';

 ?>
	<div id="wrapper" class="{{$class}}">
		<!-- Navigation -->
		<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<a class="navbar-brand" href="{{PREFIX}}"><img src="{{IMAGE_PATH_SETTINGS.getSetting('site_logo', 'site_settings')}}" alt="{{getSetting('site_title','site_settings')}}"></a>
			</div>

			<!-- Top Menu Items -->
			<?php //$newUsers = (new App\User())->getLatestUsers(); 
			?>
			<ul class="nav navbar-right top-nav">
				
				<li class="dropdown profile-menu">
					<div class="dropdown-toggle top-profile-menu" data-toggle="dropdown">
						@if(Auth::check())
						<div class="username">
							<h2>{{Auth::user()->name}}</h2>
							 
						</div>
						@endif
						
						<div class="profile-img"> <img src="{{ getProfilePath(Auth::user()->image, 'thumb') }}" alt=""> </div>
						<div class="mdi mdi-menu-down"></div>
					</div>
					<ul class="dropdown-menu">
						<li>
							<a href="{{URL_USERS_EDIT}}{{Auth::user()->slug}}">
								<sapn><i class="fa fa-user" aria-hidden="true"></i> {{ getPhrase('my_profile') }}</sapn>
							</a>
						</li>
						<li>
							<a href="{{URL_USERS_CHANGE_PASSWORD}}{{Auth::user()->slug}}">
								<sapn><i class="fa fa-key" aria-hidden="true"></i> {{ getPhrase('change_password') }}</sapn>
								</a>
						</li>

 
						<?php $messages_module = FALSE;
						$message_settings = getSetting('messaging_system_for','messaging_system');

						if($message_settings=='all' || $message_settings=='admin_student_staff')
						{
							$messages_module = TRUE;
						}
						?>
						 @if($messages_module)
						<li>
							<a href="{{URL_MESSAGES}}">
								<sapn><i class="fa fa-comments-o" aria-hidden="true"></i> {{ getPhrase('messages')}}</sapn>
								</a>
						</li>
						@endif

						<li > 

						<a href="{{URL_NOTIFICATIONS}}" ><i class="fa fa-bell-o" aria-hidden="true"></i>

					{{ getPhrase('notifications') }} </a> 

					</li>

					<li>

							<a href="{{URL_FEEDBACK_SEND}}">

								<sapn><i class="fa fa-commenting-o" aria-hidden="true"></i> {{ getPhrase('feedback') }}</sapn>

							</a>

						</li>


					<li>
							<a href="{{URL_USERS_LOGOUT}}">
								<sapn><i class="fa fa-sign-out" aria-hidden="true"></i> {{ getPhrase('logout') }}</sapn>
							</a>
						</li>
					</ul>
				</li>
			</ul>
			<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
			<!-- /.navbar-collapse -->
		</nav>
		<aside class="left-sidebar">			<div class="collapse navbar-collapse navbar-ex1-collapse">				<ul class="nav navbar-nav side-nav">
		               <li {{ isActive($active_class, 'dashboard') }}> 
						<a href="{{PREFIX}}">
							<i class="icon-home"></i> {{ getPhrase('dashboard') }} 
						</a> 
					</li>
                    
                    <li {{ isActive($active_class, 'subjectPreferences') }} > 

					<a   href="{{URL_STAFF_SUBJECT_PREFERENCES.Auth::user()->slug}}">
					<i class="fa fa-hand-o-up"></i>{{ getPhrase('subject_preferences') }}</a></li>
					 
 					<li {{ isActive($active_class, 'academic') }} > 

					<a href="{{URL_STUDENT_ATTENDENCE.Auth::user()->slug}}">
					<i class="fa fa-calendar-check-o"></i>{{ getPhrase('attendance') }}</a></li>

					<li {{ isActive($active_class, 'lession') }} > 

					<a   href="{{URL_LESSION_PLANS_DASHBOARD.Auth::user()->slug}}">
					<i class="fa fa-paper-plane-o"></i>{{ getPhrase('lesson_plans') }}</a></li>

					<li {{ isActive($active_class, 'timetable') }} > 

					<a   href="{{URL_TIMETABLE_STAFF.Auth::user()->slug}}">
					<i class="fa fa-calendar"></i>{{ getPhrase('timetable') }}</a></li>
				
					</li>


					@if($messages_module)					
					<li {{ isActive($active_class, 'messages') }} > 
<a  href="{{URL_MESSAGES}}"><span><i class="fa fa-comments-o fa-2x" aria-hidden="true"><h5 class="badge badge-success">{{$count = Auth::user()->newThreadsCount()}}</h5></i></span>
					{{ getPhrase('messages')}} </a>
						
					
					@endif
					<li {{ isActive($active_class, 'notifications') }} > 

						<a href="{{URL_NOTIFICATIONS}}" ><i class="fa fa-bell-o" aria-hidden="true"></i>

					{{ getPhrase('notifications') }} </a> 

					

					</li>

				</ul>
			</div>
		</aside>
		@if(isset($right_bar))
			
		<aside class="right-sidebar" id="rightSidebar">
			<button class="sidebat-toggle" id="sidebarToggle" href='javascript:'><i class="mdi mdi-menu"></i></button>
			<div class="panel panel-right-sidebar">
				<?php $data = '';
			if(isset($right_bar_data))
				$data = $right_bar_data;
			?>
				@include($right_bar_path, array('data' => $data))
			</div>
		</aside>
	 
	@endif
		@yield('content')
	</div>
	<!-- /#wrapper -->
	<!-- jQuery -->
	<script src="{{JS}}jquery-1.12.1.min.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="{{JS}}bootstrap.min.js"></script>

 
	<!--JS Control-->
	<script src="{{JS}}main.js"></script>
	<script src="{{JS}}sweetalert-dev.js"></script>



	 @yield('footer_scripts')

	@include('errors.formMessages')

 	@yield('custom_div_end')
	{!!getSetting('google_analytics', 'seo_settings')!!}
</body>

</html>