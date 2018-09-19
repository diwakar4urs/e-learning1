<div class="panel panel-profile-details">
				 
					<div class="panel-body">
						<div class="profile-details text-center">
							<div class="profile-img"><img src="{{ getProfilePath($user->image,'profile')}}" alt=""></div>
							<div class="aouther-school">
								<h2>{{ ucfirst($staff->first_name).' '.ucfirst($staff->middle_name).' '.ucfirst($staff->last_name)}}</h2>
								<p><span>{{$staff->job_title}}</span> <span>{{$staff->staff_id}}</span></p>

							</div>

						</div>
						<hr>
						<h3 class="profile-details-title">{{ getPhrase('general_info')}}</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{ getPhrase('staff_id') }}</label>
									</div>
									<div class="col-md-6"><strong> {{$staff->staff_id}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">
										{{ getPhrase('date_of_join') }}</label>
									</div>
									<div class="col-md-6"><strong>{{ $staff->date_of_join }}</strong></div>
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
									<div class="col-md-6"><strong>{{$staff->first_name}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('middle_name')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff->middle_name}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('last_name')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff->last_name}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('date_of_birth')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff->date_of_birth}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('gender')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff->gender}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('blood_group')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff->blood_group}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('fathers_name')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff->fathers_name}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('mothers_name')}}</label>
									</div>
									<div class="col-md-6"><strong>{{ $staff->mothers_name }}</strong></div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('mother_tongue')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff->mother_tongue}}</strong></div>
								</div>
							</div>
							<?php $country = DB::Table('countries')->where('country_code','=',$staff->nationality)->first(); ?>

							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('nationality')}}</label>
									</div>
									<div class="col-md-6"><strong>{{($country) ? $country->country_name :''}}</strong></div>
								</div>
							</div>
							
						</div>
						 

						<h3 class="profile-details-title">{{ getPhrase('contact_details') }}</h3>
						<div class="row"><div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('address_lane1')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff->address_lane1}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('address_lane2')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff->address_lane2}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('city')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff->city}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('state')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff->state}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('zipcode')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff->zipcode}}</strong></div>
								</div>
							</div>
							
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
									<div class="col-md-6"><strong>{{$staff->mobile}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('home_phone')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff->home_phone}}</strong></div>
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


						<h3 class="profile-details-title">{{ getPhrase('qualification_details')}}</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('qualification')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff->qualification}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('experience')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff->total_experience_years.' '. getPhrase('years').' '.$staff->total_experience_month.' '.getPhrase('months')}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('experience_information')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff->experience_information}}</strong></div>
									<div class="col-md-6">
										<label for="">{{getPhrase('other_information')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff->other_information}}</strong></div>
								</div>
							</div>

						</div>
 
					</div>
				</div>
			