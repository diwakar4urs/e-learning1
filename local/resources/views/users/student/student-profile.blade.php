<div class="panel panel-profile-details">
				 
					<div class="panel-body">
						<div class="profile-details text-center">
							<div class="profile-img"><img src="{{ getProfilePath($user->image,'profile')}}" alt=""></div>
							<div class="aouther-school">
								<h2>{{ $student->first_name.' '.$student->middle_name.' '.$student->last_name}}</h2>
								<p><span>{{$student->roll_no}}</span></p>

							</div>

						</div>
						<hr>
						<h3 class="profile-details-title">{{ getPhrase('general_info')}}</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('admission_no')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$student->admission_no}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('academic_year')}}</label>
									</div>
									<div class="col-md-6"><strong>{{ App\Academic::find($student->academic_id)->academic_year_title}}</strong></div>
								</div>
							</div>
							
						</div>
						
						<h3 class="profile-details-title">{{getPhrase('personal_details')}}</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('first_name')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$student->first_name}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('middle_name')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$student->middle_name}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('last_name')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$student->last_name}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('date_of_birth')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$student->date_of_birth}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('gender')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$student->gender}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('blood_group')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$student->blood_group}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('fathers_name')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$student->fathers_name}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('mothers_name')}}</label>
									</div>
									<div class="col-md-6"><strong>{{ $student->mothers_name }}</strong></div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('mother_tongue')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$student->mother_tongue}}</strong></div>
								</div>
							</div>
							<?php $cat = App\Category::where('id','=',$student->category_id)->get()->first(); ?>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('category')}}</label>
									</div>
									<div class="col-md-6"><strong>{{ 
									($cat) ? $cat->category_name : '' }}</strong></div>
								</div>
							</div>
						</div>
						 

						<h3 class="profile-details-title">{{ getPhrase('contact_details') }}</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('address_lane1')}}</label>
									</div>
									<div class="col-md-6"><strong>{{ $student->address_lane1}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('address_lane2')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$student->address_lane2 }}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('city')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$student->city}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('state')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$student->state}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('zipcode')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$student->zipcode}}</strong></div>
								</div>
							</div>
							<?php $country = DB::Table('countries')
							               ->where('country_code','=',$student->country)
							               ->first();
							                ?>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('country')}}</label>
									</div>
									<div class="col-md-6"><strong>{{($country) ? $country->country_name : ''}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('mobile')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$student->mobile}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('home_phone')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$student->home_phone}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('email')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$user->email}}</strong></div>
								</div>
							</div>
						</div>


						<h3 class="profile-details-title">Class & Batch Details</h3>
						<div class="row">
							<?php $course = new App\Course(); ?>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('branch')}}</label>
									</div>
									<div class="col-md-6"><strong>{{ $course->getCourseRecord($student->course_parent_id)->course_title }}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('course')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$course->getCourseRecord($student->course_id)->course_title}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{ getPhrase('roll_no')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$student->roll_no}}</strong></div>
								</div>
							</div>

						</div>
 
					</div>
				</div>
			