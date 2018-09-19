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

							@if($role =='student')
							<li><a href="{{URL_LIBRARY_USERS}}student">{{ getPhrase('student_users')}}</a></li>	
							@endif
							@if($role == 'staff')
							<li><a href="{{URL_LIBRARY_USERS}}staff">{{ getPhrase('staff_users')}}</a></li>
							@endif
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
				<input type="hidden" id="user_id" value="{{$user->id}}">
				<!-- /.row -->
				<div class="panel panel-custom" ng-controller="libraryIssues">
				<?php 
					$books_issued = (new App\LibraryIssue())->getCurrentIssuedRecords($user->id);
					$books_history = App\LibraryIssue::where('user_id',$user->id)
									->orderBy('issued_on', 'desc')
									->get();
				 ?>
					@include('library.users.statistics', 
					array('user'=>$user, 'books_issued'=>$books_issued, 'books_history'=>$books_history)
					)

					<div class="panel-body">
						<ul class="nav nav-tabs add-student-tabs">
							<li class="active"><a data-toggle="tab" href="#profile">{{ getPhrase('profile') }}</a></li>
							<li><a data-toggle="tab" href="#academic_details">{{ getPhrase('books_taken') }}</a></li>
							<li><a data-toggle="tab" href="#personal_details">{{ getPhrase('issue_book')}}</a></li>
							<li><a data-toggle="tab" href="#contact_details">{{ getPhrase('history') }}</a></li>
							
						</ul>

						<div class="tab-content tab-content-style">
							<div id="profile" class="tab-pane fade in active">
							@if($role=='student')
								@include('users.student.student-profile', array('student'=>$student, 'user'=>$user))
							@endif

							@if($role=='staff')

								@include('users.staff.staff-profile-library', array('staff'=>$staff, 'user'=>$user))
							@endif

							</div>

							<div id="academic_details" class="tab-pane fade">

								@include('library.users.assets_taken', array('user'=>$user, 'books_issued'=>$books_issued))


							</div>

							<div id="personal_details" class="tab-pane fade">
                              @if($role=='student')

								@include('library.users.issue-asset-sub-view')

                               @endif

                                @if($role=='staff')

								@include('library.users.staff-issue-asset-sub-view')

                               @endif
							</div>

							<div id="contact_details" class="tab-pane fade">
								@include('library.users.transaction-history', array('user'=>$user, 'books_issued'=>$books_issued, 'books_history'=>$books_history))
							</div>

							 
						</div>



					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
@endsection


<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
@section('footer_scripts')
 @include('common.deletescript', array('route'=>URL_LIBRARY_MASTERS_COLLECTIONS_DELETE))
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>

<script >
  $(function() {
        $("#auto").autocomplete({
            source: "{{URL_LIBRARY_ISSUES_GET_REFERENCE}}",
            minLength: 1,
            select: function( event, ui ) {
                $('#response').val(ui.item.id);
                getAssetDetails(ui.item.id);
            }
        });
    });	

  function getAssetDetails(asset_id) {
  	user_id = $('#user_id').val();
  	route = '{{URL_LIBRARY_ISSUES_GET_MASTER_DETAILS}}';  
  	token = $('[name="_token"]').val();
		    $.ajax({
		        url:route,
		        type: 'post',
		         dataType: 'json',
		        data: {_method: 'post', 'asset_id': asset_id, 'user_id': user_id, '_token':token},
		        success:function(data){
		        	$('#master_details').html(data.master_details);
		        	$('#asset_details').html(data.instance_details);
		        	$('#asset_image').html(data.image);
		        	$('#button').html(data.button);
		        	 
		         
		        }
		    });
  }
</script>


<script >
  $(function() {
        $("#staff-auto").autocomplete({
            source: "{{URL_LIBRARY_ISSUES_GET_REFERENCE_STAFF}}",
            minLength: 1,
            select: function( event, ui ) {
                $('#response').val(ui.item.id);
                getAssetDetails(ui.item.id);
            }
        });
    });	

  function getAssetDetails(asset_id) {
  	user_id = $('#user_id').val();
  	route = '{{URL_LIBRARY_ISSUES_GET_MASTER_DETAILS}}';  
  	token = $('[name="_token"]').val();
		    $.ajax({
		        url:route,
		        type: 'post',
		         dataType: 'json',
		        data: {_method: 'post', 'asset_id': asset_id, 'user_id': user_id, '_token':token},
		        success:function(data){
		        	$('#master_details').html(data.master_details);
		        	$('#asset_details').html(data.instance_details);
		        	$('#asset_image').html(data.image);
		        	$('#button').html(data.button);
		        	 
		         
		        }
		    });
  }
</script>
@stop
