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
									<th>{{ getPhrase('return_on')}}</th>
									<th>{{ getPhrase('type')}}</th>
									
									
								</tr>
							</thead>
							<tbody>
							 
								@foreach($books_history as $book)

								<?php 
									$is_late = FALSE;
									
									if($book->return_on > $book->due_date)
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
									<td valign="middle">  {{ $book->due_date }}</td>
									<td valign="middle">
									<?php if($book->issue_type == 'issue' || $book->issue_type == 'renewal') { ?>
									<strong>{{ getPhrase('on_issue')}}</strong>
									<?php } else {?>
									 <i class="mdi mdi-calendar"></i>  {{ $book->return_on }}
									<?php } ?>
									
									 </td>
									<td valign="middle">  {{ ucfirst($book->issue_type) }}</td>
									 
								
								</tr>
								@endforeach
								 
								
							</tbody>
						</table>
						