 					
 					 <fieldset class="form-group">
						
						{{ Form::label('publisher', getphrase('publisher_name')) }}
						<span class="text-red">*</span>
						{{ Form::text('publisher', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Jack',

							'ng-model'=>'publisher', 

							'ng-pattern'=>getRegexPattern('name'), 

							'required'=> 'true',
							'id'=>'publisher', 

							'ng-class'=>'{"has-error": formpublishers.publisher.$touched && formpublishers.publisher.$invalid}',

							'ng-minlength' => '2',

							'ng-maxlength' => '20',

							)) }}

						<div class="validation-error" ng-messages="formpublishers.publisher.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('pattern')!!}

	    					{!! getValidationMessage('minlength')!!}

	    					{!! getValidationMessage('maxlength')!!}
           
						</div>

					</fieldset>
					<?php  $countries          = (new Settings())->getCountries(); ?>
			
			<fieldset class="form-group">
					{{ Form::label('country', getphrase('country')) }}
				
				{{Form::select('country', $countries, null, ['placeholder' => getPhrase('select'),'class'=>'form-control'])}}
			</fieldset>

					<fieldset class="form-group">
						
						{{ Form::label('description', getphrase('description')) }}
						
						{{ Form::textarea('description', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => ' Description')) }}
					</fieldset>
						
					</fieldset>
					<div class="buttons text-center">

							<button class="btn btn-lg btn-primary button"

							ng-disabled='!formpublishers.$valid'>{{ $button_name }}</button>

						</div>
		 