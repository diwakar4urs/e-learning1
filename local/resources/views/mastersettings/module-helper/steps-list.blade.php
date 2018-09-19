@extends($layout)
@section('header_scripts')

@stop
@section('custom_div')

<div ng-controller="ModuleHelper" >

@stop
@section('content')


<div id="page-wrapper" ng-init="initData({{$record->steps}})" >
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a  href="{{URL_SETTINGS_DASHBOARD}}">{{ getPhrase('master_settings')}}</a></li>
							<li><a href="{{URL_MODULEHELPERS_LIST}}">{{ getPhrase('modules_helper')}}</a>  </li>
							<li>{{ $title}}</li>
						</ol>
					</div>
				</div>
								
				<!-- /.row -->
				<div class="panel panel-custom col-lg-12">
					<div class="panel-heading">
						 
						<h1>{{ $title }}

						</h1>

					</div>
					<div class="panel-body packages">
				 
					
						<div class="row"> 
						<div class="col-md-6">
						 <fieldset class="form-group col-md-6">
						   {{ Form::label('element', getphrase('element_id')) }}
						   <span class="text-red">*</span>
						   {{ Form::text('elements', $value = null , $attributes = array('class'=>'form-control', 
						   	'placeholder' => '#element_id',
						   	'ng-model' => 'element'
						   )) }}
						</fieldset>
						<fieldset class="form-group  col-md-6">
						   {{ Form::label('title', getphrase('title')) }}
						   <span class="text-red">*</span>
						   {{ Form::text('title', $value = null , $attributes = array('class'=>'form-control', 'placeholder' =>  getPhrase('title'),
						   	'ng-model' => 'title' 
						   ))}}
						</fieldset>
						 
					 
					<fieldset class="form-group col-md-6">
						{{ Form::label('placement', getphrase('placement')) }}
						<span class="text-red">*</span>
						<select name="placement" class="form-control" 
						ng-model="selected_placement"
						ng-options="p.text for p in placements track by p.value"
						>
						</select>
					</fieldset>

						<fieldset class="form-group  col-md-6">
						   {{ Form::label('content', getphrase('content')) }}
						   <span class="text-red">*</span>
						   {{ Form::text('content', $value = null , $attributes = array('class'=>'form-control', 'placeholder' =>  getPhrase('content'),
						   	'ng-model'=> 'content'
						   ))}}
						</fieldset>
						<fieldset class="form-group  col-md-6">
						   {{ Form::label('sort_order', getphrase('sort_order')) }}
						   <span class="text-red">*</span>
						   {{ Form::text('sort_order', $value = null , $attributes = array('class'=>'form-control', 'placeholder' =>  getPhrase('sort_order'),
						   	'ng-model'=> 'sort_order'
						   ))}}
						</fieldset>


						
						<div class="text-center col-md-12">
							<a href="javascript:void(0);" ng-click="addToList()" class="btn btn-lg btn-success button" 
							>{{ getPhrase('add_to_list') }}</a>
						</div>
						</div>
						 
						<div class="col-md-6">
						{!! Form::open(array('url' => URL_MODULEHELPERS_ADD_STEPS.$record->slug, 'method' => 'PATCH', 
						'novalidate'=>'','name'=>'formSettings ', 'files'=>'true')) !!}

							<table class="table table-th-no-border">
						
						<thead>
							<tr>
								<th>{{getPhrase('sno')}}</th>
								<th>{{getPhrase('element')}}</th>
								<th>{{getPhrase('title')}}</th>
								<th>{{getPhrase('content')}}</th>
								<th>{{getPhrase('placement')}}</th>
								<th>{{getPhrase('action')}}</th>
							</tr>
						</thead>
						<tbody>
						<tr ng-if="target_items.length==0"> <td colspan="5">No Data Available</td> </tr>
							<tr ng-repeat="item in target_items | orderObjectBy:'sort_order'">
								<td>
								<input type="hidden" class="form-control" name="id_list[]" value="@{{item.id}}">
								<input type="number" class="form-control" name="sort_order_list[]" value="@{{item.sort_order}}">
								</td>
								<td>
								<input type="text" class="form-control" name="elements_list[]" value="@{{item.element}}">
								</td>
								<td>
									<input type="text" class="form-control" name="titles_list[]" value="@{{item.title}}">
								</td>
								<td>
								<input type="text" class="form-control" name="contents_list[]" value="@{{item.content}}">
								</td>
								<td>
									<input type="text" class="form-control" name="placements_list[]" value="@{{item.placement}}">
								</td>
								<td><i class="fa fa-trash text-danger" ng-click="removeItem(item)"></i></td>
							</tr>

						</tbody>
					</table>
					<div class="buttons text-center clearfix" ng-if="target_items.length>0"> 
				<button type="submit" class="btn btn-lg btn-success button" >{{ getPhrase('update') }}</button>
						</div>
						{!! Form::close() !!}	
					</div>
					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
@endsection
 
@section('custom_div_end')

</div>
@stop
@section('footer_scripts')
  	@include('mastersettings.module-helper.scripts.js-scripts')
 
  <script src="{{JS}}bootstrap-toggle.min.js"></script>

@stop
