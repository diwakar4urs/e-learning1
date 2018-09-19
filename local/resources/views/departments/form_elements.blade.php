 
					 <fieldset class="form-group">
						
						{{ Form::label('department_name', getphrase('department_name')) }}
						
						{{ Form::text('department_name', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'Maths')) }}
					</fieldset>

					 <fieldset class="form-group">
						
						{{ Form::label('department_code', getphrase('department_code')) }}
						
						{{ Form::text('department_code', $value = null, $attributes = array('class'=>'form-control', 'placeholder' => 'MAT')) }}
					</fieldset>

					 <fieldset class="form-group">
						
						{{ Form::label('description', getphrase('description')) }}
						
						{{ Form::textarea('description', $value = null, $attributes = array('class'=>'form-control', 'placeholder' => 'Maths Department', 'rows'=>'5')) }}
					</fieldset>
					
						<div class="buttons text-center">
							<button class="btn btn-lg btn-success button">{{ $button_name }}</button>
						</div>