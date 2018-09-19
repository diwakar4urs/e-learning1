 					<fieldset class="form-group">
						
						{{ Form::label('category_name', getphrase('category_name')) }}
						
						{{ Form::text('title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Test-1',
							'ng-model'=>'title',
							'id'=>'title', 

							'ng-pattern'=>getRegexPattern('name'), 

							'required'=> 'true', 

							'ng-class'=>'{"has-error": formOfflineQuizCategory.title.$touched && formOfflineQuizCategory.title.$invalid}',

							'ng-minlength' => '1',

							'ng-maxlength' => '40',

							)) }}

						<div class="validation-error" ng-messages="formOfflineQuizCategory.title.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('pattern')!!}

	    					{!! getValidationMessage('minlength')!!}

	    					{!! getValidationMessage('maxlength')!!}
           
						</div>
 					 
						<div class="buttons text-center">

							<button class="btn btn-lg btn-success button"

							ng-disabled='!formOfflineQuizCategory.$valid'>{{ $button_name }}</button>

						</div>

		 