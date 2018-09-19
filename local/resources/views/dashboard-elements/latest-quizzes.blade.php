

					     <div class="panel panel-primary">
					      <div class="panel-heading">{{$heading}}</div>
					      @if(!count($records))
					      <br>
					 		 <p> &nbsp;&nbsp;&nbsp;{{getPhrase('no_quizzes_available')}}</p>
					 		 <p> &nbsp;&nbsp;&nbsp; <a href="{{URL_USERS_SETTINGS.Auth::user()->slug}}">{{getPhrase('click_here')}}</a> {{getPhrase('to_change_your_settings')}}</p>
					 	 @else

					    	<table class="table">	
					    	<thead>
					    		<tr>
					    			<th>{{getPhrase('title')}}</th>
					    			<th>{{getPhrase('type')}}</th>
					    			<th>{{getPhrase('Action')}}</th>
					    		</tr>
					    	</thead>
					    	<tbody>
					    	@foreach($records as $quiz)
					 			<tr>
					 				<td>{{$quiz->title}}</td>
					 				<td>
					 				@if($quiz->is_paid)
					 					<span class="label label-danger">{{getPhrase('paid')}}
					 					</span>
				 					@else
				 					<span class="label label-success">{{getPhrase('free')}}
					 					</span>
				 					@endif
					 				</td>
					 				<td>
					 				@if($quiz->is_paid)
					 					<a href="{{URL_PAYMENTS_CHECKOUT.'exam/'.$quiz->slug}}">{{getPhrase('buy_now')}}</a> 
				 					@else
				 					-
				 					@endif
					 				</td>
					 			</tr>
					 		@endforeach

					    	</tbody>
					    	</table>  
					    @endif
					     
					    </div>