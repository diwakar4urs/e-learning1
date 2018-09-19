 					<fieldset class="form-group">
						{{ Form::label('parent_id', getphrase('select_parent')) }}

						<span class="text-red">*</span>
						
						{{Form::select('parent_id', $course_parent_list, null, ['class'=>'form-control select2','placeholder'=>'select',
						    
						    'ng-model'=>'parent_id', 

							'required'=> 'true', 

							'ng-class'=>'{"has-error": formCourses.parent_id.$touched && formCourses.parent_id.$invalid}',

							 ])}}

						<div class="validation-error" ng-messages="formCourses.parent_id.$error" >

	    					{!! getValidationMessage()!!}

	    				</div>
					</fieldset>


					 <fieldset class="form-group">
						
						{{ Form::label('course_title', getphrase('course_title')) }}

							<span class="text-red">*</span>

						{{ Form::text('course_title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'MBA',

							'ng-model'=>'course_title', 

							'ng-pattern'=>getRegexPattern('name'), 

							'required'=> 'true', 

							'ng-class'=>'{"has-error": formCourses.course_title.$touched && formCourses.course_title.$invalid}',

							'ng-minlength' => '2',

							'ng-maxlength' => '60',

							)) }}

						<div class="validation-error" ng-messages="formCourses.course_title.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('pattern')!!}

	    					{!! getValidationMessage('minlength')!!}

	    					{!! getValidationMessage('maxlength')!!}
           
						</div>

					</fieldset>

					<fieldset class="form-group">
						
						{{ Form::label('course_code', getphrase('course_code')) }}

						<span class="text-red">*</span>

						{{ Form::text('course_code', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'MBA',

							'ng-model'=>'course_code', 

							'ng-pattern'=>getRegexPattern('name'), 

							'required'=> 'true', 

							'ng-class'=>'{"has-error": formCourses.course_code.$touched && formCourses.course_code.$invalid}',

							'ng-minlength' => '2',

							'ng-maxlength' => '20',

							)) }}

						<div class="validation-error" ng-messages="formCourses.course_code.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('pattern')!!}

	    					{!! getValidationMessage('minlength')!!}

	    					{!! getValidationMessage('maxlength')!!}
           
						</div>

					</fieldset>
					
					<fieldset ng-if="parent_id!=0" class="form-group">
						{{ Form::label('course_duration', getphrase('duration_in_years')) }}
						   
						   <span class="text-red">*</span>

						{{Form::select('course_dueration', 
						array('1'=>1, '2'=>2, '3'=>3, '4',4, '5'=>5,6=>'6','7'=>7,'8'=>8, '9'=>9, '10'=>10), 
						null, ['class'=>'form-control select2',
						'placeholder'=>'select',

						    'ng-model'=>'course_dueration', 
                              'id'    => 'course_duration', 
							
							'required'=> 'true', 

							'ng-class'=>'{"has-error": formCourses.course_dueration.$touched && formCourses.course_dueration.$invalid}'])}}

						<div class="validation-error" ng-messages="formCourses.course_dueration.$error" >

	    					{!! getValidationMessage()!!}

	    					
           
						</div>
					</fieldset>

					<fieldset ng-if="parent_id!=0" class="form-group">
						{{ Form::label('grade_system', getphrase('grade_system')) }}
						
                           <span class="text-red">*</span>

						{{Form::select('grade_system', 
						array('percentage'=> 'Percentage', 'gpa'=>'GPA'), 
						null, ['class'=>'form-control select2' ,
						'placeholder'=>'select',

						    'ng-model'=>'grade_system', 

							
							'required'=> 'true', 

							'ng-class'=>'{"has-error": formCourses.grade_system.$touched && formCourses.grade_system.$invalid}'])}}

						<div class="validation-error" ng-messages="formCourses.grade_system.$error" >

	    					{!! getValidationMessage()!!}

	    					
           
						</div>
					</fieldset>
	
					<div class="row ">
					<fieldset ng-if="parent_id!=0" class='form-group col-md-6 helper_step2'>
						{{ Form::label('is_having_semister', getphrase('is_having_semesters')) }}
						<div class="form-group row">
							<div class="col-md-6">
							{{ Form::radio('is_having_semister', 0, true, array('id'=>'free', 'name'=>'is_having_semister')) }}
								
								<label for="free"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('No')}}</label> 
							</div>
							<div class="col-md-6">
							{{ Form::radio('is_having_semister', 1, false, array('id'=>'paid', 'name'=>'is_having_semister')) }}
								<label for="paid"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('Yes')}} </label>
							</div>
						</div>
					</fieldset>
 					
 					 <fieldset ng-if="parent_id!=0" class='form-group col-md-6 helper_step3'>
						{{ Form::label('is_having_elective_subjects', getphrase('is_having_electives')) }}
						<div class="form-group row">
							<div class="col-md-6">
							{{ Form::radio('is_having_elective_subjects', 0, true, array('id'=>'free1', 'name'=>'is_having_elective_subjects')) }}
								
								<label for="free1"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('No')}}</label> 
							</div>
							<div class="col-md-6">
							{{ Form::radio('is_having_elective_subjects', 1, false, array('id'=>'paid1', 'name'=>'is_having_elective_subjects')) }}
								<label for="paid1"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('Yes')}} </label>
							</div>
						</div>
					</fieldset>
					</div>	

					<fieldset class="form-group helper_step4">
						
						{{ Form::label('description', getphrase('description')) }}
						
						{{ Form::textarea('description', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'description', 'rows'=>'5')) }}
					</fieldset>

					</fieldset>
						<div class="buttons text-center">

							<button class="btn btn-lg btn-primary button"

							ng-disabled='!formCourses.$valid'>{{ $button_name }}</button>

						</div>

		 