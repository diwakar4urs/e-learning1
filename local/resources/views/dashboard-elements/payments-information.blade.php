

					     <div class="panel panel-primary">
					      <div class="panel-heading">{{$heading}}</div>
					      @if(!count($records))
					      <br>
					 		 <p> &nbsp;&nbsp;&nbsp;{{getPhrase('no_data_available')}}</p>
					 		 
					 	 @else

					    	<table class="table">	
					    	<thead>
					    		<tr>
					    			<th><strong>{{getPhrase('name')}}</strong></th>
					    			<th><strong>{{getPhrase('item')}}</strong></th>
					    			<th><strong>{{getPhrase('gateway')}}</strong></th>
					    			<th><strong>{{getPhrase('paid')}}</strong></th>
					    			<th><strong>{{getPhrase('status')}}</strong></th>
					    		</tr>
					    	</thead>
					    	<tbody>
					    	@foreach($records as $record)

					    	<?php 
					    	$class = '';

					    		if($record->payment_status == 'success')
					    			{
					    				$class='label label-success';
					    			}
					    		else if($record->payment_status == 'pending')
					    			{
					    				$class='label label-warning';
					    			}
					    		else if($record->payment_status == 'cancelled')
					    			{
					    				$class='label label-danger';
					    			}

					    		?>
					 			<tr>
					 				<td>{{ucfirst($record->name)}}</td>
					 				<td>{{ucfirst($record->item_name)}}</td>
					 				<td>{{ucfirst($record->payment_gateway)}}</td>
					 				
					 				<td>{{$record->paid_amount}}</td>
					 				<td>
					 				<span class="{{$class}}">
					 				{{ucfirst($record->payment_status)}}
					 				</span>
					 				</td>
					 				 
					 			</tr>
					 		@endforeach

					    	</tbody>
					    	</table>  
					    @endif
					     
					    </div>