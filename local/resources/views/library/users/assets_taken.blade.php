<?php use Carbon\Carbon ; ?>
<h3>{{ getPhrase('assets_on_issue') }}</h3>
<table class="table table-bordered tabel-dues-details fee-details">
			<thead>
				<tr>
					<th>{{ getPhrase('reference_no')}}</th>
					<th>{{ getPhrase('name')}}</th>
					<th>{{ getPhrase('category') }}</th>
					<th>{{ getPhrase('issued_on')}}</th>
					<th>{{ getPhrase('due_date')}}</th>
					<th></th>
					
				</tr>
			</thead>
			<tbody>
			 
				@foreach($books_issued as $book)

				<?php 
					$is_late = FALSE;
					if(Carbon::now() > $book->due_date)
						$is_late = TRUE;
				 ?>
				<tr 
				@if($is_late)
				class="due-overday"
				@endif
				>
					<td valign="middle"> 
					
					@if($is_late)
					<div class="subject-latter">L</div> 
					@endif
					<?php $master = $book->instanceData->masterRecord; ?>
					{{ $book->instanceData->asset_no }} </td>
					<td valign="middle">{{ $master->title }}</td>
					<td valign="middle">{{ $master->assetType->asset_type }}</td>
					<td valign="middle"><i class="mdi mdi-calendar"></i> {{ $book->issued_on }}</span></td>
					<td valign="middle"><i class="mdi mdi-calendar"></i> <span class="text-red"> {{ $book->due_date }}</td>
					<td valign="middle">
					{!! Form::open(array('url' => 'library/returns/return-asset', 'method' => 'POST')) !!}
					<input type="hidden" name="user_id" value="{{ $user->id }}">
					<input type="hidden" name="issue_id" value="{{ $book->id }}">
					<input type="hidden" name="instance_id" value="{{ $book->library_instance_id }}">
					<input type="hidden" name="master_id" value="{{ $book->master_asset_id }}">
					<input type="hidden" name="user_slug" value="{{ $user->slug }}">
					
					{!! Form::close() !!}
					
					</td>
				
				</tr>
				@endforeach
				 
				
			</tbody>
		</table>
		