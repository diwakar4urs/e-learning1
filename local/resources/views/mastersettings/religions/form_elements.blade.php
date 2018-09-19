                     <fieldset class="form-group">
						
						{{ Form::label('religion_name', getphrase('religion')) }}
						
						{{ Form::text('religion_name', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Christian',
							'ng-model'=>'religion_name', 

							'ng-pattern'=>getRegexPattern('name'), 

							'required'=> 'true', 

							'ng-class'=>'{"has-error": formReligion.religion_name.$touched && formReligion.religion_name.$invalid}',

							'ng-minlength' => '2',

							'ng-maxlength' => '40',

							)) }}

						<div class="validation-error" ng-messages="formReligion.religion_name.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('pattern')!!}

	    					{!! getValidationMessage('minlength')!!}

	    					{!! getValidationMessage('maxlength')!!}
           
						</div>
 					 
						<div class="buttons text-center">

							<button class="btn btn-lg btn-primary button"

							ng-disabled='!formReligion.$valid'>{{ $button_name }}</button>

						</div>

		 