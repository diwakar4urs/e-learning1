@extends($layout)
@section('header_scripts')
<link href="{{CSS}}ajax-datatables.css" rel="stylesheet">
@stop
@section('content')

<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="{{URL_LIBRARY_LIBRARYDASHBOARD}}">{{ getPhrase('library_dashboard')}}</a></li>

							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
				<div class="panel panel-custom">
					<div class="panel-heading">
						<h1>{{ $title }}</h1>
					</div>
					<div class="panel-body packages">
						<div> 
						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>{{ getPhrase('image')}}</th>
									<th>{{ getPhrase('roll_no')}}</th>
									<th>{{ getPhrase('name')}}</th>
									<th>{{ getPhrase('academic_details')}}</th>
								 	<th>{{ getPhrase('asset no')}}</th>
								 	<th>{{ getPhrase('asset_name')}}</th>
									<th>{{ getPhrase('email')}}</th>
									<th>{{ getPhrase('date-_issue/_return')}}</th>
									<th id="helper_step1">{{ getPhrase('return')}}</th>
 						</tr>
							</thead>
							 
						</table>
						</div>
						 

					</div>

				</div>
			</div>
     <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{getPhrase('student_book_return')}}</h4>
      </div>
      <div class="modal-body">
      {!!Form::open(array('url'=> URL_LIBRARY_RETURN_ASSET,'method'=>'POST','name'=>'userstatus'))!!} 

      <span id="message"></span>
         
        <input type="hidden" name="user_id" id="user_id" >
        <input type="hidden" name="issue_id" id="id" >
        <input type="hidden" name="instance_id" id="library_instance_id" >
        <input type="hidden" name="master_id" id="master_asset_id" >
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        <button type="submit" class="btn btn-primary" >Yes</button>
      </div>
      {!!Form::close()!!}
    </div>

  </div>
</div>

		</div>
@endsection
 
@section('footer_scripts')
 @include('common.datatables', array('route'=>'librarydashboard.datatable'))
   
    <script >
 	 
 		function changeStatus(user_id, id,library_instance_id,master_asset_id)
 		{
 			$('#user_id').val(user_id);
 			$('#id').val(id);
 			$('#library_instance_id').val(library_instance_id);
 			$('#master_asset_id').val(master_asset_id);
 			message = '{{ getPhrase('are_you_sure_to_return_the_book')}}?'; 
 		
 			$('#message').html(message);

 			$('#myModal').modal('show');
 		}
  
 </script>


 @stop
