@extends($layout)
 
@section('header_scripts')
<link href="{{CSS}}animate.css" rel="stylesheet">
@stop

@section('custom_div')
<div ng-controller="courseSubjectsController" ng-init="ingAngData({{$items}})">
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
							<li><a href="{{URL_MASTERSETTINGS_COURSE_SUBJECTS_ADD}}">{{ getPhrase('add_subject_to_course')}}</a> </li>
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
					<?php 
					$subjects_list = [];
					$angular_keys = [];
					?>		

				<!-- /.row -->
					{!! Form::open(array('url' => URL_MASTERSETTINGS_COURSE_SUBJECTS_ADD, 'method' => 'POST', 'name'=>'formQuiz ', 'novalidate'=>'')) !!}

					<input type="hidden" name="academic_id" value="{{$academic_id}}">
					<input type="hidden" name="course_id" value="{{$record->id}}">
					<input type="hidden" name="course_parent_id" value="{{$record->parent_id}}">

				<div class="panel panel-custom academia_visiblelist_fix" data-spy="affix" data-offset-top="0">
					<div class="panel-heading">
						
						<div class="pull-right messages-buttons ">
							  
							<button type="submit" class="btn  btn-success button helper_step3" >{{ getPhrase('update')}}</button>
							<a href="{{URL_MASTERSETTINGS_COURSE}}" class="btn  btn-primary button helper_step1" >{{ getPhrase('courses_list')}}</a>
							 
						</div>
						<h1>{{ $title }}</h1>
					</div>
					 
					<div class="panel-body packages vertical-scroll" id="window_auto_height">
					
				 @for($yearno = 1; $yearno <= $record->course_dueration; $yearno++)
					<h4> {{ getPhrase('year').' '. $yearno }} </h4>
					<div class="sem-parent-container  helper_step2">
					
					@if($record->is_having_semister)
					<?php 
					$semisters = App\CourseSemister::getCourseYearSemisters($course_id, $yearno);
					
					$total_data = [];
					

					?>

						@for($semister=1; $semister <= $semisters->total_semisters; $semister++)
						
						<?php 
						$subjects_list = App\CourseSubject::getCourseSavedSubjects($academic_id, $course_id, $yearno, $semister);
						$angular_key = $yearno.'_'.$semister;
						?>
						<small>SEM {{ $semister }}</small>

						@include('mastersettings.course-subjects.manage-course-subjects.course-list-subview', 
						array(	
							'academic_id' 	=> $academic_id,
							'course_id' 	=> $course_id,
							'yearno' 		=> $yearno,
							'semister' 		=> $semister,
							'subjects' 		=> $subjects_list,
							'angular_key'   => $angular_key,
							))
							 <?php $angular_keys[] = $angular_key;?>
						
						@endfor
						
						@if($semisters->total_semisters == 0)
						<?php 
						$subjects = App\CourseSubject::getCourseSavedSubjects($academic_id, $course_id, $yearno, 0);
						$angular_key = $yearno.'_0';
						 
						?>

						 @include('mastersettings.course-subjects.manage-course-subjects.course-list-subview', 
						array(	
							'academic_id' 	=> $academic_id,
							'course_id' 	=> $course_id,
							'yearno' 		=> $yearno,
							'semister' 		=> 0,
							'subjects' 		=> $subjects_list,
							'angular_key'   => $angular_key,
							))
							 <?php $angular_keys[] = $angular_key;?>
						@endif

					@else
					<?php 
						$subjects = App\CourseSubject::getCourseSavedSubjects($academic_id, $course_id, $yearno, 0);
						$angular_key = $yearno.'_0';
						?>
						 @include('mastersettings.course-subjects.manage-course-subjects.course-list-subview', 
						array(	
							'academic_id' 	=> $academic_id,
							'course_id' 	=> $course_id,
							'yearno' 		=> $yearno,
							'semister' 		=> 0,
							'subjects' 		=> $subjects_list,
							'angular_key'   => $angular_key,
							))
							 <?php $angular_keys[] = $angular_key;?>
					@endif
					 </div>
				@endfor
					</div>
				</div>


				{!! Form::close() !!}
			</div>
			<!-- /.container-fluid -->
		</div>

		
@stop
 
@section('footer_scripts')
	@include('mastersettings.course-subjects.scripts.js-scripts', array('keys'=>$angular_keys))
	@include('common.alertify')

@include('common.affix-window-size-script')
	
@stop 

