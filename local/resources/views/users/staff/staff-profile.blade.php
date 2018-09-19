@extends($layout)
@section('content')
<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="{{URL_USERS}}">{{ getPhrase('users')}}</a> </li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')

				<div class="panel panel-profile-details">
					<div class="panel-heading">
						<h1>{{isset($title) ? $title : ''}}</h1>
					</div>
					<div class="panel-body">
						<div class="profile-details text-center">
							<div class="profile-img"><img src="/{{getProfilePath($user_record->image,'profile')}}" alt=""></div>
							<div class="aouther-school">
								<h2>{{ ucfirst($staff_record->first_name).' '.ucfirst($staff_record->middle_name).' '.ucfirst($staff_record->last_name)}}</h2>
								<p><span>{{$staff_record->job_title}}</span></span> <span>{{$staff_record->staff_id}}</span></p>
							</div>

						</div>
						<hr>
						<h3 class="profile-details-title">{{ getPhrase('general_details') }}</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{ getPhrase('staff_id') }}</label>
									</div>
									<div class="col-md-6"><strong> {{$staff_record->staff_id}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">
										{{ getPhrase('date_of_join') }}</label>
									</div>
									<div class="col-md-6"><strong>{{ $staff_record->date_of_join }}</strong></div>
								</div>
							</div>
						</div>

						<h3 class="profile-details-title">{{ getPhrase('personal_details')}}</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">
										{{ getPhrase('first_name') }}</label>
									</div>
									<div class="col-md-6"><strong>{{ $staff_record->first_name}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">
										{{ getPhrase('middle_name') }}</label>
									</div>
									<div class="col-md-6"><strong>
									{{ $staff_record->middle_name }}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{ getPhrase('last_name') }}</label>
									</div>
									<div class="col-md-6"><strong>{{ $staff_record->last_name }}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for=""> 
										{{getPhrase('date_of_birth') }} </label>
									</div>
									<div class="col-md-6"><strong>{{ $staff_record->date_of_birth}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('gender')}}</label>
									</div>
									<div class="col-md-6"><strong>{{ucfirst($staff_record->gender)}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('blood_group')}}</label>
									</div>
									<div class="col-md-6"><strong>{{ $staff_record->blood_group}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{ getPhrase('fathers_name') }}</label>
									</div>
									<div class="col-md-6"><strong>{{ $staff_record->fathers_name }}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{ getPhrase('mothers_name') }}</label>
									</div>
									<div class="col-md-6"><strong>{{ $staff_record->mothers_name}}</strong></div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{ getPhrase('mother_tongue') }}</label>
									</div>
									<div class="col-md-6"><strong>{{ $staff_record->mother_tongue}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('nationality') }}</label>
									</div>
									<div class="col-md-6"><strong>{{ $staff_record->nationality}}</strong></div>
								</div>
							</div>
						</div>
					 

						<h3 class="profile-details-title">{{getPhrase('contact_details')}}</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('address_lane1')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff_record->address_land1}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('address_lane2')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff_record->address_land2}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('city')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff_record->city}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('state')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff_record->state}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('zipcode')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff_record->zipcode}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('country')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff_record->country}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('mobile')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff_record->mobile}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('home_phone')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff_record->home_phone}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('email')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$user_record->email}}</strong></div>
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
									<div class="col-md-6"><strong>{{$staff_record->qualification}}</strong></div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('experience')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff_record->total_experience_years.' '. getPhrase('years').' '.$staff_record->total_experience_month.' '.getPhrase('months')}}</strong></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="">{{getPhrase('experience_information')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff_record->experience_information}}</strong></div>
									<div class="col-md-6">
										<label for="">{{getPhrase('other_information')}}</label>
									</div>
									<div class="col-md-6"><strong>{{$staff_record->other_information}}</strong></div>
								</div>
							</div>

						</div>

					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
		@stop