<?php $new_tab_active = '';
	if($tab_active=='contact')
		$new_tab_active = ' in active';
 ?>
<div id="contact_details" class="tab-pane fade {{$new_tab_active}}">
								{{ Form::model($record, 
						array('url' => ['student/profile/edit/contact', $userRecord->slug], 
						'method'=>'patch')) }}
									<h3>{{getPhrase('contact_details')}}</h3>
									<div class="row">
                                           
                                           <fieldset class="form-group col-md-6">
										{{ Form::label('guardian_name', getphrase('guardian_name')) }}
										<span class="text-red">*</span>
											{{ Form::text('guardian_name', $value =null , $attributes = array('class'=>'form-control', 'placeholder' => 'Guardian name')) }}
										</fieldset>

										 <fieldset class="form-group col-md-6">
										{{ Form::label('guardian_phone', getphrase('guardian_phone')) }}
										<span class="text-red">*</span>
											{{ Form::text('guardian_phone', $value =null , $attributes = array('class'=>'form-control', 'placeholder' => 'Phone number')) }}
										</fieldset>

										 <fieldset class="form-group col-md-6">
										{{ Form::label('relationship_with_guardian', getphrase('relationship_with_guardian')) }}
										<span class="text-red">*</span>
											{{ Form::text('relationship_with_guardian', $value =null , $attributes = array('class'=>'form-control', 'placeholder' => 'Relation')) }}
										</fieldset>


										 <fieldset class="form-group col-md-6">
										{{ Form::label('guardian_email', getphrase('guardian_email')) }}
										<span class="text-red">*</span>
											{{ Form::text('guardian_email', $value =null , $attributes = array('class'=>'form-control', 'placeholder' => 'Email')) }}
										</fieldset>



										<fieldset class="form-group col-md-6">
											{{ Form::label('address_lane1', getphrase('address_lane1')) }}
											<span class="text-red">*</span>
											{{ Form::textarea('address_lane1', $value = null , $attributes = array('class'=>'form-control', 'rows'=>'5', 'placeholder' => '123-Colony, ABC Road')) }}
										</fieldset>

										<fieldset class="form-group col-md-6">
											{{ Form::label('address_lane2', getphrase('address_lane2')) }}
											<span class="text-red">*</span>
											{{ Form::textarea('address_lane2', $value = null , $attributes = array('class'=>'form-control','rows'=>'5', 'placeholder' => '123-Colony, ABC Road')) }}
										</fieldset>

										<fieldset class="form-group col-md-6">
										{{ Form::label('city', getphrase('city')) }}
										<span class="text-red">*</span>
											{{ Form::text('city', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Aberdeen City')) }}
										</fieldset>
										<fieldset class="form-group col-md-6">
											{{ Form::label('state', getphrase('state')) }}
											<span class="text-red">*</span>
											{{ Form::text('state', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'United Kingdom')) }}
										</fieldset>
										<fieldset class="form-group col-md-6">
												{{ Form::label('country', getphrase('country')) }}
											<span class="text-red">*</span>
											{{Form::select('country', $countries, null, ['placeholder' => getPhrase('select'),'class'=>'form-control'])}}
										</fieldset>

										<fieldset class="form-group col-md-6">
											{{ Form::label('zipcode', 'ZIP '.getPhrase('code')) }}
											<span class="text-red">*</span>
											{{ Form::text('zipcode', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'AB11')) }}
										</fieldset>
										
										

										<fieldset class="form-group col-md-6">
											{{ Form::label('mobile', getphrase('mobile')) }}
											<span class="text-red">*</span>
											{{ Form::text('mobile', $ph_no , $attributes = array('class'=>'form-control', 'placeholder' => '1234567891')) }}
										</fieldset>
										
										<fieldset class="form-group col-md-6">
											{{ Form::label('home_phone', getphrase('home_phone')) }}
											<span class="text-red">*</span>
											{{ Form::text('home_phone', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => '1234567891')) }}
										</fieldset>
										 

									</div>
									<div class="buttons text-center">
										<button type="submit" class="btn btn-lg btn-primary button">{{getphrase('update')}}</button>
									</div>
								{!! Form::close() !!}
							</div>