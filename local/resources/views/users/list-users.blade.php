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
							<li><a href="{{URL_USERS_DASHBOARD}}">{{getPhrase('users_dashboard')}}</a></li>
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>  
				        @if(!count($academic_details)||!count($course_details))
	       				<div class="alert alert-warning">
                              <strong>{{getPhrase('Note:')}}</strong> {{getPhrase('please_update_master_setup_details_before_creating_users.')}}
                         </div>	
                         @endif	
				<!-- /.row -->
				<div class="panel panel-custom" >
					<div class="panel-heading">
						
						<div class="pull-right messages-buttons helper_step1">
							@if($role=='student') 
							<a href="{{URL_USERS_IMPORT}}" class="btn  btn-primary button" >{{ getPhrase('import_excel')}}</a>
							@endif
							@if(count($academic_details)&&count($course_details))
							<a href="{{URL_USERS_ADD}}" class="btn  btn-primary button" >{{ getPhrase('add_user')}}</a>
							 @endif
							 @if(!count($academic_details)||!count($course_details))
							 <a href="javascript:void(0);" class="btn  btn-primary button" onclick="showMessage()" >{{ getPhrase('add_user')}}</a>
							  @endif	
						</div>
						<h1>{{ $title }}</h1>
						@if($role=='student')
						<div class="alert alert-info">
                              <strong>{{getPhrase('Note:')}}</strong> {{getPhrase('If do not update the student admission details, those students are available in all users list.')}}&nbsp;&nbsp;&nbsp;{{getPhrase('for all users list')}}  &nbsp;<a href="{{URL_USERS."users"}}" class="btn  btn-warning button btn-xs">{{ getPhrase('Click here')}}</a>
                           </div>
                           @endif
					</div>
					<div class="panel-body packages">
						<div > 
						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
							<thead>
								<tr>
								     @if($role =='student')

                                    <th id="helper_step2">{{ getPhrase('name')}}</th>
									<th>{{ getPhrase('image')}}</th>
								 	<th>{{ getPhrase('roll_no')}}</th>
								 	<th>{{ getPhrase('course')}}</th>
								 	<th>{{ getPhrase('year-semester')}}</th>
									<th>{{ getPhrase('email')}}</th>
									<th  id="helper_step3">{{ getPhrase('action')}}</th>

									@elseif($role=='staff')

									<th>{{ getPhrase('name')}}</th>
									<th>{{ getPhrase('image')}}</th>
									<th>{{ getPhrase('staff_id')}}</th>
									<th>{{ getPhrase('job_title')}}</th>
									<th>{{ getPhrase('branch')}}</th>
									<th>{{ getPhrase('email')}}</th>
									<th>{{ getPhrase('action')}}</th>

									@elseif($role=='users')

									<th>{{ getPhrase('name')}}</th>
									<th>{{ getPhrase('image')}}</th>
									<th>{{ getPhrase('email')}}</th>
								    <th>{{ getPhrase('role')}}</th>
                                    <th>{{ getPhrase('action')}}</th>

                                    @else

									<th>{{ getPhrase('name')}}</th>
									<th>{{ getPhrase('image')}}</th>
									<th>{{ getPhrase('email')}}</th>
                                    <th>{{ getPhrase('action')}}</th>
                                    
									@endif
								</tr>
							</thead>
							 
						</table>
						</div>
						 

					</div>

				</div>
			</div>
			<!-- /.container-fluid -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{getPhrase('staff_status')}}</h4>
      </div>
      <div class="modal-body">
      {!!Form::open(array('url'=> URL_STAFF_EDIT_PROFILE_STATUS,'method'=>'POST','name'=>'userstatus'))!!} 

      <span id="message"></span>

        <input type="hidden" name="user_slug" id="user_slug" >
        <input type="hidden" name="current_status" id="current_status" >
        <input type="hidden" name="user_id" id="user_id" >

        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        <button type="submit" class="btn btn-primary" >Yes</button>
      </div>
      {!!Form::close()!!}
    </div>

  </div>
</div>
<div id="myUserModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b>{{getPhrase('update_master_setup')}}</b></h4>
      </div>
      <div class="modal-body">
       
        <h4 style="color: #ffa616;" >{{getPhrase('please_update_master_setup_details')}}</h4 textalign="center">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">{{getPhrase('ok')}}</button>
      </div>
      
    </div>

  </div>
</div>
		</div>
@endsection
 
@section('footer_scripts')
 @include('common.datatables', array('route'=>URL_USERS_LIST_GETLIST.$role, 'route_as_url'=>true))
 @include('common.deletescript', array('route'=>URL_USERS_DELETE))
 <script >
 	 
 		function changeStatus(user_slug, status,user_id)
 		{
 			$('#user_slug').val(user_slug);
 			$('#current_status').val(status);
 			$('#user_id').val(user_id);
 			message = '{{ getPhrase('are_you_sure_to_make_user_active')}}?'; 
 			if(status==1)
 			message = '{{ getPhrase('are_you_sure_to_make_user_inactive')}}?'; 
 			$('#message').html(message);

 			$('#myModal').modal('show');
 		}

 		function showMessage(){
           $('#myUserModal').modal('show');
 		}
  
 </script>
@stop
