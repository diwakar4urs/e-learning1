 					<div class="row">

 					 <fieldset class="form-group col-md-6">

						

						{{ Form::label('title', getphrase('title')) }}

						<span class="text-red">*</span>

						{{ Form::text('title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('series_title'),

							'ng-model'=>'title',
							'id'=>'title' ,

							'ng-pattern'=>getRegexPattern('name'), 

							'required'=> 'true', 

							'ng-class'=>'{"has-error": formLms.title.$touched && formLms.title.$invalid}',

							'ng-minlength' => '2',

							'ng-maxlength' => '60',

							)) }}

						<div class="validation-error" ng-messages="formLms.title.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('pattern')!!}

	    					{!! getValidationMessage('minlength')!!}

	    					{!! getValidationMessage('maxlength')!!}

						</div>

					</fieldset>

					<fieldset class="form-group col-md-6" >

						{{ Form::label('lms_category_id', 'LMS Category') }}

						<span class="text-red">*</span>

						{{Form::select('lms_category_id', $categories, null, ['placeholder' => getPhrase('select'),'class'=>'form-control', 

						       'ng-model'=>'lms_category_id',

						       'id'=>'lms_category_id' ,
  
							   'required'=> 'true', 

							   'ng-class'=>'{"has-error": formLms.lms_category_id.$touched && formLms.lms_category_id.$invalid}',
                           ]) }}

						<div class="validation-error" ng-messages="formLms.lms_category_id.$error" >

	    					{!! getValidationMessage()!!}

						</div>
                     </fieldset>
                   </div>
             
             <div  class="row">

                  <?php $payment_options = array('1'=>'Paid', '0'=>'Free');?>

					 <fieldset class="form-group col-md-6" >

						{{ Form::label('is_paid', getphrase('is_paid')) }}

						<span class="text-red">*</span>

						{{Form::select('is_paid', $payment_options, null, ['class'=>'form-control', 

						    'ng-model'=>'is_paid',

                            'id'=>'is_paid' ,

							'required'=> 'true', 

							 'ng-class'=>'{"has-error": formLms.is_paid.$touched && formLms.is_paid.$invalid}',
                            ]) }}

						<div class="validation-error" ng-messages="formLms.is_paid.$error" >

	    					{!! getValidationMessage()!!}

						</div>
                  </fieldset>
                   <div ng-if="is_paid==1">

	  				 <fieldset class="form-group col-md-3">

							

							{{ Form::label('validity', getphrase('validity')) }}

							<span class="text-red">*</span>

							{{ Form::text('validity', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('validity_in_days'),

							'ng-model'=>'validity',

							'min'     =>'-1',
                            'required'=> 'true',
                            'id'=>'validity' , 

							'ng-class'=>'{"has-error": formLms.validity.$touched && formLms.validity.$invalid}',

							 

							)) }}

						<div class="validation-error" ng-messages="formLms.validity.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('number')!!}

						</div>

					</fieldset>	

	  				 <fieldset class="form-group col-md-3">

						

						{{ Form::label('cost', getphrase('cost')) }}

						<span class="text-red">*</span>

						{{ Form::text('cost', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '40',

							'min'=>'0',

						'ng-model'=>'cost',

						'id'=>'cost' , 

						'required'=> 'true', 

						'ng-class'=>'{"has-error": formLms.cost.$touched && formLms.cost.$invalid}',

							 

							)) }}

						<div class="validation-error" ng-messages="formLms.cost.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('number')!!}

						</div>

				</fieldset>

				</div>

				</div>

				<div class="row">

				 <fieldset class="form-group col-md-6">

							{{ Form::label('total_items', getphrase('total_items')) }}

							<span class="text-red">*</span>

							{{ Form::text('total_items', $value = null , $attributes = array('class'=>'form-control','readonly'=>'true' ,'placeholder' => getPhrase('It will be updated by adding the LMS items'))) }}

					</fieldset>

                <fieldset class="form-group col-md-4" >

				   {{ Form::label('image', getphrase('image')) }}

				         <input type="file" class="form-control" name="image" 
				          accept=".png,.jpg,.jpeg" id="image_input">

				          

				         <div class="validation-error" ng-messages="formCategories.image.$error" >

	    					{!! getValidationMessage('image')!!}

    				 </div>

				    </fieldset>

                    <fieldset class="form-group col-md-2" >

					@if($record)

				   		@if($record->image)

				         <?php $examSettings = getExamSettings(); ?>

				         <img src="{{ IMAGE_PATH_UPLOAD_LMS_SERIES.$record->image }}" height="100" width="100" >

                       @endif

				     @endif

				    </fieldset>

			    </div>

             <div class="row input-daterange" id="dp">
				<?php 
				$date_from = date('Y/m/d');
				$date_to = date('Y/m/d');
				if($record)
				{
					$date_from = $record->start_date;
					$date_to = $record->end_date;
				}
				 ?>
				 <fieldset class="form-group col-md-6">
					{{ Form::label('start_date', getphrase('start_date')) }}
					{{ Form::text('start_date', $value = $date_from , $attributes = array('class'=>'input-sm form-control', 'placeholder' => '2015/7/17','id'=>'start_date')) }}
				</fieldset>

				<fieldset class="form-group col-md-6">
					{{ Form::label('end_date', getphrase('end_date')) }}
					{{ Form::text('end_date', $value = $date_to , $attributes = array('class'=>'input-sm form-control', 'placeholder' => '2015/7/17','id'=>'end_date')) }}
				</fieldset>
			</div>

 					<div class="row">

					<fieldset class="form-group  col-md-6 helper_step1">

						

						{{ Form::label('short_description', getphrase('short_description')) }}

						

						{{ Form::textarea('short_description', $value = null , $attributes = array('class'=>'form-control ckeditor', 'rows'=>'5', 'placeholder' => getPhrase('short_description'))) }}

					</fieldset>

					<fieldset class="form-group  col-md-6 helper_step2">

						

						{{ Form::label('description', getphrase('description')) }}

						

						{{ Form::textarea('description', $value = null , $attributes = array('class'=>'form-control ckeditor', 'rows'=>'5', 'placeholder' => getPhrase('description'))) }}

					</fieldset>
                      </div>

						<div class="buttons text-center">

							<button class="btn btn-lg btn-primary button"

							ng-disabled='!formLms.$valid'>{{ $button_name }}</button>

						</div>

		 