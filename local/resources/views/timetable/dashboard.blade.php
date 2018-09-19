@extends($layout)
@section('content')

<div id="page-wrapper">
			<div class="container-fluid">
			<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							 <li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							 <li>
							 <a href="{{URL_ACADEMICOPERATIONS_DASHBOARD}}">{{getPhrase('academic_operations')}}</a> </li>
							 <li>{{ $title}}</li>
						</ol>
					</div>
				</div>

				 <div class="row">
					<div class="col-md-3">
						<div class="card card-blue text-xs-center helper_step1">
							<div class="card-block">
					  <h4 class="card-title">
					  <i class="fa fa-sliders" aria-hidden="true"></i>
					  </h4>

						<p class="card-text">{{ getPhrase('timings_set')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_TIMINGSET}}">
								{{ getPhrase('lets_start')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-black text-xs-center helper_step2">
							<div class="card-block">
					  <h4 class="card-title">
					  	<i class="fa fa-clock-o" aria-hidden="true"></i>
					  </h4>

								<p class="card-text">{{ getPhrase('create_timetable')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_TIMETABLE_VIEW}}">
								{{ getPhrase('lets_start')}}
							</a>
						</div>
					</div>
                    
					  

				
		<!-- /#page-wrapper -->

@stop

@section('footer_scripts')


@stop
