 		 	<div class="panel-heading countdount-heading">
					<h2>{{getPhrase('staff_list')}}</h2>
				</div>
 				
				<div class="panel-body">
				<div class="search-draggable-item clearfix">
				<i class="fa fa-search" aria-hidden="true"></i>
                    <input type="text" class="form-control input-lg" name="search" ng-model="search" placeholder="{{getPhrase('search')}}" />
                   
                </div>

                    <div class="" id="source">
					 
					<ul class="list-replay list-sidebar">
					<li ng-repeat="item in source_items | filter:search " ng-drag="true" ng-drag-data="item" ng-drag-success="onDragComplete($data,$event)" >
							<a href="">
								<img ng-if="item.image==null || item.image==''" src="{{IMAGE_PATH_USERS_DEFAULT_THUMB}}" alt="">
								<img ng-if="item.image!=null && item.image!=''" src="{{IMAGE_PATH_USERS_THUMB}}@{{item.image}}" alt="">
								<h4>@{{item.name | uppercase}} <span class="time"><i class="fa fa-mars-stroke"></i> @{{item.gender | uppercase}}</span></h4>
								<p>
									<strong>Designation:</strong> @{{item.job_title}} &nbsp;&nbsp;&nbsp;
									<strong>Qualification:</strong> @{{item.qualification}}
								</p>
								<i class="mdi arrow-link mdi-chevron-right"></i>
								<ul class="hover-fab-list list-unstyled">
									<li class="heading">{{getPhrase('preferred_subjects')}}</li>
		
									<li ng-if="item.preference.length > 0" ng-repeat="preference in item.preference">
									
										@{{preference.subject_title}} 
										<i ng-if="preference.is_lab==1" class="fa fa-flask"></i>
									
									</li>

									<li ng-if="item.preference.length == 0">
										{{getPhrase('no_subjects_selected')}}	
									</li>

									
								</ul>
							</a>
					</li>

					</ul>
			 		 
				</div>
	 			 
				</div>