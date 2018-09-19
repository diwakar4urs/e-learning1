@extends('layouts.admin.adminlayout')
@section('content')
@include('users.user-navigation-header-layout')
<!-- /.row -->
			<div id="page-wrapper">
			<div class="container-fluid">
					
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						
						<div class="pull-right messages-buttons">
							 
							<a class="btn  btn-primary button" href="/roles">{{ getPhrase('list_roles')}}</a>
						</div>
						<h1>{{ $title }}</h1>
					</div>
					<div class="panel-body packages">
@include('errors.errors')
<form action="/roles/update" method="POST" class="replay-form">
{{method_field('PATCH')}}
<input type="hidden" name="id" value="{{$role->id}}">
 {{csrf_field()}}
	<fieldset class="form-group">
		<label for="name">{{ getPhrase('name')}}</label>
		<input type="text" class="form-control" id="name" name="name" value="{{$role->name}}"  placeholder="Admin">
	</fieldset>
	<fieldset class="form-group">
		<label for="display_name">{{ getPhrase('display_name')}}</label>
		<input type="text" class="form-control" id="display_name" value="{{$role->display_name}}"  name="display_name" placeholder="Adminstrator">
	</fieldset>
	<fieldset class="form-group">
		<label for="exampleTextarea">{{ getPhrase('description') }}</label>
		<textarea class="form-control" id="exampleTextarea" name="description" placeholder="Adminstrator" rows="5">{{$role->description}}</textarea>
	</fieldset>
	
	<div class="buttons text-center">
		<button type="submit" class="btn btn-primary button btn-lg">{{ getPhrase('submit') }}</button>
	
	</div>
</form>
</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
@include('users.user-navigation-footer-layout')
@stop
