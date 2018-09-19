 				{{-- {{dd($data['item'])}} --}}

		 	<div class="panel-heading countdount-heading">
					<h2>{{getPhrase('subjects_list')}}</h2>
				</div>
								
				<div class="panel-body">
				<div class="search-draggable-item clearfix">
				<i class="fa fa-search" aria-hidden="true"></i>
                    <input type="text" class="form-control input-lg" name="search" ng-model="search" placeholder="{{getPhrase('search')}}" />
                   
                </div>


				<div class="draggable-item-list" id="source">
					<div ng-repeat="item in source_items | filter:search track by $index" class="items-sub"
					ng-drag="true" ng-drag-data="item" ng-drag-success="onDragComplete($data,$event)" 	
					>@{{item.subject_title}}
					
					
					<i ng-if="item.is_lab==1" class="fa fa-flask pull-right text-primary" title="{{getPhrase('lab')}}" aria-hidden="true"></i> 
					
					<i ng-if="item.is_elective_type==1" class="fa fa-hand-pointer-o pull-right text-info" title="{{getPhrase('elective')}}" aria-hidden="true"></i>
					
					<input type="hidden" data-myname="@{{item.subject_title}}"  value="@{{item.id}}">
					
					</div>
				</div>
	 			<p>&nbsp;&nbsp;</p>
	 			<i class="fa fa-flask text-primary" title="{{getPhrase('lab')}}" aria-hidden="true"></i> &nbsp;&nbsp;{{getPhrase('lab')}}
	 			&nbsp;&nbsp;
				<i class="fa fa-hand-pointer-o text-info" title="{{getPhrase('elective')}}" aria-hidden="true"></i>&nbsp;&nbsp;
				{{getPhrase('elective')}}
				</div>