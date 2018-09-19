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
					<div class="col-md-3">
						<div class="card card-blue text-xs-center helper_step1">
							<div class="card-block">
					  <h4 class="card-title">
					  	<?php $studentObject =  App\Student::where('academic_id','!=',0)
					  	                              ->where('course_parent_id','!=',0)
					  	                              ->where('course_id','!=',0)
					  	                              ->where('current_year','!=',-1)
					  	                              ->where('current_semister','!=',-1)->get()->count();
                               
							 ?>
						   {{$studentObject}}
						
							</h4>
					  </h4>

								<p class="card-text">{{ getPhrase('students')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_LIBRARY_USERS}}student">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-green text-xs-center helper_step2">
							<div class="card-block">
					  <h4 class="card-title">{{ App\Staff::join('users','users.id','=','staff.user_id')
					                      ->where('course_parent_id','!=','')
					                      ->where('course_id','!=','')
					                      ->where('users.status','!=',0)
					                      ->get()->count()}}
					                     </h4>

								<p class="card-text">{{ getPhrase('staff')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_LIBRARY_USERS}}staff">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
                   <div class="col-md-3">
						<div class="card card-red text-xs-center helper_step3">
							<div class="card-block">
							<h4 class="card-title">
						<?php $libraryIssuesObject = new App\LibraryIssue();
						$count = $libraryIssuesObject->getIssuesCount('student');
						?>
						{{$count}}
							</h4>
								<p class="card-text">{{ getPhrase('student_book_return')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_LIBRARY_LIBRARYDASHBOARD_BOOKS}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					 <div class="col-md-3">
						<div class="card card-orange text-xs-center helper_step4">
							<div class="card-block">
							<h4 class="card-title">
								<?php $libraryIssuesObject = new App\LibraryIssue();
						$count = $libraryIssuesObject->getIssuesStaffCount('staff');
						?>
						{{$count}}
							</h4>
								<p class="card-text">{{ getPhrase('staff_book_return')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_LIBRARY_LIBRARYDASHBOARD_BOOKS_STAFF}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
			
			<hr>
			    @if(checkRole(getUserGrade(8)))
 
			<div class="col-md-3">
						<div class="card card-yellow text-xs-center helper_step5">
							<div class="card-block">
							<h4 class="card-title">
								<i class="fa fa-database"></i>
							</h4>
							
								<p class="card-text">{{ getPhrase('asset_types')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_LIBRARY_ASSETS}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-black text-xs-center helper_step6">
							<div class="card-block">
							<h4 class="card-title">
								<i class="fa fa-book"></i>
							</h4>
							
								<p class="card-text">{{ getPhrase('master_data')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_LIBRARY_MASTERS}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-blue text-xs-center helper_step7">
							<div class="card-block">
							<h4 class="card-title">
								<i class="fa fa-paint-brush"></i>
							</h4>
							
								<p class="card-text">{{ getPhrase('publishers')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_PUBLISHERS}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-green text-xs-center helper_step8">
							<div class="card-block">
							<h4 class="card-title">
								<i class="fa fa-mortar-board"></i>
							</h4>
							
								<p class="card-text">{{ getPhrase('authors')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_AUTHORS}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					</div>

					<div class="col-md-6">
						  {!! Charts::assets() !!}
				  {!! $asset_charts->render() !!}
					</div>


 @endif


		<!-- /#page-wrapper -->
@stop

@section('footer_scripts')

@stop
