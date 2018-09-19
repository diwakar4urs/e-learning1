 			<div class="row">
	      <fieldset class="form-group col-md-6">
	        {{ Form::label('academic_year', getphrase('academic_year')) }}
	        
	        {{Form::select('academic_id', $academic_years, null, 
	        [   'class'     => 'form-control', 
	            "id"        => "select_academic_year",
	            "ng-model"  => "academic_year",
	            "ng-change" => "getParentCourses(academic_year)"
	        ])}}
        </fieldset>

	<fieldset ng-if="academic_year" class="form-group col-md-6">
                             <label for="course_parent_id">{{getPhrase('branch')}}</label>
                            <select 
                            name="course_parent_id" 
                            id="course_parent_id" 
                            class="form-control" 
                            ng-model="course_parent_id" 
                            ng-change="getChildCourses(academic_year, course_parent_id)"
                                                     >
                            <option value="">{{getPhrase('select')}}</option>
                            <option ng-repeat="option in parent_courses" value="@{{option.id}}">
                            @{{option.course_title}}</option>
                            </select>
    </fieldset>

    <fieldset ng-if="parent_selected" class="form-group col-md-6">
       
       <label for="course_id">{{getPhrase('course')}}</label>
        <select 
        name="course_id" 
        id="course_id" 
        class="form-control" 
        ng-model="course_id" 
        ng-change="course_selected(course_id)"
        >
        <option value="">{{getPhrase('select')}}</option>
         <option ng-repeat="option in courses" value="@{{option.id}}">@{{option.course_title}}</option>
        </select>
    </fieldset>
  
 

	<div ng-if="course_selected > 0" class="buttons col-md-12 text-center">

		<button class="btn btn-lg btn-primary button">{{ getPhrase('load') }}</button>
	</div>
	  </div>		
	 	 