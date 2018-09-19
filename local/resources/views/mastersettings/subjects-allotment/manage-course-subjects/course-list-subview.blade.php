 <div class='containerVertical helper_step3' >
 
       <div ng-if="!target_items.length" class="subject-placeholder"> {{getPhrase('no_item_selected')}}</div>
<div class="row align-row-center" ng-repeat="item in target_items" ng-if="item.index=='{{$angular_key.'_'}}'+item.id">
  <div class="col-md-5 ">
    <div  class="items-sub selected-subjects">@{{item.subject_title}}
               
              <div class="add-delete-classes">
          
              <i ng-if="item.is_lab==1" class="fa fa-flask pull-right text-primary" title="{{getPhrase('lab')}}" aria-hidden="true"></i> 
                
          <i ng-if="item.is_elective_type==1" class="fa fa-hand-pointer-o pull-right text-info " title="{{getPhrase('elective')}}" aria-hidden="true"></i>
              </div>
         
              </div>
  </div>

  
  <div  class="col-md-6 ">
    <ul class="list-unstyled list-replay list-sidebar">
      <li id="target_{{$angular_key.'_'}}@{{item.id}}"  ng-drop="true" ng-drop-success="onDropComplete($data,$event, '{{$yearno.'_'.$semister.'_'}}@{{item.id}}','{{$academic_id}}','{{$course_id}}','{{$yearno}}','{{$semister}}',item.user.id,item)">
        <a id="target_items-@{{item.id}}" ng-if="item.user!=null" href="javascript::void(0);">
               <img ng-if="item.user.image==null || item.user.image==''" src="{{IMAGE_PATH_USERS_DEFAULT_THUMB}}" alt="@{{item.user.name | uppercase}}">
                <img ng-if="item.user.image!=null && item.user.image!=''" src="{{IMAGE_PATH_USERS_THUMB}}@{{item.user.image}}" alt="@{{item.user.name | uppercase}}">
                
                <h4>@{{item.user.name | uppercase}} <span class="time"><i class="fa fa-mars-stroke"></i> @{{ item.user.gender |uppercase}}</span></h4>
                <p>
                  <strong>Designation:</strong> @{{item.user.job_title }} &nbsp;&nbsp;&nbsp;
                  <strong>Qualification:</strong> @{{item.user.qualification }}
                </p>
                <input type="hidden" name="selected_list[]" value="{{$yearno.'_'.$semister.'_'}}@{{item.id+'_'+item.user.id}}">
                
        </a>
        <p ng-if="item.user==null" class="not-assign">
        {{getPhrase('no_staff_alotted')}}
         <input type="hidden" name="selected_list[]" value="{{$yearno.'_'.$semister.'_'}}@{{item.id+'_0'}}">
        </p>
      </li>
    </ul>
    
  </div>
  <div ng-if="item.user!=null" class="col-md-1 ">
     <i class="fa fa-trash text-danger pull-right" ng-click="removeItem(item, target_items, 'target_items','{{$academic_id}}','{{$course_id}}','{{$yearno}}','{{$semister}}',item.user.id)" title="{{getPhrase('delete')}}"></i>
  </div>
 


</div>

</div>


