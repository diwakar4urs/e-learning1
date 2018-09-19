 					
 					 <fieldset class="form-group">
						
						{{ Form::label('author', getphrase('author_name')) }}
						<span class="text-red">*</span>
						{{ Form::text('author', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Jack',

							'ng-model'=>'author', 

							'ng-pattern'=>getRegexPattern('name'), 

							'required'=> 'true', 

							'ng-class'=>'{"has-error": formauthors.author.$touched && formauthors.author.$invalid}',

							'ng-minlength' => '2',

							'ng-maxlength' => '20',

							)) }}

						<div class="validation-error" ng-messages="formauthors.author.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('pattern')!!}

	    					{!! getValidationMessage('minlength')!!}

	    					{!! getValidationMessage('maxlength')!!}
           
						</div>
					</fieldset>
 					 <div class="row helper_step1">
 					<fieldset class='form-group col-md-6'>
						{{ Form::label('gender', getphrase('gender')) }}
						<span class="text-red">*</span>
						<div class="form-group row">
							<div class="col-md-6">
							{{ Form::radio('gender', 'male', true, array('id'=>'free', 'ng-model' => 'fine_eligiblity' )) }}
								
								<label for="free"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('Male')}}</label> 
							</div>
							<div class="col-md-6">
							{{ Form::radio('gender', 'female', false, array('id'=>'paid', 
							'ng-model' => 'fine_eligiblity')) }}
								<label for="paid"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('Female')}} </label>
							</div>
						</div>
					</fieldset>
				</div>
					<fieldset class="form-group">
						
						{{ Form::label('description', getphrase('description')) }}
						
						{{ Form::textarea('description', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => 'Fine description')) }}
					</fieldset>
						
					</fieldset>
						
						<div class="buttons text-center">

							<button class="btn btn-lg btn-primary button"

							ng-disabled='!formauthors.$valid'>{{ $button_name }}</button>

						</div>
		 