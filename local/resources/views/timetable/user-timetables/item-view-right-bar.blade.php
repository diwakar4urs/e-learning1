 		 	<div class="panel-heading countdount-heading">
					<h2>{{getPhrase('completed_topics_list')}}</h2>
				</div>
 				
				<div class="panel-body">
					<ul class="offer-list">
						<li ng-repeat="topic in topics_completed">
						<i class="fa fa-check text-success"></i> @{{topic.topic_name}} in <strong>@{{topic.subject_title}} </strong> </li>
						
						<li ng-if="topics_completed.length<=0">
						 {{getPhrase('no_list_available')}}/{{getPhrase('select_other_class')}}</li>
					</ul>
				</div>