 					
 					<fieldset class="form-group">
						
						{{ Form::label('asset_type_id', getphrase('asset_type')) }}
						<span class="text-red">*</span>
						{{Form::select('asset_type_id', $asset_types, null, ['placeholder' => getPhrase('select_type'),'class'=>'form-control'])}}
						
					</fieldset>
					<div class="row">
 					 <fieldset class="form-group col-md-4">
						
						{{ Form::label('title', getphrase('title')) }}
						<span class="text-red">*</span>
						{{ Form::text('title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'C Programming')) }}
					</fieldset>


					 <fieldset class="form-group col-md-4" >
				   {{ Form::label('image', getphrase('image')) }}
				         <input type="file" class="form-control" name="image">
				         
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
						<span class="text-red">*</span>
						<div class="form-group row">
							<div class="col-md-6">
							{{ Form::radio('asset_belongs_to_subject', 0, true, array('id'=>'free', 'ng-model' => 'is_subject' )) }}
								
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
						<span class="text-red">*</span>
						{{Form::select('subject_id', $subjects, null, ['placeholder' => getPhrase('select'),'class'=>'form-control'])}}
					</fieldset>
				</div>
				<div class="row">
					 <fieldset class="form-group col-md-6" >
						{{ Form::label('author_id', getphrase('author')) }}
						<span class="text-red">*</span>
						{{Form::select('author_id', $authors, null, ['placeholder' => getPhrase('select'),'class'=>'form-control'])}}
					</fieldset>	
					<fieldset class="form-group col-md-6" >
						{{ Form::label('publisher_id', getphrase('publisher')) }}
						<span class="text-red">*</span>
						{{Form::select('publisher_id', $publishers, null, ['placeholder' => getPhrase('select'),'class'=>'form-control'])}}
					</fieldset>	
				</div>
				<div class="row">
	  				 <fieldset class="form-group col-md-6">
							
							{{ Form::label('isbn', getphrase('ISBN_number')) }}
							{{ Form::text('isbn', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '10022441')) }}
					</fieldset>	
	  				 <fieldset class="form-group col-md-6">
							
							{{ Form::label('edition', getphrase('edition')) }}
							{{ Form::text('edition', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '10022441')) }}
					</fieldset>	
				</div>
				<div class="row">
  				 <fieldset class="form-group col-md-6">
						
						{{ Form::label('actual_price', getphrase('actual_price')) }}
						<span class="text-red">*</span>
						{{ Form::text('actual_price', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '200')) }}
				</fieldset>
  				 <fieldset class="form-group col-md-6">
						
						{{ Form::label('chargible_price_if_lost', getphrase('chargible_price_if_lost')) }}
						<span class="text-red">*</span>
						{{ Form::text('chargible_price_if_lost', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '200')) }}
				</fieldset>
				</div>
					<fieldset class="form-group">
						
						{{ Form::label('description', getphrase('description')) }}
						
						{{ Form::textarea('description', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => 'Fine description')) }}
					</fieldset>

					
					</div>	

				 

					</fieldset>
						