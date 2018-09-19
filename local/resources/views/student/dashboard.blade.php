@extends($layout)
@section('content')

<div id="page-wrapper">
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<ol class="breadcrumb">

<li>{{ $title}}</li>
</ol>
</div>
</div>
<div class="row">
<div class="col-md-4">
<div class="card card-blue text-xs-center">
<div class="card-block">
<h4 class="card-title"><i class="fa fa-random"></i></h4>
<p class="card-text">{{ getPhrase('quiz_categories')}}</p>
</div>
<a class="card-footer text-muted" href="{{URL_STUDENT_EXAM_CATEGORIES}}">
{{ getPhrase('view_all')}}
</a>
</div>
</div>

<div class="col-md-4">
<div class="card card-yellow text-xs-center">
<div class="card-block">
<h4 class="card-title"><i class="fa fa-clock-o"></i></h4>
<p class="card-text">{{ getPhrase('quizzes')}}</p>
</div>
<a class="card-footer text-muted" href="{{URL_STUDENT_QUIZ_DASHBOARD}}">
{{ getPhrase('view_all')}}
</a>
</div>
</div>

<div class="col-md-4">
<div class="card card-green text-xs-center">
<div class="card-block">
<h4 class="card-title"><i class="fa fa-flag" aria-hidden="true"></i>
</h4>
<p class="card-text">{{ getPhrase('subjects_reports')}}</p>
</div>
<a class="card-footer text-muted" href="{{URL_STUDENT_ANALYSIS_SUBJECT.Auth::user()->slug}}">
{{ getPhrase('view_analysis')}}
</a>
</div>
</div>

<div class="col-md-4">
<div class="card card-red text-xs-center">
<div class="card-block">
<h4 class="card-title"><i class="fa fa-calendar-check-o"></i></h4>
<p class="card-text">{{ getPhrase('attendance_report')}}</p>
</div>
<a class="card-footer text-muted" href="{{URL_STUDENT_ATTENDENCE_REPORT.'/'.Auth::user()->slug}}">
{{ getPhrase('view_report')}}
</a>
</div>
</div>
<div class="col-md-4">
<div class="card card-blue text-xs-center">
<div class="card-block">
<h4 class="card-title"><i class="fa fa-calendar"></i></h4>
<p class="card-text">{{ getPhrase('timetable')}}</p>
</div>
<a target="_blank" class="card-footer text-muted" href="{{URL_TIMETABLE_STAFF_STUDENT_PRINT.Auth::user()->slug }}">
{{ getPhrase('view_report')}}
</a>
</div>
</div>
<div class="col-md-4">
<div class="card card-yellow text-xs-center">
<div class="card-block">
<h4 class="card-title"><i class="fa fa-percent"></i></h4>
<p class="card-text">{{ getPhrase('marks')}}</p>
</div>
<a class="card-footer text-muted" href="{{URL_STUDENT_RESULTS.Auth::user()->slug }}">
{{ getPhrase('view_all')}}
</a>
</div>
</div>

<div class="col-md-4">
<div class="card card-black text-xs-center">
<div class="card-block">
<h4 class="card-title"><i class="fa fa-book"></i></h4>
<p class="card-text">{{ getPhrase('library_history')}}</p>
</div>
<a class="card-footer text-muted" href="{{URL_USER_LIBRARY_DETAILS.Auth::user()->slug }}">
{{ getPhrase('view_all')}}
</a>
</div>
</div>



</div>
<div class="row">
				<div class="col-md-6">
  				  <div class="panel panel-primary dsPanel">
				    <div class="panel-heading"><i class="fa fa-book"></i> {{getPhrase('library_history')}}</div>
				    <div class="panel-body table-responsive" >
				    	<?php 
				    	$records = App\LibraryIssue::issueHistory('',5);
				    	?>

				    	<table class="table ">
				    		<thead>
				    			<tr>
				    				<th>
				    				<strong>{{getPhrase('sno')}}</strong></th>
				    				<th><strong>{{getPhrase('title')}}
				    				</strong></th>
				    				<th><strong>{{getPhrase('number')}}</th>
				    				<th><strong>{{getPhrase('issued')}}
				    				</strong></th>
				    				<th><strong>{{getPhrase('status')}}
				    				</strong></th>
				    			</tr>

				    		</thead>
				    		<tbody>
				    		<?php $sno=1;?>
				    		@if(count($records))
				    		@foreach($records as $record)
				    		<?php $class = 'label label-success';
				    		if($record->issue_type=='issue' || $record->issue_type=='renewal')
				    			$class = 'label label-danger';
				    		if($record->issue_type=='lost')
				    			$class = 'label label-warning';
				    		?>
				    			<tr>
				    				<td>{{$sno++}}</td>
				    				<td>{{$record->title}}</td>
				    				<td>{{$record->library_asset_no}}</td>
				    				<td>{{date('Y-m-d',strtotime($record->issued_on))}}</td>
				    				<td><span class='{{$class}}' >{{ ucfirst($record->issue_type)}}</span></td>
				    			</tr>
				    		@endforeach
				    		@else
				    		<tr>
				    				<td>{{getPhrase('no_data_available')}}</td>
				    		</tr>
				    		@endif
				    		</tbody>
				    	</table>
				    </div>
				  </div>
				</div>

				<div class="col-md-6">
  				  <div class="panel panel-primary dsPanel">
				    <div class="panel-heading"><i class="fa  fa-bell"></i> {{getPhrase("today's_classes")}}</div>
				    <div class="panel-body table-responsive" >
				    	<?php 
				    	$records = App\Timetable::getStudentDayClasses();
				    	 ?>
				    	 <table class="table">
				    		<thead>
				    			<tr>
				    				<th>
				    				<strong>{{getPhrase('sno')}}</strong></th>
				    				<th><strong>{{getPhrase('subject')}}
				    				</strong></th>
				    				<th><strong>{{getPhrase('class')}}</th>
				    				<th><strong>{{getPhrase('from')}}
				    				</strong></th>
				    				<th><strong>{{getPhrase('to')}}
				    				</strong></th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    		<?php $sno=1;?>
				    		@if(count($records))
				    		@foreach($records as $record)
		 
				    			<tr>
				    				<td>{{$sno++}}</td>
				    				<td>{{$record->subject_title}}</td>
				    				<td>{{$record->course_title}}</td>
				    				<td>{{$record->start_time}}</td>
				    				<td>{{ $record->end_time}}</td>
				    			</tr>
				    		@endforeach
				    		@else
				    		<tr>
				    				<td>{{getPhrase('no_data_available')}}</td>
				    		</tr>
				    		@endif
				    		</tbody>
				    	</table>

				    </div>
				  </div>
				</div>
			 
	</div>
<div class="row"><?php $ids=[];?>
@for($i=0; $i<count($chart_data); $i++)
<?php 
$newid = 'myChart'.$i;
$ids[] = $newid; ?>
<div class="col-md-6">  				  <div class="panel panel-primary dsPanel">				   				    <div class="panel-body" >



<canvas id="{{$newid}}" width="100" height="60"></canvas>					   </div>				  </div>				</div>

@endfor	
 			
</div>
</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

@stop

@section('footer_scripts')
@include('common.chart', array($chart_data,'ids' =>$ids));
@stop