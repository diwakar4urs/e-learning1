@extends($layout)
@section('content')

<div id="page-wrapper" ng-controller="lessionPlanController" ng-init="ingAngData({{$items}})">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							 @if($user=='admin'||$user=='owner')
                                 
							<li><a href="{{URL_STAFF_DETAILS.$user->slug}}">{{ getPhrase('staff_dashboard')}}</a> </li>
							@endif
							<li><a href="{{URL_LESSION_PLANS_DASHBOARD.$user->slug}}">{{ getPhrase('lesson_plans')}}</a> </li>
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
					
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						
						 
						<h1>{{ $title }}</h1>
					</div>

					<div class="panel-body" ng-repeat="topic in topics">

					<h4 class="title">@{{topic.topic_name}}</h4>

					<ul class="row topic-list">
						<li class="col-md-6" ng-if="topic.childs.length != 0 " ng-repeat="subtopic in topic.childs">
						 
							<div class="topics clearfix">
								<div class="checkbox custom-checkbox">
								    <label>
									
								    <input 
								    ng-if="subtopic.is_completed==null || subtopic.is_completed==0"
								    @if($role_name=='staff')
								    ng-click="updateTopic(subtopic.id, topic.course_subject_id, 1)"
								    
								    @else 
								    disabled="" 
								    @endif
								    
								    type="checkbox">
								    
								    <input 
								    ng-if="subtopic.is_completed!=null && subtopic.is_completed!=0"
								    @if($role_name=='staff')
								    ng-click="updateTopic(subtopic.id, topic.course_subject_id, 0)"
								    readonly="true" 
								    @else 
								    disabled="" 
								    @endif
								    checked type="checkbox">

								    
								    <div class="item-checkbox">								    	
								    	<i class="fa fa-check checked" aria-hidden="true"></i>
								    </div>
								    </label>
								  </div>
							 

							<h4  ng-if="subtopic.is_completed==null || subtopic.is_completed==0" >@{{subtopic.topic_name | capitalize}}</h4>
							<h4 ng-if="subtopic.is_completed!=null && subtopic.is_completed!=0" class="text-primary">@{{subtopic.topic_name | capitalize}}</h4>
							<div class="form-group" ng-if="subtopic.is_completed!=null && subtopic.is_completed!=0" >
								<span>@{{subtopic.completed_on}}</span>
							</div>
							</div>

						</li>
						 <li ng-if="topic.childs.length==0">
							 <div class="topics clearfix">
							 	<h4>{{getPhrase('no_topics_available')}}</h4>
							 </div>
						 </li>
						
					</ul>

					
				  
					</div>


				</div>


			</div>
			<!-- /.container-fluid -->
		</div>
@stop
@section('footer_scripts')
@include('staff.lessionplans.scripts.js-scripts')
@include('common.alertify')
 @stop
