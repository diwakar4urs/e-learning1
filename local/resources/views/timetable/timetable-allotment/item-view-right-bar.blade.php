 		 	<div class="panel-heading countdount-heading">
					<h2>{{getPhrase('staff_list')}}</h2>
				</div>
 				
				<div class="panel-body">
				<div class="search-draggable-item clearfix">
				<i class="fa fa-search" aria-hidden="true"></i>
                    <input type="text" class="form-control input-lg" name="search" ng-model="search" placeholder="{{getPhrase('search')}}" />
                   
                </div>

                <div ng-hide="showCalender" >
                Please select academic year and course
                </div>
				<div ng-show="showCalender" class="" id="source">
					 
					<ul class="list-replay list-sidebar">
					<li ng-repeat="item in source_items | filter:search " ng-drag="true" ng-drag-data="item.staff_record" ng-drag-success="onDragComplete($data,$event)" >
							<a href="">
								<img ng-if="item.staff_record.image==null || item.staff_record.image==''" src="{{IMAGE_PATH_USERS_DEFAULT_THUMB}}" alt="">
								<img ng-if="item.staff_record.image!=null && item.staff_record.image!=''" src="{{IMAGE_PATH_USERS_THUMB}}@{{item.staff_record.image}}" alt="">
								<h4>@{{item.staff_record.name | uppercase}} <span class="time"><i class="fa fa-mars-stroke"></i> @{{item.staff_record.gender | uppercase}}</span></h4>
								<p>
									<strong>Subject:</strong> @{{item.staff_record.subject_title+' ('+item.staff_record.subject_code+')'}} 
									 <i ng-if="item.staff_record.is_lab" class="fa fa-flask text-primary"></i>
									 <i ng-if="item.staff_record.is_elective" class="fa fa-hand-pointer-o text-primary"></i>
									<br>
									<strong>Designation:</strong> @{{item.staff_record.job_title}} <br>
									<strong>Qualification:</strong> @{{item.staff_record.qualification}}
								</p>
								<i class="mdi arrow-link mdi-chevron-right"></i>
								
								<ul class="hover-fab-list list-unstyled">
								 	<li class="heading">@{{item.staff_record.name}} {{getPhrase('schedule_table')}}</li>
		 
									<div class="table-responsive horizontal-scroll">
									<table class="table slot-booking-information">
									<thead >
										<th>Day</th>
										<th ng-repeat="period in maximum_periods_set" 
											ng-if="period.is_break==0" >
											@{{period.period_name}}
										</th>
										
									</thead>
									<tbody>
										<tr ng-repeat="timemap in timings_map track by $index">
											<th>@{{days[$index+1].day}}</th>
									 		
											<td 										ng-repeat="sub_item in item.schedule_record.timemaps[$index+1].periods" 
											ng-class="{'slot-book': sub_item.is_assigned == 0,'slot-booked': sub_item.is_assigned == 1} "
											ng-if="maximum_periods_set[$index].is_break==0"
											>
											

											</td>
											 
										</tr>
										 
										</tbody>		
									</table>	
									</div>
								</ul>
							</a>
					</li>

					</ul>
			 		 
				</div>
	 			 
				</div>