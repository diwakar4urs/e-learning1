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
                         @if(checkRole(getUserGrade(2)))
                       <li><a href="{{URL_USERS_DASHBOARD}}">{{ getPhrase('users_dashboard') }}</a> </li>
                       
                      @if($record->role_id==5)
                    <li><a href="{{URL_USERS."student"}}">{{ getPhrase('student_users') }}</a> </li>
                    <li><a href="{{URL_USER_DETAILS.$record->slug}}">{{ $record->name }} {{getPhrase('details') }}</a> </li> 
                    @endif
                     @if($record->role_id==3)
                    <li><a href="{{URL_USERS."staff"}}">{{ getPhrase('staff_users') }}</a> </li>
                    <li><a href="{{URL_STAFF_DETAILS.$record->slug}}">{{ $record->name }} {{getPhrase('details') }}</a> </li> 
                    @endif

                    @endif

                        @if(checkRole(getUserGrade(7)))
                   <li><a href="{{URL_PARENT_CHILDREN}}">{{ getPhrase('children') }}</a> </li>
                   @endif
                  
							
							 <li>{{$title}}</li>
						</ol>
					</div>
				</div>
								
				<!-- /.row -->
				<div class="panel panel-custom">
				  <div class="panel-heading">
				  <h1>{{$title}}</h1>
				  </div>

					
					<div class="panel-body packages">
						<div > 
						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
							<thead>
								<tr>
								     

                                    <th>{{ getPhrase('asset_no')}}</th>
									<th>{{ getPhrase('master_asset_name')}}</th>
								 	<th>{{ getPhrase('issue_on')}}</th>
								 	<th>{{ getPhrase('due_date')}}</th>
								 	<th>{{ getPhrase('status')}}</th>
									<th>{{ getPhrase('return_on')}}</th>

									
								</tr>
							</thead>
							 
						</table>
						</div>
						 

					</div>

				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
@endsection
 
@section('footer_scripts')

 @include('common.datatables', array('route'=>URL_USER_LIBRARY_DETAILS_GETLIST.$record->id, 'route_as_url'=>true))
 
@stop


