@extends('layouts.admin.adminlayout')
@section('content')
@include('users.user-navigation-header-layout')

<div id="page-wrapper">
			<div class="container-fluid">
			 
								
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						
						<div class="pull-right messages-buttons">
							 
							<a class="btn  btn-primary button" href="/roles/add">{{ getPhrase('add_role')}}</a>
						</div>
						<h1>{{ $title }}</h1>
					</div>
					<div class="panel-body packages">
						
						<table id="exams_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>{{ getPhrase('sno')}}</th>
									 
									<th>{{ getPhrase('role_name')}}</th>
									<th>{{ getPhrase('display_name')}}</th>
									<th>{{ getPhrase('description')}}</th>
									<th>{{ getPhrase('action')}}</th>
								</tr>
							</thead>
							<tbody>
							
							@foreach($roles as $record)
								<tr id="tr_{{$record->id}}">
								<td>{{$record->id}}</td>
									<td>  {{ucfirst($record->name)}} </td>
									<td>  {{ucfirst($record->display_name)}} </td>
									<td>  {{ucfirst($record->description)}} </td>
									 
									<td>
										<div class="dropdown more">
											<a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="mdi mdi-dots-vertical"></i>
											</a>
											<ul class="dropdown-menu" aria-labelledby="dLabel">
												<li><a href="/roles/edit/{{$record->id}}"><i class="icon-packages"></i> {{ getPhrase('edit')}}</a></li>
												<li><a href="javascript:void(0);" onclick="deleteRecord({{$record->id}});"><i class="icon-trash"></i> {{ getPhrase('delete')}}</a></li>
											</ul>
										</div>

									</td>
								</tr>
							@endforeach
							</tbody>
						</table>

					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
@include('users.user-navigation-footer-layout')
@endsection


@section('footer_scripts')
<script>
	function deleteRecord(id) {
	swal({
		  title: "Are you sure?",
		  text: "You will not be able to recover this record!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Yes, delete it!",
		  cancelButtonText: "No, cancel pls!",
		  closeOnConfirm: false,
		  closeOnCancel: false
		},
		function(isConfirm) {
		  if (isConfirm) {
		  	  var token = '{{ csrf_token()}}';
		  	route = '/roles/delete/'+id;  
		    $.ajax({
		        url:route,
		        type: 'post',
		        data: {_method: 'delete', _token :token},
		        success:function(msg){
		        	swal("Deleted!", "Your imaginary file has been deleted. "+msg, "success");
		        	$('#tr_'+id).remove();
		        }
		    });

		  } else {
		    swal("Cancelled", "Your record is safe :)", "error");
		  }
	});
	}
</script>
@stop