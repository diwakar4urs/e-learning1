@extends($layout)
@section('content')

<div id="page-wrapper">
			<div class="container-fluid">
			<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							 <li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							 <li>{{ $title}}</li>
						</ol>
					</div>
				</div>

					<div class="col-md-3">
						<div class="card card-green text-xs-center helper_step1">
							<div class="card-block">
					  <h4 class="card-title">
					  	<i class="fa fa-certificate"></i>
					  </h4>

								<p class="card-text">{{ getPhrase('certificates')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_CERTIFICATES_DASHBOARD}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
                   <div class="col-md-3">
						<div class="card card-red text-xs-center helper_step2">
							<div class="card-block">
							<h4 class="card-title">
						<i class="fa fa-exchange"></i>
						
							</h4>
								<p class="card-text">{{ getPhrase('transfers')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_STUDENT_TRANSFERS}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					 <div class="col-md-3">
						<div class="card card-orange text-xs-center helper_step3">
							<div class="card-block">
							<h4 class="card-title">
							<i class="fa fa-calendar"></i>
							</h4>
								<p class="card-text">{{ getPhrase('timetable')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_TIMETABLE_DASHBOARD}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-yellow text-xs-center helper_step4">
							<div class="card-block">
							<h4 class="card-title">
								<i class="fa fa-external-link"></i>
					
							</h4>
								<p class="card-text">{{ getPhrase('offline_exams')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_OFFLINE_EXAMS}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>

					</div>
					<div class="col-md-3">
						<div class="card card-blue text-xs-center helper_step5">
							<div class="card-block">
					  <h4 class="card-title">
                     <i class="fa fa-check-square-o">	</i>			 
                      </h4>
                          
								<p class="card-text">{{ getPhrase('class_attendance_report')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_STUDENT_CLASS_ATTENDANCE}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-black text-xs-center helper_step6">
							<div class="card-block">
					  <h4 class="card-title">
                     <i class="fa fa-line-chart" aria-hidden="true"></i>			 
                      </h4>
                          
								<p class="card-text">{{ getPhrase('class_marks_report')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_STUDENT_MARKS_REPORT}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-green text-xs-center helper_step7">
							<div class="card-block">
							<h4 class="card-title">
								<i class="fa fa-users" aria-hidden="true"></i>
					
							</h4>
								<p class="card-text">{{ getPhrase('students_list_class_wise')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_STUDENT_LIST}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-red text-xs-center helper_step8">
							<div class="card-block">
							<h4 class="card-title">
								<i class="fa fa-graduation-cap" aria-hidden="true"></i>
					
							</h4>
								<p class="card-text">{{ getPhrase('course_completed_students')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_STUDENT_COMPLETED_LIST}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-yellow text-xs-center helper_step9">
							<div class="card-block">
							<h4 class="card-title">
								<i class="fa fa-user-circle-o" aria-hidden="true"></i>
					
							</h4>
								<p class="card-text">{{ getPhrase('detained_students_list_class_wise')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_STUDENT_DETAINED_LIST}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>

				
		<!-- /#page-wrapper -->

@stop

@section('footer_scripts')
 
 

@stop
