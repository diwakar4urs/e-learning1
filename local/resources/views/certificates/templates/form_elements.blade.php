 				<?php 
 				$readonly = '';
 				$disabled = '';
					if($record) {
						$readonly = 'readonly="TRUE"';
						$disabled = 'disabled = "TRUE"';
					}
				?>

 					 <fieldset class="form-group">
						
						{{ Form::label('key', getphrase('key')) }}
						<span class="text-red">*</span>
						{{ Form::text('title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('key'),
							'ng-model'=>'title',
							'ng-pattern' => getRegexPattern("name"),
							'required'=> 'true', 
							$readonly,
							'ng-class'=>'{"has-error": formCertificates.title.$touched && formCertificates.title.$invalid}'
						)) }}
						<div class="validation-error" ng-messages="formCertificates.title.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('pattern')!!}
	    					</div>
					</fieldset>

					 <fieldset class="form-group">
						<?php 
					    $certificate_types = array ('content'=>getphrase('content'),
					    	                 'header'        => getphrase('header'),
					    	                 'footer'		 => getphrase('footer'),
					    	                 'independent'	 => getphrase('independent'),
					    	                 ); 
					    ?>
						 	
						{{ Form::label('type', getphrase('type')) }}
						<span class="text-red">*</span>
						{{Form::select('type',$certificate_types , null, [
						'class'=>'form-control'
						 ])}}
					</fieldset>
 					  
 					 <fieldset class="form-group">
						{{ Form::label('subject', getphrase('subject')) }}
						<span class="text-red">*</span>
						{{ Form::text('subject', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('welcome'),
							'ng-model'=>'subject',
							'ng-pattern' => getRegexPattern("name"),
							'required'=> 'true', 
							'ng-class'=>'{"has-error": formCertificates.subject.$touched && formCertificates.subject.$invalid}'
						)) }}
						<div class="validation-error" ng-messages="formCertificates.subject.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('pattern')!!}
	    					</div>
					</fieldset>

					
					<fieldset class="form-group">
						
						{{ Form::label('content', getphrase('content')) }}
						<span class="text-red">*</span>
						<textarea class="form-control ckeditor" name="content"><?php echo ($record)? $record->content : '';?></textarea>
						
					</fieldset>
					
						<div class="buttons text-center">
							<button class="btn btn-lg btn-success button" ng-disabled='!formCertificates.$valid'>{{ $button_name }}</button>
						</div>
		 