<div class="table-responsive"> 
							<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
								<thead>
									<tr>
										 
										<th>{{ getPhrase('subject_title')}}</th>
										<th>{{ getPhrase('subject_code')}}</th>
										<th>{{ getPhrase('maximum_marks')}}</th>
										<th>{{ getPhrase('pass_marks')}}</th>
										<th>{{ getPhrase('is_lab')}}</th>
										<th>{{ getPhrase('is_elective')}}</th>
										<th>{{ getPhrase('action')}}</th>
									</tr>
								</thead>

						<?php $subjects = App\CourseSubject::getCourseSavedSubjects($academic_id, $course_id, $yearno, $semister); ?>

						@foreach($subjects as $subject)
						<?php $subject_record = App\Subject::find($subject->subject_id); ?>
						<tr>
							<td>{{ $subject_record->subject_title }}</td>
							<td>{{ $subject_record->subject_code }}</td>
							<td>{{ $subject_record->maximum_marks }}</td>
							<td>{{ $subject_record->pass_marks }}</td>
							<td>{{ ($subject_record->is_lab) ? getphrase('yes') : getphrase('no') }}</td>
							<td>{{ ($subject_record->is_elective_type) ? getphrase('yes') : getphrase('no') }}</td>
							<td><a href="javascript:void(0);">{{ getphrase('view_topics') }} </a></td>
						</tr>

						@endforeach

						@if(count($subjects)==0)
						<tr>
							<td colspan="7"> {{getphrase('no_subjects_allotted') }} </td>
						</tr>
						@endif
							</table>
						</div>