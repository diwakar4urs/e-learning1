 				
				    <fieldset class="form-group">
						{{ Form::label('subject_title', getphrase('subject_title')) }}
						<span class="text-red">*</span>
						{{ Form::text('subject_title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Maths',
							'ng-model'=>'subject_title', 
							'ng-pattern' => getRegexPattern('name'),
							'required'=> 'true', 
							'ng-class'=>'{"has-error": formSubjects.subject_title.$touched && formSubjects.subject_title.$invalid}',
							'ng-minlength' => '2',
							'ng-maxlength' => '60',
						)) }}
						<div class="validation-error" ng-messages="formSubjects.subject_title.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('pattern')!!}
	    					{!! getValidationMessage('minlength')!!}
	    					{!! getValidationMessage('maxlength')!!}
						</div>
					</fieldset>

					<fieldset class="form-group">
						
						{{ Form::label('subject_code', getphrase('subject_code')) }}
						<span class="text-red">*</span>
						{{ Form::text('subject_code', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'M1',
							'ng-model'=>'subject_code', 
							'ng-pattern' => getRegexPattern('name'),
							'required'=> 'true', 
							'ng-class'=>'{"has-error": formSubjects.subject_code.$touched && formSubjects.subject_code.$invalid}',
							'ng-minlength' => '2',
							'ng-maxlength' => '20',
						)) }}
						<div class="validation-error" ng-messages="formSubjects.subject_code.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('pattern')!!}
	    					{!! getValidationMessage('minlength')!!}
	    					{!! getValidationMessage('maxlength')!!}
						</div>
					</fieldset>
					
					 
 
	
					<div class="row">
					<fieldset class='form-group col-md-6 helper_step2'>
						{{ Form::label('is_lab', getphrase('is_lab')) }}
						<div class="form-group row">
							<div class="col-md-6">
							{{ Form::radio('is_lab', 0, true, array('id'=>'free', 'name'=>'is_lab')) }}
								
								<label for="free"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('No')}}</label> 
							</div>
							<div class="col-md-6">
							{{ Form::radio('is_lab', 1, false, array('id'=>'paid', 'name'=>'is_lab')) }}
								<label for="paid"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('Yes')}} </label>
							</div>
						</div>
					</fieldset>
 					
 					 <fieldset class='form-group col-md-6 helper_step3'>
						{{ Form::label('is_elective_type', getphrase('is_elective')) }}
						<div class="form-group row">
							<div class="col-md-6">
							{{ Form::radio('is_elective_type', 0, true, array('id'=>'free1', 'name'=>'is_elective_type')) }}
								
								<label for="free1"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('No')}}</label> 
							</div>
							<div class="col-md-6">
							{{ Form::radio('is_elective_type', 1, false, array('id'=>'paid1', 'name'=>'is_elective_type')) }}
								<label for="paid1"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('Yes')}} </label>
							</div>
						</div>
					</fieldset>
					</div>

                    
					</fieldset>
						<div class="buttons text-center">
							<button class="btn btn-lg btn-primary button" 
							ng-disabled='!formSubjects.$valid'>{{ $button_name }}</button>
						</div>
		 