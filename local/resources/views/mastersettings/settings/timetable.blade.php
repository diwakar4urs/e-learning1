@extends($layout)
@section('content')

<div id="page-wrapper">
			<div class="container-fluid">
			<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							 <li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							 <li><a href="{{URL_SETTINGS_DASHBOARD}}">{{getPhrase('mastersettings_dashboard')}}</a></li>
							 <li>{{ $title}}</li>
						</ol>
					</div>
				</div>

				 <div class="row">
					<div class="col-md-3">
						<div class="card card-blue text-xs-center">
							<div class="card-block">
					  <h4 class="card-title">
					  	<h4 class="card-title">
                         <i class="fa fa-list-alt" aria-hidden="true"></i>


                          					  </h4>
                        <p class="card-text">{{ getPhrase('timetable__contents')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_SETTINGS_VIEW."time-table"}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					
                   

					</div>
				
@stop

@section('footer_scripts')
 
@stop
