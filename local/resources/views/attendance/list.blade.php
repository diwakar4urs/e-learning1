@extends($layout)
@section('header_scripts')
<link href="{{CSS}}ajax-datatables.css" rel="stylesheet">
@stop
@section('content')


<div id="page-wrapper" ng-controller="attendanceController" ng-init="initAngData('{{count($students)}}');">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
                         @if($role_name!='staff')
                        <li><a href="{{URL_ACADEMICOPERATIONS_DASHBOARD}}">
                            {{getPhrase('academic_operations')}}</a></li>
                        @endif
                         <li><a href="{{URL_STUDENT_ATTENDENCE.Auth::user()->slug}}">{{getphrase('particulars')}}</a></li>
                        
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
								
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
					<div class="row">
						<div class="col-sm-8">
						<?php 
						$title = $submitted_data->course_record->course_title;

						?>
						<h1>{{ getPhrase('attendance_for').' '.$submitted_data->academic_title->academic_year_title.' '.$title }}</h1>
						<p><strong>{{ getPhrase('date').' '.$submitted_data->attendance_date }}</strong></p>

						</div>
						 
						<div class="col-sm-4 text-right">
						<ul class="list-unstyled attendance_summary">
							<li class="clearfix">
								<p class="pull-left"><strong>Total:</strong> @{{total}}</p>
								<p class="pull-right"><strong>Present:</strong> @{{present}}</p>
							</li>
							<li class="clearfix">
								<p class="pull-left text-danger"><strong>Absent:</strong> @{{absent}}</p>
								<p class="pull-right"><strong>Leave:</strong> @{{leave}}</p>
							</li>
						</ul>
							<span >
							
						</span>		
						</div>
					</div>
						
						
						
						
					</div>
					<?php 
					?>
					{!! Form::open(array('url' => URL_STUDENT_ATTENDENCE_UPDATE.$userdata->slug, 'method' => 'POST')) !!}
					
					<input type="hidden" name="academic_id" value="{{$submitted_data->academic_id}}">
					<input type="hidden" name="course_id" value="{{$submitted_data->course_record->id}}">

					<input type="hidden" name="subject_id" value="{{$submitted_data->subject_id}}">
					<input type="hidden" name="total_class" value="{{$submitted_data->total_class}}">
					<input type="hidden" name="record_updated_by" value="{{$submitted_data->updated_by}}">

					<input type="hidden" name="current_year" value="{{$submitted_data->current_year}}">
					<input type="hidden" name="current_semister" value="{{$submitted_data->current_semister}}">
					<input type="hidden" name="attendance_date" value="{{$submitted_data->attendance_date}}">
					<input type="hidden" name="attendance_taken" value="{{$attendance_taken}}">

					<div class="panel-body packages" id="myForm">
						<div class="table-responsive vertical-scroll"> 
						<table class="table table-striped table-bordered student-attendance-table datatable" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>{{ getPhrase('sno')}}</th>
									<th>{{ getPhrase('roll_no')}}</th>
									<th>{{ getPhrase('photo')}}</th>
									<th>{{ getPhrase('name')}}</th>
									<th>{{ getPhrase('attendance')}}</th>
									<th>{{ getPhrase('remarks')}}</th>
									<th>{{ getPhrase('notes')}}</th>
								</tr>
							</thead>
							<?php $sno = 1; ?>
							@foreach($students as $student)
							<?php $user = $student->user()->first(); ?>
							<tr>
								<td>{{ $sno++ }}</td>
								<td>{{ $student->roll_no }}</td>
								<td><img src="{{getProfilePath($user->image)}}"> </td>
								<td>{{ $student->first_name }}</td>
								<td>
									<div class="col-md-4">

									<?php 
									$present = true;
									$absent = false;
									$leave = false;
									$remarks = '';
									$notes = '';
									if($attendance_taken) { 
										foreach($attendance_records as $atr)
										{	

											if($student->id == $atr->student_id)
											{
												$present 	= false;
												$absent 	= false;
												$leave 		= false;
												$notes = $atr->notes;
												$remarks = $atr->remarks;
												switch ($atr->attendance_code) {
													case 'P':
															$present = true;
														break;
													case 'A':
															$absent = true;
														break;
													case 'L':
															$leave = true;
														break;
													
													default:
														$present = true;
														break;
												}
												break;
											}
										}
									 } ?>

							{{ Form::radio('attendance_code', 'P', $present, array(
								'id'=>'present'.$student->id,
								'name'=>'attendance_code['.$student->id.']',
								'ng-click' => 'updateCount()',
								'class' => 'attendance_code'
							)) }}
								
								<label for="present{{$student->id}}"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('present')}}</label> 
							</div>
							<div class="col-md-4">
							{{ Form::radio('attendance_code', 'A', $absent, array('id'=>'absent'.$student->id, 'name'=>'attendance_code['.$student->id.']',
								'ng-click' => 'updateCount()'
							)) }}
								<label for="absent{{$student->id}}"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('absent')}} </label>
							</div>
							<div class="col-md-4">
							{{ Form::radio('attendance_code', 'L', $leave, array('id'=>'leave'.$student->id, 'name'=>'attendance_code['.$student->id.']',
							'ng-click' => 'updateCount()'
							)) }}
								<label for="leave{{$student->id}}"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('leave')}} </label>
							</div>
								</td>
								<td>
									<fieldset class="form-group">
									 {{ Form::textarea('remarks', $remarks , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('remarks'), 'rows'=>1, 'cols'=>15, 'name'=>'remarks['.$student->id.']')) }}										 
									</fieldset>
								</td>
								<td>
									<fieldset class="form-group">
									 {{ Form::textarea('notes', $notes , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('notes'), 'rows'=>1, 'cols'=>15, 'name'=>'notes['.$student->id.']')) }}
										 
									</fieldset>
								</td>
							</tr>

							@endforeach
						</table>
						</div>
						<div class="buttons text-center">
							<button class="btn btn-lg btn-primary button">{{ getPhrase('update') }}</button>
						</div>
					</div>
					</form>
				</div>

			</div>
			<!-- /.container-fluid -->
		</div>
@endsection
 

@section('footer_scripts')
  
@include('attendance.scripts.attendance-script') 

@stop
