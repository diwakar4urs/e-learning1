<div class="panel-heading">
		<h2>{{getPhrase('lesson_plan_statistics')}}</h2></div>
 	
	 <div class="panel panel-primary dsPanel">
				    
				    	<div class="panel-body packages">
					<?php $lessionPlanObject = new App\LessionPlan();
					$user = Auth::user();
					$subjects = App\LessionPlan::getSubjects($user->id, 4, 'rand');
					?>
				 @foreach($subjects as $subject)
				 <?php 

				 $summary = $lessionPlanObject->getSubjectCompletedStatus($subject->subject_id, $subject->staff_id, $subject->id);
				 $percent_completed = round($summary->percent_completed);
				 ?>
				
				    <div class="col-md-6 text-center">
				    <div class="lesson-plane-dashboard">
				    <strong title="{{$subject->subject_title}}">
				    	{{$subject->subject_title}}
				    </strong>
				    
				    	 <a class="text-muted" href="{{URL_LESSION_PLANS_VIEW_TOPICS.$user->slug.'/'.$subject->slug}}"> 
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