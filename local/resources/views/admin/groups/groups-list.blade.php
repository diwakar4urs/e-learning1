@extends('layouts.admin.adminlayout')
@section('content')

<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{url('/')}}"><i class="mdi mdi-home"></i></a> </li>
							<li>{{ getPhrase('user_groups')}}</li>
						</ol>
					</div>
				</div>
								
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						
						<div class="pull-right messages-buttons">
							 
							<a class="btn  btn-primary button" href="#">{{ getPhrase('add_group')}}</a>
						</div>
						<h1>{{ getPhrase('groups')}}</h1>
					</div>
					<div class="panel-body packages">
						
						<table id="exams_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>{{ getPhrase('sno')}}</th>
									 
									<th>{{ getPhrase('group_name')}}</th>
									<th>{{ getPhrase('action')}}</th>
								</tr>
							</thead>
							<tbody>
							
							@foreach($groups as $record)
								<tr>
								<td>{{$record->id}}</td>
									<td>  {{ucfirst($record->group)}} </td>
									 
									<td>
										<div class="dropdown more">
											<a id="dLabel" type="button" class="more-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="mdi mdi-dots-vertical"></i>
											</a>
											<ul class="dropdown-menu" aria-labelledby="dLabel">
												<li><a href="/users/edit-group/{{$record->id}}"><i class="icon-packages"></i> {{ getPhrase('edit')}}</a></li>
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
@endsection