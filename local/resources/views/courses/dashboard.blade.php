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

				 <div class="row">
				 <div class="col-md-3 ">
						<div class="card card-yellow text-xs-center helper_step1">
							<div class="card-block">
							<h4 class="card-title">
							<i class="fa fa-graduation-cap" aria-hidden="true"></i>
						
							</h4>
								<p class="card-text">{{ getPhrase('academic_years')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_MASTERSETTINGS_ACADEMICS}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-blue text-xs-center  helper_step2">
							<div class="card-block">
					  <h4 class="card-title">
					  <i class="fa fa-list-ul" aria-hidden="true"></i>
					  </h4>

								<p class="card-text">{{ getPhrase('course_list')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_MASTERSETTINGS_COURSE}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3 ">
						<div class="card card-green text-xs-center helper_step3">
							<div class="card-block">
					  <h4 class="card-title">
					  	<h4 class="card-title">
								<i class="fa fa-plus-square" aria-hidden="true"></i>
						  
					  </h4>

								<p class="card-text">{{ getPhrase('add_course')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_MASTERSETTINGS_COURSE_ADD}}">
								{{ getPhrase('create')}}
							</a>
						</div>
					</div>
					<div class="col-md-3 "> 
						<div class="card card-black text-xs-center helper_step4">
							<div class="card-block">
							<h4 class="card-title">
							
						<i class="fa fa-suitcase" aria-hidden="true"></i>
							</h4>
								<p class="card-text">{{ getPhrase('subject_master')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_MASTERSETTINGS_SUBJECTS}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3 ">
						<div class="card card-green text-xs-center helper_step5">
							<div class="card-block">
							<h4 class="card-title">
							<i class="fa fa-tasks" aria-hidden="true"></i>
						
							</h4>
								<p class="card-text">{{ getPhrase('subject_topics')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_MASTERSETTINGS_TOPICS}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
                   
					 <div class="col-md-3 ">
						<div class="card card-black text-xs-center helper_step6">
							<div class="card-block">
							<h4 class="card-title">
							
						<i class="fa fa-external-link-square" aria-hidden="true"></i>
							</h4>
								<p class="card-text">{{ getPhrase('allocate_subject_to_course')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_MASTERSETTINGS_COURSE_SUBJECTS_ADD}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					
					 <div class="col-md-3 ">
						<div class="card card-red text-xs-center helper_step7">
							<div class="card-block">
							<h4 class="card-title">
							
					<i class="fa fa-street-view" aria-hidden="true"></i>
							</h4>
								<p class="card-text">{{ getPhrase('allocate_staff_to_subject')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_MASTERSETTINGS_COURSE_SUBJECTS."staff"}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					 
@stop

@section('footer_scripts')
 

@stop
