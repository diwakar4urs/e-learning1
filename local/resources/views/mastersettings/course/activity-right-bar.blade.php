<?php $userObject = new App\User() ?>
<div class="panel-heading">
					<h2>{{getPhrase('recent_activity')}}</h2>
				</div>
				
				<div class="panel-body">
					<ul class="list-replay list-sidebar">
						@foreach($data['recent_activity'] as $r)
						<?php $activity_data = json_decode($r->properties); 
							$user = $userObject::find($r->causer_id)->first();
							
						?>
						<li>
							<a href="">
								<img alt="{{ ucwords($user->name) }}" title="{{ucwords($user->name)}}" src="{{getProfilePath($user->image)}}" >
								<h4>{{ $activity_data->attributes->course_title.' '.getPhrase('was').'  '. $r->description  }} <span class="time">
								<i class="mdi mdi-clock"></i>{{ $r->updated_at->diffForHumans() }}</span></h4>
								<p>{{ getPhrase('course_code').': '.$activity_data->attributes->course_code.' '.getPhrase('duration').': '.$activity_data->attributes->course_dueration.' '.getPhrase('year')}} </p>
								<i class="mdi arrow-link mdi-chevron-right"></i>
							</a>
						</li>
						@endforeach
						 
						 
						 
					</ul>
				</div>