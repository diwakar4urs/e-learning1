<?php $new_tab_active = '';

	if($tab_active=='general')
		$new_tab_active = ' in active';
 ?>
<div id="academic_details" class="tab-pane fade {{$new_tab_active}}">
				{{ Form::model($record, 
		array('url' => ['staff/profile/edit/general', $record->id], 
		'method'=>'patch')) }}
					<h3>{{ getPhrase('general_details')}}</h3>
	<div class="row">
		<fieldset class="form-group col-md-6">
			{{ Form::label('staff_id', getphrase('staff_id')) }}
			<span class="text-red">*</span>
			{{ Form::text('staff_id', $value = null , $attributes = array('class'=>'form-control','readonly'=>'true', 'placeholder' => 'EMP1')) }}
		</fieldset>

		@if($join_date==null)

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
	</div>
	<div class="row">
          @if($record->course_parent_id!=0 && $record->course_id!=0)

	    <fieldset class="form-group col-md-4">
			{{ Form::label('branch', getphrase('branch')) }}
			<span class="text-red">*</span>
			{{ Form::text('branch', $value =$course_parent_name, $attributes = array('class'=>'form-control','readonly'=>'true')) }}
		</fieldset>

		<fieldset class="form-group col-md-4">
			{{ Form::label('course', getphrase('course')) }}
			<span class="text-red">*</span>
			{{ Form::text('course', $value =$course_name , $attributes = array('class'=>'form-control','readonly'=>'true')) }}
		</fieldset>

		<fieldset class="col-md-4">
		
		<p>&nbsp;&nbsp;</p>
		{{ Form::checkbox('gender', 'male', true, array('id'=>'free','class'=>'form-control' ,'ng-model' => 'edit_details' )) }}
								
		<label for="free"> <span class="fa-stack checkbox-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('edit_branch_and_course')}}</label> 
		</fieldset>

		@endif



		<fieldset class="form-group col-md-6" ng-show="edit_details" >
		{{ Form::label('course_parent_id', getphrase('branch')) }}
			<span class="text-red">*</span>
		{{Form::select('course_parent_id', $courses_parent_list, null, 
		['class'=>'form-control', 
		"id" 	=>"course_parent_id",
		"ng-model"=> "parent_course_id",
		"ng-change"=>"getChildCourses(parent_course_id)"

		]
		)}}

	</fieldset>

		<fieldset class="form-group col-md-6" ng-show="edit_details">
		{{ Form::label('course_id', getphrase('course')) }}
			<span class="text-red">*</span>
			<select 
			class="form-control" 
			name="course_id"
			id = "select_course" 
			ng-model="course_id"
			ng-options="option.id as option.course_title for option in courses track by option.id"
			ng-change="setOption(course_id)"
			>
				</select>
	 
		</fieldset>
 @if($record->course_parent_id==0 && $record->course_id==0)

		<fieldset class="form-group col-md-6" >
		{{ Form::label('course_parent_id', getphrase('branch')) }}
			<span class="text-red">*</span>
		{{Form::select('course_parent_id', $courses_parent_list, null, 
		['class'=>'form-control', 
		"id" 	=>"course_parent_id",
		"ng-model"=> "parent_course_id",
		"ng-change"=>"getChildCourses(parent_course_id)"

		]
		)}}

	</fieldset>

		<fieldset class="form-group col-md-6">
		{{ Form::label('course_id', getphrase('course')) }}
			<span class="text-red">*</span>
			<select 
			class="form-control" 
			name="course_id"
			id = "select_course" 
			ng-model="course_id"
			ng-options="option.id as option.course_title for option in courses track by option.id"
			ng-change="setOption(course_id)"
			>
				</select>
	 
		</fieldset>
@endif
 
		<fieldset class="form-group col-md-6">
				
			{{ Form::label('job_title', getphrase('job_title')) }}
			<span class="text-red">*</span>
			{{ Form::text('job_title', $value = null , $attributes = array('class'=>'form-control','placeholder' => 'System Admin')) }}
		</fieldset>
	 
	</div>
	<h3>{{getPhrase('qualification_details')}}</h3>
	<div class="row">
		<fieldset class="form-group col-md-6">
			{{ Form::label('qualification', getphrase('qualification')) }}
			<span class="text-red">*</span>
			{{ Form::text('qualification', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'MS')) }}
		</fieldset>

		<fieldset class="form-group col-md-3">
			{{ Form::label('experience (Years)', getphrase('experience (Years)')) }}
			<span class="text-red">*</span>
			{{ Form::text('total_experience_years', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '5')) }}
		</fieldset>
		
		<fieldset class="form-group col-md-3">
			{{ Form::label('experience (Months)', getphrase('experience (Months)')) }}
			<span class="text-red">*</span>
			{{ Form::text('total_experience_month', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '5')) }}
		</fieldset>

		<fieldset class="form-group col-md-6">
			{{ Form::label('experience_information', getphrase('experience_information')) }}
			<span class="text-red">*</span>
			{{ Form::textarea('experience_information', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => 'Having good experience in teaching')) }}
		</fieldset>

		<fieldset class="form-group col-md-6">
			{{ Form::label('other_information', getphrase('other_information')) }}
			
			{{ Form::textarea('other_information', $value = null , $attributes = array('class'=>'form-control','rows'=>'5', 'placeholder' => 'Microsoft certified')) }}
		</fieldset>
	</div>

	<div class="buttons text-center">
		<button type="submit" class="btn btn-lg btn-primary button">{{getPhrase('update')}}</button>
	</div>

	{!! Form::close() !!}
</div>