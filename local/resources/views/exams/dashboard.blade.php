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
					  <i class="fa fa-random"></i>
					  </h4>

								<p class="card-text">{{ getPhrase('categories')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_QUIZ_CATEGORIES}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3 ">
						<div class="card card-green text-xs-center helper_step2">
							<div class="card-block">
					  <h4 class="card-title">
					  	<h4 class="card-title">
								
						  <i class="fa fa-question"></i>
					  </h4>

								<p class="card-text">{{ getPhrase('question_bank')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_QUIZ_QUESTIONBANK}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
                   <div class="col-md-3 ">
						<div class="card card-red text-xs-center helper_step3">
							<div class="card-block">
							<h4 class="card-title">
                           <i class="fa fa-clock-o" aria-hidden="true"></i>						
							</h4>
								<p class="card-text">{{ getPhrase('quiz')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_QUIZZES}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3 ">
						<div class="card card-blue text-xs-center helper_step4">
							<div class="card-block">
							<h4 class="card-title">
                    <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
							</h4>
								<p class="card-text">{{ getPhrase('offline_exam_categories')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_OFFLINEEXMAS_QUIZ_CATEGORIES}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-yellow text-xs-center helper_step5">
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
					 <div class="col-md-3 ">
						<div class="card card-orange text-xs-center helper_step6">
							<div class="card-block">
							<h4 class="card-title">
							<i class="fa fa-list-ol"></i>
							</h4>
								<p class="card-text">{{ getPhrase('exam-series')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_EXAM_SERIES}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3 ">
						<div class="card card-yellow text-xs-center helper_step7">
							<div class="card-block">
							<h4 class="card-title">
							<i class="fa fa-hand-o-right"></i>
							</h4>
								<p class="card-text">{{ getPhrase('instructions')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_INSTRUCTIONS}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>

					</div>

@stop

@section('footer_scripts')


@stop
