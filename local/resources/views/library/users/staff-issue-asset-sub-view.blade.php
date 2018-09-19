{!! Form::open(array('url' => 'library/issues/issue-asset', 'method' => 'POST', 'files' => TRUE)) !!}

	<h3>{{getPhrase('library_issues')}}</h3>
	 <div class="row">
	 <fieldset class="form-group col-md-6">
	{{ Form::label('library_asset_no', getphrase('reference_no')) }}
	
	{{ Form::text('library_asset_no', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Type to search', 'id'=>'staff-auto')) }}
	</fieldset>
	 </div>

	 <div class="panel panel-custom">
					<div class="panel-heading">
						<h1>{{getPhrase('asset_details')}}</h1>
					</div>

					<div class="panel-body packages">
						<div class="row">
							<div class="col-md-4">

								<div class="slider slider-for">
									<div id="asset_image"> 
									</div>
									 
								</div>
								
							</div>
							<div class="col-md-4">
								<ul class="hostel-details" id="master_details">
								 {{getPhrase('please_enter_asset_reference_number')}}
								</ul>
							</div>
							<div class="col-md-4">
								<ul class="hostel-details" id="asset_details">
								
								</ul>
							</div>
						</div>
						<div class="buttons text-center" id="button">
						</div>
					</div>



				</div>
			

{!! Form::close() !!}