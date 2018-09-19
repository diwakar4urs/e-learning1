<?php $new_tab_active = '';
	if($tab_active=='parent')
		$new_tab_active = ' in active';
 ?>
<div id="parent_details" class="tab-pane fade {{$new_tab_active}}">

			{{ Form::model($record, 
			array('url' => ['student/profile/edit/parent', $userRecord->slug], 
			'method'=>'patch')) }}
		<h3>{{getPhrase('parent_login_details')}}</h3>
		<?php $user_record = getUserRecord($record->user_id);
		?>
		
		@if(!$user_record->parent_id) 
		
		<div class="row">
				<fieldset class='col-sm-6'>
				<label for="exampleInputEmail1">Is Parent Account  Available</label>
				<div class="form-group row">
					<div class="col-md-6">
						<input type="radio" checked="checked" id="available" name="account" value="1" ng-model="account_available" ng-init="account_available=1; accountAvailable(1);" ng-click="accountAvailable(1)">
						<label for="available"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> Yes </label>
					</div>
					<div class="col-md-6">
						<input type="radio" id="not_available" name="account" value="0" ng-model="account_not_available" ng-click="accountAvailable(0)">
						<label for="not_available"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> No </label>
					</div>
				</div>
			</fieldset>
		</div>
		<div class="sem-parent-container">
		

		<div class="row" >
		<div class="col-md-6">
		<input 	type="hidden" 
				ng-model="current_user_id" 
				name="current_user_id" 
				value="{{$record->user_id}}">
		<input 	type="hidden" 
				ng-model="parent_user_id" 
				name="parent_user_id" 
				value="@{{parent_user_id}}">
			<fieldset class="form-group" ng-show="showSearch">
			{{ Form::label('search', getphrase('search')) }}
			<span class="text-red" >*</span>
				{{ Form::text('search', $value = null , $attributes = array(
					'class'			=> 'form-control', 
					'placeholder' 	=> 'Jack',
					'ng-model' 		=> 'search',

					'ng-change' 	=> 'getParentRecords(search)',
					)) }}
			</fieldset>
			<div >
				<p ng-if="parents.length==0 && showSearch">Please type any details for search</p>
			<table ng-if="parents.length>0" class="table table-striped">
				<thead>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
				</thead>
				<tbody>
					<tr ng-repeat="item in parents" ng-click="setAsCurrentItem(item)">
						<td>@{{item.name}}</td>
						<td>@{{item.email}}</td>
						<td>@{{item.phone}}</td>
					</tr>
				</tbody>
			</table>

			</div>
		</div>
		<div class="col-md-6" ng-show="userDetails" >
		<fieldset class="form-group ">
			{{ Form::label('parent_name', getphrase('parent_name')) }}
			<span class="text-red" >*</span>
				{{ Form::text('parent_name', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Jack', 'ng-model'=>'parent_name')) }}
			</fieldset>

			<fieldset class="form-group ">
			{{ Form::label('parent_user_name', getphrase('parent_user_name')) }}
			<span class="text-red" >*</span>
				{{ Form::text('parent_user_name', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Jack', 'ng-model'=>'parent_user_name')) }}
			</fieldset>
			<fieldset class="form-group ">
			{{ Form::label('parent_email', getphrase('parent_email')) }}
				{{ Form::text('parent_email', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Jarvis', 'ng-model'=>'parent_email')) }}
			</fieldset>
			<fieldset class="form-group ">
				{{ Form::label('parent_password', getphrase('password')) }}
				{{ Form::password('parent_password',$attributes = array('class'=>'form-control')) }}
			</fieldset>
			 
			<div class="col-md-12 clearfix"></div>
		 	 
		</div>
		</div>

		</div>
		
		                        <div class="buttons text-center">
			                    <button type="submit" class="btn btn-lg btn-primary button">{{getphrase('update')}}</button>
		                              </div>
								{!! Form::close() !!}
								@else
								<?php $parent_record = getUserRecord($user_record->parent_id); ?>
								<div class="row">
								<div class="col-md-6 col-md-offset-3">
									<table class="table table-bordered table-striped">
										<tbody>
										<tr>
											<td>Name</td>
											<td>{{$parent_record->name}}</td>
										</tr>
										<tr>
											<td>Username</td>
											<td>{{$parent_record->username}}</td>
										</tr>
										<tr>
											<td>Email</td>
											<td>{{$parent_record->email}}</td>
										</tr>

										</tbody>
									</table>
								</div>
								</div>
								@endif

							</div>