 <div class="panel panel-primary">
					      <div class="panel-heading">{{$heading}}</div>
					      @if(!count($records))
					      <br>
					 		 <p> &nbsp;&nbsp;&nbsp;{{getPhrase('no_data_available')}}</p>
					 		  
					 	 @else

					    	<div class="panel-body">
					<ul class="list-replay list-sidebar">
					 
					@foreach($records as $user)
					
						<li>
							<a href="{{URL_USER_DETAILS.$user->slug}}">
							<?php if($user->image!='') {?>
								<img src="{{IMAGE_PATH_PROFILE_THUMBNAIL.$user->image}}" alt="">
                            <?php }?>
                            <?php if($user->image=='') {?>
								<img src="{{IMAGE_PATH_PROFILE_DEFAULT_THUMBNAIL}}" alt="">
                            <?php }?>

								<h4>{{$user->name}} ({{$user->percentage}} %)</h4>
								<p>{{getPhrase('quiz_name')}}: {{$user->title}} </p>
								
							</a>
						</li>
					@endforeach
					</ul>
				</div>
					    @endif
					     
					    </div>