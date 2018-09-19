<?php $new_tab_active = '';


	if($tab_active=='general')
		$new_tab_active = ' in active';

	 
 ?>

<div id="academic_details" class="tab-pane fade {{$new_tab_active}}">
								{{ Form::model($record, 
						array('url' => ['student/profile/edit/general', $userRecord->slug], 
						'method'=>'patch')) }}
									<h3>{{ getPhrase('admission_details')}}</h3>
									  

									  <div class="alert alert-info">
  <strong>{{getPhrase('info')}} ! </strong>{{ getPhrase('once_saved_the_admission_details_cannot_be_edited
') }}</div>
								 
                  <div class="row">
						<fieldset class="form-group col-md-4">
							{{ Form::label('admission_no', getphrase('admission_no')) }}
							<span class="text-red">*</span>
							{{ Form::text('admission_no', $value = null , $attributes = array('class'=>'form-control','readonly'=>'true', 'placeholder' => 'STU1')) }}
						</fieldset>

						<fieldset class="form-group col-md-4">
							{{ Form::label('roll_no', getphrase('roll_no')) }}
							<span class="text-red">*</span>
							{{ Form::text('roll_no', $value = null , $attributes = array('class'=>'form-control','readonly'=>'true', 'placeholder' => 'Auto-Generated')) }}
						</fieldset>

						@if($join_date=='')

						<fieldset class="form-group col-md-4">
					 
							{{ Form::label('date_of_join', getphrase('date_of_join')) }}
							<span class="text-red">*</span>
							<div class="input-group date" data-date="{{date('Y/m/d')}}" data-provide="datepicker" data-date-format="{{getDateFormat()}}">
							{{ Form::text('date_of_join', $value = date('Y/m/d') , $attributes = array('class'=>'form-control', 'placeholder' => '2015/7/17', 'id'=>'dp')) }}
								<div class="input-group-addon">
									<span class="mdi mdi-calendar"></span>
								</div>
							</div>
						</fieldset>
						@else
                         <fieldset class="form-group col-md-4">
					 
							{{ Form::label('date_of_join', getphrase('date_of_join')) }}
							<span class="text-red">*</span>
							
							{{ Form::text('date_of_join', $value =$join_date , $attributes = array('class'=>'form-control', 'placeholder' => '2015/7/17', 'id'=>'dp','readonly'=>true)) }}
								
						</fieldset>

						@endif
						

						@if($record->roll_no!=''||$record->academic_id!=0 ||$record->course_parent_id!=0||$record->course_id!=0)
						<fieldset class="form-group col-md-4">
							{{ Form::label('academic_year', getphrase('academic_year')) }}
							<span class="text-red">*</span>
							{{ Form::text('academic_id', $value = $join_academicTitle->academic_year_title , $attributes = array('class'=>'form-control','readonly'=>'true')) }}
						</fieldset>

						<fieldset class="form-group col-md-4">
							{{ Form::label('branch', getphrase('branch')) }}
							<span class="text-red">*</span>
							{{ Form::text('course_parent_id', $value = $join_parentName->course_title , $attributes = array('class'=>'form-control','readonly'=>'true')) }}
						</fieldset>

						@if($record->roll_no)
						<fieldset class="form-group col-md-4">
							{{ Form::label('course', getphrase('course')) }}
							<span class="text-red">*</span>
							{{ Form::text('course_id', $value = $join_courseName->course_title , $attributes = array('class'=>'form-control','readonly'=>'true')) }}
						</fieldset>
						@endif
						<?php if($course_time->course_dueration>1){ ?>
						<div>
						<fieldset class="form-group col-md-4">
							{{ Form::label('year', getphrase('year')) }}
							<span class="text-red">*</span>
							{{ Form::text('current_year', $value = $join_year , $attributes = array('class'=>'form-control','readonly'=>'true')) }}
						</fieldset>
						</div>
						<?php 

						if($record->current_semister){?>
						<div>
						<fieldset class="form-group col-md-4">
							{{ Form::label('semister', getphrase('semister')) }}
							<span class="text-red">*</span>
							{{ Form::text('current_semister', $value = $join_semister , $attributes = array('class'=>'form-control','readonly'=>'true')) }}
						</fieldset>
						</div>
						<?php }?>
						
						<?php }?>
						@endif
						</div>
						<br>
						<div class="col-md-12">
						<h3>{{ getPhrase('present_academic_details')}}</h3>
					</div>
                     @if($record->academic_id!=0||$record->course_parent_id!=0||$record->course_id!=0)
					
						<div class="row">
							<fieldset class="form-group col-md-4">
							{{ Form::label('academic_year', getphrase('current_academic_year')) }}
							<span class="text-red">*</span>
							{{ Form::text('academic_id', $value = $academic_title->academic_year_title , $attributes = array('class'=>'form-control','readonly'=>'true')) }}
						</fieldset>
						<fieldset class="form-group col-md-4">
							{{ Form::label('branch', getphrase('current_branch')) }}
							<span class="text-red">*</span>
							{{ Form::text('course_parent_id', $value = $course_parent_name->course_title , $attributes = array('class'=>'form-control','readonly'=>'true')) }}
						</fieldset>
						<fieldset class="form-group col-md-4">
							{{ Form::label('course', getphrase('current_course')) }}
							<span class="text-red">*</span>
							{{ Form::text('course_id', $value = $course_name->course_title , $attributes = array('class'=>'form-control','readonly'=>'true')) }}
						</fieldset>

						@if(!empty($record->roll_no))

						<?php

						 if($course_time->course_dueration>1 && $year!=-1 && $semister!=-1){ 
							
							?>
						<div>
						<fieldset class="form-group col-md-4">
							{{ Form::label('year', getphrase('current_year')) }}
							<span class="text-red">*</span>
							{{ Form::text('current_year', $value = $year , $attributes = array('class'=>'form-control','readonly'=>'true')) }}
						</fieldset>
						</div>
						<?php 

				 
						if($record->current_semister!=0){
							?>
						<div>
						<fieldset class="form-group col-md-4">
							{{ Form::label('semister', getphrase('current_semister')) }}
							<span class="text-red">*</span>
							{{ Form::text('current_semister', $value = $semister , $attributes = array('class'=>'form-control','readonly'=>'true')) }}
						</fieldset>
						
						</div>
						<?php }
						?>

						<?php }?>
						@endif
						<?php if($year==-1 && $semister==-1){ ?>
						<div >
						<fieldset class="form-group col-md-4" >
							{{ Form::label('status', getphrase('status')) }}
							<span class="text-red">*</span>
							{{ Form::text('status', $value = 'Completed' , $attributes = array('class'=>'form-control','readonly'=>'true')) }}
						</fieldset>
						
						</div>
						<?php }?>
						</div>
						 
						 @else
						<div class="col-md-6 col-md-offset-4">
						 @include('common.year-selection-view')
					
						</div>
						
					@endif

                    <br>
					
					<div class="row">
					<div class="col-md-12">
						<h3>{{ getPhrase('previous_educational_details')}}</h3>
					</div>
						<fieldset class="form-group col-md-4">
							{{ Form::label('previous_highest_qualification', getphrase('highest_qualification')) }}
							{{ Form::text('previous_highest_qualification', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'PG')) }}
						</fieldset>
						
						<fieldset class="form-group col-md-4">
							{{ Form::label('previous_highest_qualification_percentage', getphrase('percentage')) }}
							{{ Form::text('previous_highest_qualification_percentage', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '85.9')) }}
						</fieldset>

						<fieldset class="form-group col-md-4">
							{{ Form::label('year_passing', getphrase('year_passed')) }}
							{{ Form::text('year_passing', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '2016')) }}
						</fieldset>

						<fieldset class="form-group col-md-6">
							{{ Form::label('previous_institute_name', getphrase('previous_institute_name')) }}
							{{ Form::textarea('previous_institute_name', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => 'Stanford University')) }}
						</fieldset>

						<fieldset class="form-group col-md-6">
							{{ Form::label('previous_institute_address', getphrase('institute_address')) }}
							{{ Form::textarea('previous_institute_address', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => '450 Serra Mall, Stanford, CA 94305, United States')) }}
						</fieldset>

						 
					</div>

					<div class="buttons text-center">
						<button type="submit" class="btn btn-lg btn-primary button">{{getPhrase('update')}}</button>
					</div>

				{!! Form::close() !!}
			</div>

