@extends($layout)
@section('content')

<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							
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
                  
                  {!!Form::open(array('url'=>URL_LESSION_PLANS_VIEW_STUDENTS,'method'=>'POST','name'=>'studentList'))!!}

                 
				 <?php 

				 $summary = $lessionPlanObject->getSubjectCompletedStatus($subject->subject_id, $subject->staff_id, $subject->id);
				 $percent_completed = round($summary->percent_completed);
				 ?>
				    <div class="col-md-3">
						<div class="card {{getDashboardBoxColor()}} text-xs-center card-progress">
							<div class="card-lg-padding">
								<h4 class="card-title card-title-sm">{{ $subject->subject_title}}</h4>
								<p class="card-text">{{ $subject->course_title}}</p>

										  <input type="hidden" name="academic_id" value="{{$subject->academic_id}}" >
						                  <input type="hidden" name="course_id"   value="{{$subject->course_id}}" >
						                  <input type="hidden" name="course_parent_id"   value="{{$subject->course_parent_id}}" >
						                  <input type="hidden" name="year"        value="{{$subject->year}}" >
						                  <input type="hidden" name="semister"    value="{{$subject->semister}}" >
						                  
								@if($subject->course_dueration>1)
								    @if($subject->semister!=0)
								<p class="card-text">{{ $subject->year.' '.getPhrase('year').' - '.$subject->semister.' '.getPhrase('semester')}}</p>
								      @else
								      <p class="card-text">{{ $subject->year.' '.getPhrase('year')}}</p>
                                    @endif
								@endif

							</div>
							
							<div >

							<button class="btn card-footer text-muted"

							>{{ getPhrase('view_students') }}</button>

						</div>
						
						
						</div>
					</div>
					 {!!Form::close()!!}
				@endforeach

				     
					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
@stop
@section('footer_scripts')

@stop
