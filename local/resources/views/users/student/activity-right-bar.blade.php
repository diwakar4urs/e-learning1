<?php $userObject = new App\User() ?>
<div class="panel-heading">
					<h2>{{getPhrase('recent_activity')}}</h2>
				</div>
				
				<div class="panel-body">
					<ul class="list-replay list-sidebar">
						@foreach($data['recent_activity'] as $r)
						<?php $activity_data = json_decode($r->properties); 
							$user = $userObject::where('id','=',$activity_data->attributes->user_id)->first();
							
						?>
						<li>
							<a href="javascript::void(0);">
								<img alt="{{ ucwords($user->name) }}" title="{{ucwords($user->name)}}" src="{{getProfilePath($user->image)}}" >
								<h4>{{$user->name.' '.getPhrase('record').' '.getPhrase('was').'  '. $r->description  }} <span class="time">
								<i class="mdi mdi-clock"></i>{{ $r->updated_at->diffForHumans() }}</span></h4>
								<p>
							<?php 
							$roll_no = '';
							$current_year = '';
							$current_semister = '';
							if(isset($activity_data->attributes->roll_no))
								$role_no = $activity_data->attributes->roll_no;
														
							if(isset($activity_data->attributes->current_year))
								$current_year = $activity_data->attributes->current_year;

							
							if(isset($activity_data->attributes->current_semister))
								$current_semister = $activity_data->attributes->current_semister;

							?>
								{{ getPhrase('admission_no').': '.$activity_data->attributes->admission_no.' '.getPhrase('roll_no').': '.$roll_no.' '.getPhrase('year').': '.$current_year.'-'.$current_semister}} </p>
								<i class="mdi arrow-link mdi-chevron-right"></i>
							</a>
						</li>
						@endforeach
	 
					</ul>
				</div>