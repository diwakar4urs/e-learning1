
<fieldset class="form-group col-md-4">
   {{ Form::label('title', getphrase('title')) }}
   <span class="text-red">*</span>
   {{ Form::text('title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('title')
   )) }}
</fieldset>
<fieldset class="form-group  col-md-4">
   {{ Form::label('key', getphrase('key')) }}
   <span class="text-red">*</span>
   {{ Form::text('slug', $value = null , $attributes = array('class'=>'form-control', 'placeholder' =>  getPhrase('key')
   ))}}
</fieldset>
<fieldset class="form-group  col-md-4">
   {{ Form::label('help_link_text', getphrase('help_link_text')) }}
   <span class="text-red">*</span>
   {{ Form::text('help_link_text', $value = null , $attributes = array('class'=>'form-control', 'placeholder' =>  getPhrase('help_me')
   ))}}
</fieldset>
<div class="row">
<fieldset class="form-group  col-md-4">
   {{ Form::label('help_link_url', getphrase('help_link_url')) }}
   <span class="text-red">*</span>
   {{ Form::text('help_link_url', $value = null , $attributes = array('class'=>'form-control', 'placeholder' =>  'http:\\projectname\documentation'
   ))}}
</fieldset>
</div>
<h4>Settings</h4>
 <fieldset class="form-group col-md-4">
	  <?php 
	  $checked = '';

	  
	  
	  if($record) {
	  	$settings = json_decode($record->settings);
	  	if($record->is_enabled)
	  		$checked = 'checked';
	  }
	  ?>
	  <label data-toggle="tooltip" data-placement="top" >{{getPhrase('is_enabled')}}
	   <input 
 		type="checkbox" 
		data-toggle="toggle" 
		data-onstyle="success" 
		data-offstyle="default"

 		name="is_enabled" 
 		required="true" 
 		value = "1" 
		{{$checked}}
		title ="{{getPhrase('is_enabled')}}"
		data-placement="right">
</label>
</fieldset>
 
<fieldset class="form-group col-md-4">
	  <?php 
	    $checked = '';
	  if($record) {
	  	if($settings->keyboard)
	  		$checked = 'checked';
	  }
	  ?>
	  <label data-toggle="tooltip" data-placement="top"  >{{getPhrase('keyboard')}}
	   <input 
 		type="checkbox" 
		data-toggle="toggle" 
		data-onstyle="success" 
		data-offstyle="default"

 		name="keyboard" 
 		required="true" 
 		value = "1" 
		{{ $checked }}
		title ="{{getPhrase('keyboard')}}"
		data-placement="right">
</label>
</fieldset>
<fieldset class="form-group col-md-4">
	   <?php 
	    $checked = '';
	  if($record) {
	  	if($settings->backdrop)
	  		$checked = 'checked';
	  }
	  ?>
	<label data-toggle="tooltip" data-placement="top"  >{{getPhrase('backdrop')}}
	   <input 
 		type="checkbox" 
		data-toggle="toggle" 
		data-onstyle="success" 
		data-offstyle="default"

 		name="backdrop" 
 		required="true" 
 		value = "1" 
		{{ $checked }}
		title ="{{getPhrase('backdrop')}}"
		data-placement="right">
	</label>
</fieldset>
 

 

<div class="buttons text-center">
   <button class="btn btn-lg btn-success button"
      >{{ $button_name }}</button>
</div>

