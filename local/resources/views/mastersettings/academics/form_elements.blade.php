 			<fieldset class="form-group">
				
				{{ Form::label('academic_year_title', getphrase('academic_title')) }}
				<span class="text-red">*</span>
				
				{{ Form::text('academic_year_title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '2016-2017 CSE',

					         'ng-model'=>'academic_year_title', 

							'required'=> 'true', 

							'ng-class'=>'{"has-error": formAcademics.academic_year_title.$touched && formAcademics.academic_year_title.$invalid}',

							'ng-minlength' => '4',

							'ng-maxlength' => '40',

							)) }}

						<div class="validation-error" ng-messages="formAcademics.academic_year_title.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('minlength')!!}

	    					{!! getValidationMessage('maxlength')!!}
           
						</div>
			</fieldset>

			<div class="row">
				 <fieldset class="form-group col-md-6">
				
					{{ Form::label('academic_start_date', getphrase('start_date')) }}

						<span class="text-red">*</span>
				 
                   {{ Form::text('academic_start_date', null , $attributes = array('class'=>'form-control', 'placeholder' => '2015/7/17', 'id'=>'dp1',

                   	          'ng-model'=>'academic_start_date', 

							)) }}
 

			</fieldset>

			 					 <fieldset class="form-group col-md-6">
				
				{{ Form::label('academic_end_date', getphrase('end_date')) }}
				
				<span class="text-red">*</span>
					 
				{{ Form::text('academic_end_date', null , $attributes = array('class'=>'form-control', 'placeholder' => '2015/7/17', 'id'=>'dp2',

					          'ng-model'=>'academic_end_date', 

							
							)) }}

                       </fieldset>

			<fieldset class='form-group col-md-6 '>
                        {{ Form::label('show_in_list', getphrase('show_in_list')) }}
                        <div class="form-group row ">
                            <div class="col-md-6 helper_step1">
                          {{ Form::radio('show_in_list', 0, true, array('id'=>'free1', 'name'=>'show_in_list')) }}
								
								<label for="free1"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('No')}}</label> 
                            </div>
                            <div class="col-md-6">
                            {{ Form::radio('show_in_list', 1, false, array('id'=>'paid1', 'name'=>'show_in_list')) }}
								<label for="paid1"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('Yes')}} </label>
                            </div>
                        </div>
                    </fieldset>

			</div>
				 
				<div class="buttons text-center">

							<button class="btn btn-lg btn-primary button"

							ng-disabled='!formAcademics.$valid'>{{ $button_name }}</button>

						</div>

		 