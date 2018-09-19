
<div class="row" >

				<?php 
				$applicable_to_specific = array('0'=>'All', '1'=>getPhrase('specific_classes'));
				$applicable_to_specific_offline = array('1'=>getPhrase('specific_classes'));
				?>
				<input type="hidden" name="applicable_to_specific" value="1"  
				ng-if="quiz_type=='online'"
				ng-model='applicable_to_specific' >
				<input type="hidden" name="applicable_to_specific" value="0" 
				ng-if="quiz_type!='offline'" ng-model='applicable_to_specific'  >

				 	 <fieldset class="form-group col-md-3" >
						{{ Form::label('applicable_to_specific', getphrase('applicable_to_specific')) }}
						<span class="text-red">*</span>
						
						{{Form::select('applicable_to_specific', $applicable_to_specific, null, ['placeholder' => getPhrase('select'),'class'=>'form-control', 
						'ng-model'=>'applicable_to_specific',
							'required'=> 'true', 
							 
							'ng-class'=>'{"has-error": formQuiz.applicable_to_specific.$touched && formQuiz.applicable_to_specific.$invalid}',

						]) }}

						<div class="validation-error" ng-messages="formQuiz.applicable_to_specific.$error" >
	    					{!! getValidationMessage()!!}
						</div>


					</fieldset>  

				 
					<div  ng-if="applicable_to_specific==1">
	  				 <fieldset class="form-group col-md-3">
							
							 {{ Form::label('academic_year', getphrase('academic_year')) }}
							<span class="text-red">*</span>
							 {{Form::select('academic_id', $academic_years, null, 
                        [   'class'     => 'form-control', 
                            "id"        => "select_academic_year",
                            "ng-model"  => "academic_year",
                            "ng-change" => "getParentCourses(academic_year)",
                            
							'ng-class'=>'{"has-error": formQuiz.academic_year.$touched && formQuiz.academic_year.$invalid}',
                        ])}}

							 
						<div class="validation-error" ng-messages="formQuiz.academic_year.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('number')!!}
						</div>
					</fieldset>	
	  				 <fieldset class="form-group col-md-3" ng-if="academic_year"	>
						
						<span class="text-red">*</span>
						 <label for="course_parent_id">{{getPhrase('course')}}</label>
                            <select 
                            name="course_parent_id" 
                            id="course_parent_id" 
                            class="form-control" 
                            ng-model="course_parent_id" 
                            ng-change="getChildCourses(academic_year, course_parent_id)">
                            
                            <option ng-repeat="option in parent_courses" value="@{{option.id}}">
                            @{{option.course_title}}</option>
                            </select>
						<div class="validation-error" ng-messages="formQuiz.cost.$error" >
	    					{!! getValidationMessage()!!}
	    					{!! getValidationMessage('number')!!}
						</div>
				</fieldset>

				<fieldset ng-if="showCourses && course_parent_id" class="form-group">
                           
                   <label for="course_id">{{getPhrase('branch')}}</label>
                 
                    <select ng-options="item as item.course_title for item in courses track by item.id" ng-model="course_id" name="course_id" 
                    id="course_id" 
                    ng-change="prepareYears(course_id.id)" 
                    class="form-control" >
                    	<option value="">{{getPhrase('select')}}</option>
                    </select>
         
                </fieldset>
				</div>
				</div>


<div   class="row" ng-if="source_items.length>0 || target_items.length>0">
	<div class="col-md-6">
		<div class="exam-year-selection"
		 class='containerVertical' id="target"  ng-drop="true" ng-drop-success="onDropComplete($data,$event)"
		>
			<ul  class="list-unstyled year-selection-list selected-list">
				<li ng-repeat="item in target_items" id="@{{'target_items'-item.id}}">
					 
					<span>Course: <strong>@{{item.course_title}}</strong> </span>
				 
					<span ng-if="item.semister!=0 && item.course_dueration > 1"><strong>Year:</strong> @{{item.year}} - @{{item.semister}}</span> 
				<span ng-if="item.semister==0 && item.course_dueration > 1"><strong>Year:</strong> @{{item.year}}</span> 
				 
					<input type="hidden" name="selected_list[]" value="@{{item.id}}">

           		<i class="fa fa-trash text-danger pull-right" ng-click="removeItem(item.id, target_items, 'target_items')"></i>
				</li>
			</ul>
			
			 
		</div>
	</div>

	<div class="col-md-6">
		<div class="exam-year-selection">
			<ul ng-if="showCourses" class="list-unstyled year-selection-list list">
	 
				<li ng-repeat="year in source_items" ng-if="year!=null" ng-drag="true" ng-drag-data="year" ng-drag-success="onDragComplete($data,$event)" id="@{{'source_items-'+year.id}}">

				<span ng-if="year.semister!=0"><strong>Year:</strong> @{{year.year}} - @{{year.semister}}</span> 
				<span ng-if="year.semister==0"><strong>Year:</strong> @{{year.year}}</span> 
				</li>
			 
			</ul>

			<ul ng-if="!showCourses" class="list-unstyled year-selection-list list">
	 
				<li ng-repeat="item in source_items" ng-if="item!=null" ng-drag="true" ng-drag-data="item" ng-drag-success="onDragComplete($data,$event)" >
				<span >@{{item.course_title}}</span> 
				
				</li>
			 
			</ul>

		</div>
	</div>
</div>