 <div class='containerVertical' id="target_{{$angular_key}}"  ng-drop="true" ng-drop-success="onDropComplete($data,$event, '{{$yearno.'_'.$semister}}')">
       <div ng-if="!target_items['{{$angular_key}}'].length" class="subject-placeholder"> {{getPhrase('no_item_selected')}}</div>
           		<div ng-repeat="item in target_items['{{$angular_key}}']" class="items-sub selected-subjects" id="target_items-@{{item.id}}">@{{item.subject_title}}

           		<input type="hidden" name="selected_list['{{$angular_key}}'][]" data-myname="@{{item.subject_title}}" value="@{{item.id}}">
           		<div class="add-delete-classes ">
           		
           		<input type="text" ng-if="item.sessions_needed == null" name="total_classes['{{$angular_key}}'][]" value="@{{default_classes_needed}}" title="{{getPhrase('number_of_sessions_needed')}}"> 

           		<input type="text" id="sessions" ng-if="item.sessions_needed != null" name="total_classes['{{$angular_key}}'][]" value="@{{item.sessions_needed}}" title="{{getPhrase('number_of_sessions_needed')}}"> 

           		<i class="fa fa-trash text-danger pull-right" ng-click="removeItem(item, target_items['{{$angular_key}}'], 'target_items', '{{$academic_id}}','{{$course_id}}','{{$yearno}}','{{$semister}}')" title="{{getPhrase('delete')}}"></i>

           		<i ng-if="item.is_lab==1" class="fa fa-flask pull-right text-primary" title="{{getPhrase('lab')}}" aria-hidden="true"></i> 
           		
           			
					<i ng-if="item.is_elective_type==1" class="fa fa-hand-pointer-o pull-right text-info" title="{{getPhrase('elective')}}" aria-hidden="true"></i>
           		</div>
					
           		
           		</div>

       		 </div>


