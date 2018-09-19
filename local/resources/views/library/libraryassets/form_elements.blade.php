 					
 					 <fieldset class="form-group">
						
						{{ Form::label('asset_type', getphrase('asset_type')) }}
						<span class="text-red">*</span>
						{{ Form::text('asset_type', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Books/Magazines,CD etc')) }}
					</fieldset>
 					<div class="row">
 					 
					 <fieldset class="form-group" ng-if="fine_eligiblity==1">
						
						{{ Form::label('fine_per_day', getphrase('fine_per_day')) }}
						<span class="text-red">*</span>
						
						{{ Form::text('fine_per_day', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '10')) }}
					</fieldset>
				</div>

				<fieldset class="form-group">
						
						{{ Form::label('description', getphrase('description')) }}
						
						{{ Form::textarea('description', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => 'Fine description')) }}
					</fieldset>
					 
                  <div class="buttons text-center">
							<button class="btn btn-lg btn-primary button">{{ $button_name }}</button>
						</div>
		 