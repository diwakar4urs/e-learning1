 					
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
				         <input type="file" class="form-control" name="image" id="image">
				         
				    </fieldset>
					 <fieldset class="form-group col-md-4" >
					@if($record)	
				   		@if($record->image)
				         <?php 
				         $image_path = IMAGE_PATH_UPLOAD_EXAMSERIES_DEFAULT;
				         if($record->image)
				         	$image_path = IMAGE_PATH_UPLOAD_LIBRARY.$record->image;
				          ?>
				         <img src="{{$image_path}}" height="100" width="100">
				         @endif
				     @endif
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
						
						{{ Form::label('chargible_price_if_lost', getphrase('chargeable_price_if_lost')) }}
						<span class="text-red">*</span>
						{{ Form::text('chargible_price_if_lost', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '200')) }}
				</fieldset>
				</div>
					<fieldset class="form-group">
						
						{{ Form::label('description', getphrase('description')) }}
						
						{{ Form::textarea('description', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => 'Fine description')) }}
					</fieldset>

					<div class="buttons text-center">
							<button class="btn btn-lg btn-primary button">{{ $button_name }}</button>
						</div>
		 