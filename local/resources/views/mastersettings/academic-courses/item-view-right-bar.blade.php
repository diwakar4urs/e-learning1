
		 	<div class="panel-heading countdount-heading">
					<h2>{{getPhrase('course_list')}}</h2>
				</div>
								
				<div class="panel-body">
				<div class="search-draggable-item clearfix">
				<i class="fa fa-search" aria-hidden="true"></i>
                    <input type="text" class="form-control input-lg" name="search" ng-model="search" placeholder="{{getPhrase('search')}}" />
                   
                </div>


				<div class="draggable-item-list" id="source">
					<div ng-repeat="item in courses | filter:search track by $index" class="items-sub"
					ng-drag="true" ng-drag-data="item" ng-drag-success="onDragComplete($data,$event)" 	
					>@{{item.course_title}}
					<input type="hidden" name="course_id[]" data-myname="@{{item.course_title}}"  value="@{{item.id}}">
					<input type="hidden" name="parent_id[]" value="@{{item.parent_id}}">
					</div>
				</div>
	 

				</div>