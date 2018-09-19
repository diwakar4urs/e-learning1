@extends($layout)
 
@section('content')

<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="{{URL_COURSES_DASHBOARD}}">{{getPhrase('master_setup_dashboard')}}</a></li>
							
							<li><a href="{{URL_MASTERSETTINGS_COURSE_SUBJECTS."staff"}}">{{ getPhrase('allocate_staff_to_subject')}}</a> </li>
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
								
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						
						<div class="pull-right messages-buttons">
							 
							<a href="{{URL_MASTERSETTINGS_COURSE_SUBJECTS_ADD}}" class="btn  btn-primary button helper_step1" >{{ getPhrase('allocate_subject_to_course')}}</a>
							 
						</div>
						<h1>{{ $title }}</h1>
					</div>
					<div class="panel-body packages">
					
				 @for($yearno = 1; $yearno <= $record->course_dueration; $yearno++)
					<h4> {{ getPhrase('year').' '. $yearno }} </h4>
					
					@if($record->is_having_semister)
					<?php 
					$semisters = App\CourseSemister::getCourseYearSemisters($course_id, $yearno);
					?>

						@for($semister=0; $semister < $semisters->total_semisters; $semister++)
						<small>SEM {{ $semister+1 }}</small>
						@include('mastersettings.course-subjects.course-list-subview', 
						array(	
							'academic_id' 	=> $academic_id,
							'course_id' 	=> $course_id,
							'yearno' 		=> $yearno,
							'semister' 		=> $semister+1,
							))
						
				
						@endfor
						
						@if($semisters->total_semisters == 0)
						 @include('mastersettings.course-subjects.course-list-subview', 
						array(	
							'academic_id' 	=> $academic_id,
							'course_id' 	=> $course_id,
							'yearno' 		=> $yearno,
							'semister' 		=> 0,
							))
						@endif

					@else
						 @include('mastersettings.course-subjects.course-list-subview', 
						array(	
							'academic_id' 	=> $academic_id,
							'course_id' 	=> $course_id,
							'yearno' 		=> $yearno,
							'semister' 		=> 0,
							))
					@endif
				@endfor
					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
@stop
 
 
