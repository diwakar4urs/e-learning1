@extends($layout)
@section('content')

<div id="page-wrapper" >
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="{{URL_COURSES_DASHBOARD}}">{{getPhrase('master_setup_dashboard')}}</a></li>
							<li><a href="{{URL_MASTERSETTINGS_COURSE_SUBJECTS."staff"}}">{{ getPhrase('allocate_staff_to_subject')}}</a> </li>
							
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
						 	
				<!-- /.row -->	
				<div class="panel panel-custom">
					<div class="panel-heading">
						
						 
						<h1 id="helper_step1">{{$subject->subject_title}}</h1>
					</div>
					<div class="panel-body">

					@if(!count($topics))
					<h4>{{getPhrase('no_topics_available')}}</h4>
					@endif

					@foreach($topics as $topic)

					<h4 class="title" id="helper_step2">{{$topic->topic_name}}</h4>
					<ul class="row topic-list">

					@foreach($topic->childs as $child_topic)

					@if(!count($child_topic->topic_name))
					<h4>{{getPhrase('no_topics_available')}}</h4>
					@endif

						<li class="col-md-6" >
							<div class="topics clearfix">
							 
							<h4 id="helper_step3">{{$child_topic->topic_name}}</h4>
							
							</div>

						</li>
					@endforeach
					
					</ul>

					@endforeach
				  
					</div>


				</div>


			</div>
			<!-- /.container-fluid -->
		</div>
@stop
@section('footer_scripts')

 @stop
