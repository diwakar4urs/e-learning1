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
                        <p class="card-text">{{ getPhrase('bonafide__contents')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_SETTINGS_VIEW."bonafide-content"}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-green text-xs-center">
							<div class="card-block">
					  <h4 class="card-title">
					  	<h4 class="card-title">
								
						  <i class="fa fa-cogs" aria-hidden="true"></i>
					  </h4>

								<p class="card-text">{{ getPhrase('bonafide_settings')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_SETTINGS_VIEW."bonafide-settings"}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
                   <div class="col-md-3">
						<div class="card card-red text-xs-center">
							<div class="card-block">
							<h4 class="card-title">
                             <i class="fa fa-newspaper-o" aria-hidden="true"></i>							
                             </h4>
								<p class="card-text">{{ getPhrase('transfer_certificate_fields')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_SETTINGS_VIEW."transfer-certificate-fields"}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-blue text-xs-center">
							<div class="card-block">
							<h4 class="card-title">
                          <i class="fa fa-wrench" aria-hidden="true"></i>
							</h4>
								<p class="card-text">{{ getPhrase('transfer_certificate_settings')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_SETTINGS_VIEW."transfer-certificate-settings"}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					 <div class="col-md-3">
						<div class="card card-orange text-xs-center">
							<div class="card-block">
							<h4 class="card-title">
							<i class="fa fa-id-card" aria-hidden="true"></i>

							</h4>
								<p class="card-text">{{ getPhrase('id_card_fields')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_SETTINGS_VIEW."id-card-fields"}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-yellow text-xs-center">
							<div class="card-block">
							<h4 class="card-title">
							<i class="fa fa-gear" aria-hidden="true"></i>
							</h4>
								<p class="card-text">{{ getPhrase('id_card_settings')}}</p>
							</div>
							<a class="card-footer text-muted" 
							href="{{URL_SETTINGS_VIEW."id-card-settings"}}">
								{{ getPhrase('view_all')}}
							</a>
						</div>
					</div>

					</div>
				
@stop

@section('footer_scripts')
 
@stop
