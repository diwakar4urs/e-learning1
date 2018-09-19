				

					<div class="row">

 					 <fieldset class="form-group col-md-6">

						{{ Form::label('title', getphrase('title')) }}

						<span class="text-red">*</span>

						{{ Form::text('title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('title'),

							'ng-model'=>'title', 

							'ng-pattern'=>getRegexPattern('name'), 

							'required'=> 'true', 

							'ng-class'=>'{"has-error": formQuiz.title.$touched && formQuiz.title.$invalid}',

							'ng-minlength' => '4',

							'ng-maxlength' => '20',

							)) }}

						<div class="validation-error" ng-messages="formQuiz.title.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('pattern')!!}

	    					{!! getValidationMessage('minlength')!!}

	    					{!! getValidationMessage('maxlength')!!}
           
						</div>

					</fieldset>

					<fieldset class="form-group col-md-6">

						<?php $holiday_types = array('date' => getPhrase('date'), 'day' => getPhrase('day'), );?>

						{{ Form::label('type', getphrase('holiday_type')) }}

						<span class="text-red">*</span>

						{{Form::select('type', $holiday_types, null, 
						[
							'class'    => 'form-control',
							'ng-model' => 'holiday_type'

						])}}

						

					</fieldset> 

					 

				 </div>

				 <div ng-show="holiday_type=='day'" class="row">

					 <fieldset class="form-group col-md-6">

						<?php $days = getDay($dayNumber=-1);?>
						

						{{ Form::label('day', getphrase('select_day')) }}

						<span class="text-red">*</span>

						{{Form::select('day', $days,null, ['class'=>'form-control'])}}


					</fieldset>


					</div>

 			<div ng-show="holiday_type=='date'" class="row input-daterange" id="dp">

		 	<?php 

		 	$date_from = date('Y/m/d');

		 	$date_to = date('Y/m/d');

		 	if($record)

		 	{

		 		$date_from = $record->date_from;

		 		$date_to = $record->date_to;

		 	}

		 	 ?>

  				 <fieldset class="form-group col-md-6">

                        {{ Form::label('date_from', getphrase('date_from')) }}
                        {{ Form::text('date_from', $value = $date_from , $attributes = array('class'=>'input-sm form-control', 'placeholder' => '2015/7/17')) }}

                        </fieldset>

                   <fieldset class="form-group col-md-6">
                {{ Form::label('date_to', getphrase('date_to')) }}

                       {{ Form::text('date_to', $value = $date_to , $attributes = array('class'=>'input-sm form-control', 'placeholder' => '2015/7/17')) }}
 
                     

                        </fieldset>

				</div>

                 <div class="row">

					 <fieldset class="form-group">
						
						{{ Form::label('reason', getphrase('reason')) }}
						
						{{ Form::textarea('reason', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => 'reason')) }}
					</fieldset>

					</fieldset>

                       </div>

						<div class="buttons text-center">

							<button class="btn btn-lg btn-success button"

							ng-disabled='!formQuiz.$valid'>{{ $button_name }}</button>

						</div>

		 