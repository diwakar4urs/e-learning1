@extends($layout)
 
@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="{{URL_LIBRARY_MASTERS}}">{{ getPhrase('masters')}}</a></li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<!-- /.row -->
				<?php 
				$settings = ($record) ? $settings : ''; 
				

				?>
				<div class="panel panel-custom" ng-init="initAngData('{{ $settings }}');" ng-controller="angLibraryController">
					<div class="panel-heading">
						<div class="pull-right messages-buttons">
							<a href="{{URL_LIBRARY_MASTERS}}" class="btn  btn-primary button" >{{ getPhrase('list')}}</a>
						</div>
					<h1>{{ $title }}  </h1>
					</div>
					<div class="panel-body" >
					@if ($record)
						{{ Form::model($record, 
						array('url' => URL_LIBRARY_MASTERS_EDIT.$record->slug, 
						'method'=>'patch', 'files' => true)) }}
					
					@endif
					 					
 					<fieldset class="form-group">
						
						{{ Form::label('asset_type_id', getphrase('asset_type')) }}
						
						{{Form::select('asset_type_id', $asset_types, null, ['placeholder' => getPhrase('select_type'),'class'=>'form-control','readonly'=>'true'])}}
						
					</fieldset>
					<div class="row">
 					 <fieldset class="form-group col-md-4">
						
						{{ Form::label('title', getphrase('title')) }}
						
						{{ Form::text('title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'C Programming' ,'readonly'=>'true')) }}
					</fieldset>


					<fieldset >
						{{ Form::label('image', getphrase('image')) }}
					</fieldset>

					 <fieldset class="form-group col-md-4" >
					@if($record)	
				   		@if($record->image)
				         <?php $librarySettings = getLibrarySettings(); ?>
				         <img src="/{{ $librarySettings->libraryImageThumbnailpath.$record->image }}" height="100" width="100">
				         @endif
				     @endif
				    </fieldset>
				    </div>

 					<div class="row">
 					<fieldset class='form-group col-md-6'>
						{{ Form::label('asset_belongs_to_subject', getphrase('asset_belongs_to_subject')) }}
						
						<div class="form-group row">
							<div class="col-md-6">
							{{ Form::radio('asset_belongs_to_subject', 0, true, array('id'=>'free', 'ng-model' => 'is_subject','readonly'=>'true' )) }}
								
								<label for="free"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('No')}}</label> 
							</div>
							<div class="col-md-6">
							{{ Form::radio('is_eligible_for_fine', 1, false, array('id'=>'paid', 
							'ng-model' => 'is_subject')) }}
								<label for="paid"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('Yes')}} </label>
							</div>
						</div>
					</fieldset>
					 <fieldset class="form-group" ng-if="is_subject==1">
						{{ Form::label('subject_id', getphrase('subject')) }}
						
						{{Form::select('subject_id', $subjects, null, ['placeholder' => getPhrase('select'),'class'=>'form-control','readonly'=>'true'])}}
					</fieldset>
				</div>
				<div class="row">
					 <fieldset class="form-group col-md-6" >
						{{ Form::label('author_id', getphrase('author')) }}
						
						{{Form::select('author_id', $authors, null, ['placeholder' => getPhrase('select'),'class'=>'form-control','readonly'=>'true'])}}
					</fieldset>	
					<fieldset class="form-group col-md-6" >
						{{ Form::label('publisher_id', getphrase('publisher')) }}
						
						{{Form::select('publisher_id', $publishers, null, ['placeholder' => getPhrase('select'),'class'=>'form-control','readonly'=>'true'])}}
					</fieldset>	
				</div>
				<div class="row">
	  				 <fieldset class="form-group col-md-6">
							
							{{ Form::label('isbn', getphrase('ISBN_number')) }}
							{{ Form::text('isbn', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '10022441','readonly'=>'true')) }}
					</fieldset>	
	  				 <fieldset class="form-group col-md-6">
							
							{{ Form::label('edition', getphrase('edition')) }}
							{{ Form::text('edition', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '10022441','readonly'=>'true')) }}
					</fieldset>	
				</div>
				<div class="row">
  				 <fieldset class="form-group col-md-6">
						
						{{ Form::label('actual_price', getphrase('actual_price')) }}
						
						{{ Form::text('actual_price', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '200','readonly'=>'true')) }}
				</fieldset>
  				 <fieldset class="form-group col-md-6">
						
						{{ Form::label('chargible_price_if_lost', getphrase('chargible_price_if_lost')) }}
						
						{{ Form::text('chargible_price_if_lost', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '200','readonly'=>'true')) }}
				</fieldset>
				</div>
					<fieldset class="form-group">
						
						{{ Form::label('description', getphrase('description')) }}
						
						{{ Form::textarea('description', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => 'Fine description','readonly'=>'true')) }}
					</fieldset>

					<fieldset>
						<div class="buttons text-center">
							<a href="{{URL_LIBRARY_MASTERS}}" class="btn  btn-primary button" >{{ getPhrase('assets_list')}}</a>
						</div>
					</fieldset>
					</div>	

				 

					</fieldset>
						
					
					 		
					{!! Form::close() !!}
					</div>

				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
@stop
@section('footer_scripts')
 <script src="{{JS}}angular.js"></script>
 <script src="{{JS}}scripts/libraryMaster.js"></script>

@stop
 