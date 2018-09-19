@extends($layout)
@section('header_scripts')

@stop
@section('content')

<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="{{URL_LANGUAGES_LIST}}">{{ getPhrase('languages')}}</a> </li>
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
					<?php $language_data = json_decode($record->phrases);?>			
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						
						<h1>{{ $title }}</h1>
					</div>
					<div class="panel-body packages">
					{!! Form::open(array('url' => URL_LANGUAGES_UPDATE_STRINGS.$record->slug, 'method' => 'PATCH', 
						'novalidate'=>'','name'=>'formSettings ', 'files'=>'true')) !!}
						<div class="table-responsive"> 
						<ul class="list-group">
						@if(count($language_data))
						@foreach($language_data as $key=>$value)
						 
					 <div class="col-md-6">
						<fieldset class="form-group">
						   {{ Form::label($key, $key) }}
						  
						   <input type="text" class="form-control" name="{{$key}}" 
					 		required="true" value = "{{$value}}" >
					 		 

							</fieldset>
							</div>

						  @endforeach

						  @else
							  <li class="list-group-item">{{ getPhrase('no_settings_available')}}</li>
						  @endif
						</ul>

						</div>

						@if(count($language_data))
						<div class="buttons text-center">
							<button class="btn btn-lg btn-primary button" ng-disabled='!formTopics.$valid'
							>{{ getPhrase('update') }}</button>
						</div>
						@endif
							{!! Form::close() !!}
					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
@endsection
 

@section('footer_scripts')
 
@stop
