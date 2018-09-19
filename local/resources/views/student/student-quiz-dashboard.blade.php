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
						<div class="card card-blue text-xs-center">
							<div class="card-block">
					  <h4 class="card-title">
					  <i class="fa fa-random"></i>
					  </h4>

								<p class="card-text">{{ getPhrase('categories')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_STUDENT_EXAM_CATEGORIES}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-green text-xs-center">
							<div class="card-block">
					  <h4 class="card-title">
					  	<h4 class="card-title">
								<i class="fa fa-list-ol"></i>
						  
					  </h4>

								<p class="card-text">{{ getPhrase('exam_series')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_STUDENT_EXAM_SERIES_LIST}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>

					 @if(checkRole(getUserGrade(12)))
                   <div class="col-md-3">
						<div class="card card-yellow text-xs-center">
							<div class="card-block">
							<h4 class="card-title">
							
						 <i class="fa fa-clock-o"></i>
							</h4>
								<p class="card-text">{{ getPhrase('scheduled_exams')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_QUIZ_GET_SCHEDULED_EXAMS.Auth::user()->slug}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					@endif
@stop

@section('footer_scripts')
 
 

@stop
