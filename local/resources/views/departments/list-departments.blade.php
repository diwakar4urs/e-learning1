@extends('layouts.admin.adminlayout')
@section('header_scripts')
<link href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css" rel="stylesheet">
@stop
@section('content')

<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{url('/')}}"><i class="mdi mdi-home"></i></a> </li>
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
								
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						
						<div class="pull-right messages-buttons">
							 
							<a href="/departments/add-department" class="btn  btn-primary button" >{{ getPhrase('create_department')}}</a>
							 
						</div>
						<h1>{{ $title }}</h1>
					</div>
					<div class="panel-body packages">
						
						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>{{ getPhrase('sno')}}</th>
									<th>{{ getPhrase('name')}}</th>
									<th>{{ getPhrase('code')}}</th>
									<th>{{ getPhrase('slug')}}</th>
									<th>{{ getPhrase('description')}}</th>
									<th>{{ getPhrase('action')}}</th>
								  
								</tr>
							</thead>
							 
						</table>

					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
@endsection
 

@section('footer_scripts')
 	<script src="/js/bootstrap-toggle.min.js"></script>
 	<script src="/js/jquery.dataTables.min.js"></script>
	<script src="/js/dataTables.bootstrap.min.js"></script>
	<!-- <script src="/js/scripts/datatables.js"></script> -->
  <script>
  var tableObj;
    $(document).ready(function(){
   		 tableObj = $('.datatable').DataTable({
	            processing: true,
	            serverSide: true,
	            ajax: '{{ route('departments.dataTable') }}',
	    });
    });
  </script>

<script>

	function deleteRecord(slug) {
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
		  	route = '/departments/delete/'+slug;  
		    $.ajax({
		        url:route,
		        type: 'post',
		        data: {_method: 'delete', _token :token},
		        success:function(msg){
		        	tableObj.ajax.reload();
		        	swal("Deleted!", "Your record has been deleted. ", "success");
		        }
		    });

		  } else {
		    swal("Cancelled", "Your record is safe :)", "error");
		  }
	});
	}
</script>

@stop
