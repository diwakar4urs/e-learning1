 					<fieldset class="form-group">
						
						{{ Form::label('title', getphrase('title')) }}
						<span class="text-red">*</span>
						
						{{ Form::text('title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => 'parentmapname',
						    
						    'ng-model'=>'title', 
                            'required'=> 'true', 

							'ng-class'=>'{"has-error": formParentMap.title.$touched && formParentMap.title.$invalid}',
                            )) }}
                            <div class="validation-error" ng-messages="formParentMap.title.$error" >

	    					{!! getValidationMessage()!!}


	    				</div>
					</fieldset>
                    
                    <fieldset class="form-group">
                    	{{ Form::label('description',getphrase('description')) }}
                    	{{ Form::textarea('description',$value = null,$attributes =array('class'=>'form-control','rows'=>5,'placeholder'=>'Description')) }}
                    </fieldset>
					
 					 
						<div class="buttons text-center">
							<button class="btn btn-lg btn-success button" ng-disabled='!formParentMap.$valid'>{{ $button_name }}</button>
						</div>
		 