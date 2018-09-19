<div class="row" id="selection-view" ng-hide="showCalender">                
                
                    <div class="col-md-6 col-md-offset-3">
                   
                        <fieldset class="form-group">
                        {{ Form::label ('academic_year', getphrase('academic_year')) }}
                        {{ Form::select('academic_id', $academic_years, null, 
                        [   'class'     => 'form-control', 
                            "id"        => "select_academic_year",
                            "ng-model"  => "academic_year",
                            "ng-change" => "getParentCourses(academic_year)"
                        ])}}
                        </fieldset>
                        
                        <fieldset ng-if = "academic_year" class="form-group">
                             <label for = "course_parent_id">{{getPhrase('branch')}}</label>
                            <select 
                            name      = "course_parent_id" 
                            id        = "course_parent_id" 
                            class     = "form-control" 
                            ng-model  = "course_parent_id" 
                            ng-change = "getChildCourses(academic_year, course_parent_id)"
                                                     >
                            <option value="">{{getPhrase('select')}}</option>
                            <option ng-repeat="option in parent_courses" value="@{{option.id}}">@{{option.course_title}}</option>
                            </select>
                        </fieldset>
    
                        <fieldset ng-if="parent_selected" class="form-group">
                           
                           <label for="course_id">{{getPhrase('course')}}</label>
                            <select 
                            name="course_id" 
                            id="course_id" 
                            class="form-control" 
                            ng-model="course_id" 
                            ng-change="prepareYears(course_id)"                           
                            >
                            <option value="">{{getPhrase('select')}}</option>
                             <option ng-repeat="option in courses" value="@{{option.id}}">@{{option.course_title}}</option>
                            </select>
                        </fieldset>

                        <fieldset ng-if="parent_selected" class="form-group">
                   
                            <label for="year">{{getPhrase('year')}}</label>
                            <select 
                            name="current_year" 
                            id="current_year" 
                            class="form-control" 
                            ng-model="current_year" 
                            ng-change="yearChanged(current_year)"
                            >
                            <option value="">{{getPhrase('select')}}</option>
                            <option ng-repeat="y in years" ng-if="y" value="@{{y}}">@{{y}}</option>
                            </select>

                        </fieldset>
                         
            </div>
            
                </div>