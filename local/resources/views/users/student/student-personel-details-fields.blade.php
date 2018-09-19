<?php $new_tab_active = '';
	if($tab_active=='personal')
		$new_tab_active = ' in active';
 ?>
<div id="personal_details" class="tab-pane fade {{$new_tab_active}}">
						{{ Form::model($record, 
						array('url' => ['student/profile/edit/personal', $userRecord->slug], 
						'method'=>'patch')) }}
									<h3>{{getPhrase('personal_details')}}</h3>
									<div class="row">
										<fieldset class="form-group col-md-6">
										{{ Form::label('first_name', getphrase('first_name')) }}
										<span class="text-red" >*</span>
											{{ Form::text('first_name', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Jack')) }}
										</fieldset>
										<fieldset class="form-group col-md-6">
										{{ Form::label('middle_name', getphrase('middle_name')) }}
											{{ Form::text('middle_name', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Jarvis')) }}
										</fieldset>
										<fieldset class="form-group col-md-6">
											{{ Form::label('last_name', getphrase('last_name')) }}
											{{ Form::text('last_name', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Magi')) }}
										</fieldset>
                                     
                                     @if($birth_date=='')


                                            <div class='col-sm-6'>
											{{ Form::label('date_of_birth', getphrase('date_of_birth')) }}
											<span class="text-red" >*</span>
											<div id="dpYears" class="input-group date"  data-date-viewmode="years"  data-provide="datepicker" data-date-format="{{getDateFormat()}}">
											{{ Form::text('date_of_birth', $value = date('Y/m/d') , $attributes = array('class'=>'form-control', 'placeholder' => '2015/7/17', 'id'=>'dp')) }}
												<div class="input-group-addon">
													<span class="mdi mdi-calendar"></span>
												</div>
											</div>
										</div>
                                         @else

                                          <div class='col-sm-6'>
											{{ Form::label('date_of_birth', getphrase('date_of_birth')) }}
											<span class="text-red" >*</span>
											<div id="dpYears" class="input-group date"  data-date-viewmode="years"  data-provide="datepicker" data-date-format="{{getDateFormat()}}">
											{{ Form::text('date_of_birth', $value = $birth_date , $attributes = array('class'=>'form-control', 'placeholder' => '2015/7/17', 'id'=>'dp')) }}
												<div class="input-group-addon">
													<span class="mdi mdi-calendar"></span>
												</div>
											</div>
										</div>
										@endif


										<div class="col-md-12 clearfix"></div>
										<fieldset class='col-sm-6'>
											{{ Form::label('gender', getphrase('gender')) }}
											<div class="form-group row">
												<div class="col-md-6">
												{{ Form::radio('gender', 'male', true, array('id'=>'free')) }}
													
													<label for="free"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('male')}}</label> 
												</div>
												<div class="col-md-6">
												{{ Form::radio('gender', 'female', true, array('id'=>'paid')) }}
													<label for="paid"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('female')}} </label>
												</div>
											</div>
										</fieldset>
										<fieldset class="form-group col-md-6">
											{{ Form::label('blood_group', getphrase('blood_group')) }}
											{{Form::select('blood_group', getBloodGroups(), null, ['placeholder' => getPhrase('select'),'class'=>'form-control'])}}
										</fieldset>

										<fieldset class="form-group col-md-6">
											{{ Form::label('fathers_name', getphrase('fathers_name')) }}
											<span class="text-red" >*</span>
											{{ Form::text('fathers_name', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Jim')) }}
										</fieldset>
										<fieldset class="form-group col-md-6">
											{{ Form::label('mothers_name', getphrase('mothers_name')) }}
											<span class="text-red" >*</span>
											{{ Form::text('mothers_name', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Arlo')) }}
										</fieldset>
										<fieldset class="form-group col-md-6">
											{{ Form::label('nationality', getphrase('nationality')) }}
											
											{{Form::select('nationality', $countries, null, ['placeholder' => getPhrase('select'),'class'=>'form-control select1'])}}

										</fieldset>
										<fieldset class="form-group col-md-6">
											{{ Form::label('mother_tongue', getphrase('mother_tongue')) }}
											{{ Form::text('mother_tongue', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'English')) }}
										</fieldset>

										<fieldset class="form-group col-md-6">
											{{ Form::label('religion_id', getphrase('religion')) }}
											<span class="text-red" >*</span>
											{{Form::select('religion_id', $religions, null, ['placeholder' => getPhrase('select'),'class'=>'form-control select1'])}}

										</fieldset>

										<fieldset class="form-group col-md-6">
											{{ Form::label('category_id', getphrase('category')) }}
											<span class="text-red" >*</span>
											{{Form::select('category_id', $categories, null, ['placeholder' => getPhrase('select'),'class'=>'form-control select1'])}}

										</fieldset>
										 
									</div>
									<div class="buttons text-center">
										<button type="submit" class="btn btn-lg btn-primary button">{{getphrase('update')}}</button>
									</div>
								{!! Form::close() !!}
							</div>