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
							<li><a href="{{url('/')}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="{{URL_LIBRARY_LIBRARYDASHBOARD}}">{{ getPhrase('library_dashboard')}}</a></li>
							<li><a href="{{URL_LIBRARY_MASTERS}}">{{ getPhrase('masters')}}</a></li>
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
								
				<!-- /.row -->
					@include('library.library-masters.collections.instance-list-information', array('master_record' => $master_record))
				<div class="panel panel-custom">
					<div class="panel-heading">
						
						<div class="pull-right messages-buttons">
							<a href="{{URL_LIBRARY_COLLECTIONS_ADD}}{{ $master_record->slug }}" class="btn  btn-primary button helper_step1" >{{ getPhrase('create')}}</a>
						</div>
						<h1>{{ $title }}</h1>
					</div>
					<div class="panel-body packages">

						<div> 
						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>{{ getPhrase('asset_no')}}</th>
									<th>{{ getPhrase('type')}}</th>
									<th>{{ getPhrase('status')}}</th>
									<th id="helper_step2">{{ getPhrase('action')}}</th>
								  
								</tr>
							</thead>
							 
						</table>
						</div>

					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
			<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{getPhrase('asset_status')}}</h4>
      </div>
      <div class="modal-body">
      {!!Form::open(array('url'=> URL_LIBRARY_COLLECTIONS_STATUS,'method'=>'POST','name'=>'collection_status'))!!} 

      <span id="message"></span>

        <input type="hidden" name="asset_no" id="asset_no" >
        <input type="hidden" name="current_status" id="current_status" >
      
        
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
  
 @include('common.datatables', array('route'=>URL_LIBRARY_COLLECTIONS_LIST.$master_record->slug,'route_as_url' => TRUE))
 @if(count($records))
 @include('common.deletescript', array('route'=>URL_LIBRARY_MASTERS_COLLECTIONS_DELETE,'route_as_url' => TRUE))
 @endif
 <script >
 	 
 		function changeStatus(asset_no, status)
 		{
 			
 			$('#asset_no').val(asset_no);
 			$('#current_status').val(status);
 			
 			$('#myModal').modal('show');
 		}

  
 </script>


@stop
