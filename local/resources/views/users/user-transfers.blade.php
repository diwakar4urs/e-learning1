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
                       

                    <li><a href="{{URL_USERS."student"}}">{{ getPhrase('student_users') }}</a> </li>
                    @endif

                        @if(checkRole(getUserGrade(7)))
                   <li><a href="{{URL_PARENT_CHILDREN}}">{{ getPhrase('children') }}</a> </li>
                   @endif
                   <li><a href="{{URL_USER_DETAILS.$record->slug}}">{{ $record->name }} {{getPhrase('details') }}</a> </li> 
                   
                        
                        
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
								
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
					<div>
						
						<h1>{{$record->name}} {{getPhrase('transfer_list')}}</h1>

						</div>
					
					<div class="panel-body packages" id="myForm">
						<div> 
						<table class="table table-striped table-bordered student-attendance-table datatable" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>{{ getPhrase('sno')}}</th>
									<th>{{ getPhrase('type')}}</th>
									@if($course_time>1 && $having_semisters->is_having_semister!=0)
									<th>{{ getPhrase('from (_admission_year-_course-_year-_semester)')}}</th>
									<th>{{ getPhrase('to (_admission_year-_course-_year-_semester)')}}</th>
									@elseif($course_time>1 && $having_semisters->is_having_semister==0)
									<th>{{ getPhrase('from (_admission_year-_course-_year)')}}</th>
									<th>{{ getPhrase('to (_admission_year-_course-_year)')}}</th>
									@endif
									@if($course_time<=1)
									<th>{{ getPhrase('from (_admission_year-_course)')}}</th>
									<th>{{ getPhrase('to (_admission_year-_course)')}}</th>
									@endif
									<th>{{ getPhrase('remarks')}}</th>
									<th>{{ getPhrase('date')}}</th>
									
								</tr>
							</thead>
							<?php $sno = 1; ?>
							@foreach($student_data as $data)
							<tr>
								<td>{{$sno++}}</td>
								<td>{{ucfirst($data->type)}}</td>
								
								<td>{{getacademictitle($data->from_academic_id)}} - {{getcoursetitle($data->from_course_id, $data->from_year, $data->from_semister,$having_semisters->is_having_semister)}}</td>
								<td>{{gettransferacademictitle($data->type,$data->to_academic_id , $data->to_year, $data->to_semister)}} - {{gettransfercoursetitle($data->type,$data->to_course_id, $data->to_year, $data->to_semister)}}</td>
								<td>{{ucfirst($data->remarks)}}</td>
                                <td>{{$data->created_at}}</td>
							</tr>
							@endforeach
						</table>
						</div>
						
					</div>
				</div>

			</div>
		</div>

@endsection
@section('footer_scripts')
  
@stop
