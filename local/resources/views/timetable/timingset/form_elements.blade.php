 					 
 					 <fieldset class="form-group">
						
						{{ Form::label('name', getphrase('category_name')) }}
						<span class="text-red">*</span>
						{{ Form::text('name', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('enter_category_name'),
							'ng-model'=>'name1',
							'id'=>'name' ,
							'required'=> 'true', 
							'ng-class'=>'{"has-error": formTimingset.name.$touched && formTimingset.name.$invalid}',
							 
							)) }}
							<div class="validation-error" ng-messages="formTimingset.name.$error" >
	    					{!! getValidationMessage()!!}
	    					 
						</div>
						<fieldset class="form-group">
						
						{{ Form::label('description', getphrase('description')) }}
						
						{{ Form::textarea('description', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => 'Timetable Description','id'=>'description')) }}
					</fieldset>
					
					</fieldset>
 			 		<div class="row">
 					  <fieldset class="form-group col-md-4">
						
						{{ Form::label('name', getphrase('period_name')) }}
						
						{{ Form::text('period_name', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('period_name'),
							 'ng-model'=>'source.name','id'=>'period_name'
							)) }}

					</fieldset>

					<?php 
					$start_time = getSetting('start_time', 'time_table');
					$end_time = getSetting('end_time', 'time_table');
					?>
 					  <fieldset class="form-group col-md-2">
						
						{{ Form::label('start_time', getphrase('start_time')) }}
						
						<select name="start_time" ng-model="source.start_time" class="form-control" id="start_time">
						@for($time=$start_time; $time<=$end_time; $time++)
						@for($interval=0; $interval<60; $interval +=5)
						
						<option value="{{makeNumber($time)}}:{{makeNumber($interval)}}:00">{{makeNumber($time)}}:{{makeNumber($interval)}}</option>
						
						@endfor
						@endfor
						</select>

					</fieldset>

					  <fieldset class="form-group col-md-2">
						
						{{ Form::label('end_time', getphrase('end_time')) }}
						<?php 
						$start_time = getSetting('start_time','time_table');
						$end_time = getSetting('end_time','time_table');
						?>
						<select name="end_time" ng-model="source.end_time" class="form-control" id="end_time">
						@for($time=$start_time; $time<=$end_time; $time++)
						@for($interval=0; $interval<60; $interval +=5)
						
						<option value="{{makeNumber($time)}}:{{makeNumber($interval)}}:00">{{makeNumber($time)}}:{{makeNumber($interval)}}</option>
						
						@endfor
						@endfor
						</select>

					</fieldset>

					  <fieldset class="form-group col-md-2">
					  <label>Is Break?</label><br>
						 	<div class="checkbox custom-checkbox helper_step8">
								    <label>
									 
								    <input  ng-model="source.is_break" type="checkbox">
								    

								    
								    <div class="item-checkbox">								    	
								    	<i class="fa fa-check checked" aria-hidden="true"></i>
								    </div>
								    </label>
								  </div>
					 
 
					</fieldset>

		<fieldset class="form-group col-md-2">
						<p>&nbsp;</p>
					<a href="javascript:void(0);" ng-click="addToList(source)" class="btn btn-lg btn-primary button helper_step7"> Add </a>
					</fieldset>
					</div>	
					
						<div class="buttons text-center">
							<button class="btn btn-lg btn-success button"
							 ng-disabled='!formTimingset.$valid'>{{ $button_name }}</button>
						</div>
		 