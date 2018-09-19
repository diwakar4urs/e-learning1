@extends($layout)
@section('header_scripts')
 {!! Charts::assets() !!}
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
                       

                    <li><a href="{{URL_USERS."staff"}}">{{ getPhrase('staff_users') }}</a> </li>
                    @endif
                    <li><a href="{{URL_STAFF_DETAILS.$record->slug}}">{{ $record->name }} {{getPhrase('details') }}</a> </li> 
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
								
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						
						<div class="pull-right messages-buttons">
							 
						</div>
						<h1>{{ $title }}</h1>
					</div>
					<div class="panel-body packages">
					<?php $lessionPlanObject = new App\LessionPlan();?>
				 @foreach($subjects as $subject)
				 <?php 

				 $summary = $lessionPlanObject->getSubjectCompletedStatus($subject->subject_id, $subject->staff_id, $subject->id);
				 $percent_completed = round($summary->percent_completed);
				 ?>
				
				    <div class="col-md-3 text-center">
				    <div class="lesson-plane-dashboard">
				    <div class="chart-title">
				    	
				    
				    <h4 title="{{$subject->subject_title}}">{{$subject->subject_title}}</h4>
				    	{{$subject->course_title}}
				    </div>
				    
				    	 <a class="card-footer text-muted" href="{{URL_LESSION_PLANS_VIEW_TOPICS.$user->slug.'/'.$subject->slug}}"> 
				    <?php   $chart = Charts::create('percentage', 'justgage')
								    ->title('')
								    ->elementLabel('')
								    ->values([$percent_completed,0,100])
								    ->responsive(false)
								    ->height(150)
								    ->width(0);
    				?>
    				 {!! $chart->render() !!}
 
					 </a>
</div>
					</div>
				@endforeach
					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
@stop
@section('footer_scripts')

@stop
