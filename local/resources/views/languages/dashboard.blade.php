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
					  
					  </h4>

								<p class="card-text">{{ getPhrase('categories')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_LMS_CATEGORIES}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-green text-xs-center">
							<div class="card-block">
					  <h4 class="card-title">
					  	<h4 class="card-title">
								
						  
					  </h4>

								<p class="card-text">{{ getPhrase('contents')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_LMS_CONTENT}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
                   <div class="col-md-3">
						<div class="card card-yellow text-xs-center">
							<div class="card-block">
							<h4 class="card-title">
							
						
							</h4>
								<p class="card-text">{{ getPhrase('series')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_LMS_SERIES}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
@stop

@section('footer_scripts')
 

@stop
