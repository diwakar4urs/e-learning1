                   <fieldset class="form-group">
						
						{{ Form::label('category_name', getphrase('category_name')) }}
						
						{{ Form::text('category_name', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'EBC',
							'ng-model'=>'category_name', 

							'ng-pattern'=>getRegexPattern('name'), 

							'required'=> 'true', 

							'ng-class'=>'{"has-error": formReligion.category_name.$touched && formReligion.category_name.$invalid}',

							'ng-minlength' => '1',

							'ng-maxlength' => '40',

							)) }}

						<div class="validation-error" ng-messages="formReligion.category_name.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('pattern')!!}

	    					{!! getValidationMessage('minlength')!!}

	    					{!! getValidationMessage('maxlength')!!}
           
						</div>
 					 
						<div class="buttons text-center">

							<button class="btn btn-lg btn-primary button"

							ng-disabled='!formReligion.$valid'>{{ $button_name }}</button>

						</div>

		 