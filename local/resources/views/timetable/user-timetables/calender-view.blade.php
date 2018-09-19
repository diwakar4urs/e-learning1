
     <div id="calendar-wrap">
            <header>
                <h4>Timetable</h4>
               
            </header>
            <div id="calendar" class="table-responsive">
            <table class="table table-bordered time-table">
            <thead>
                <th>Day</th>
                <th ng-repeat="period in maximum_periods_set">@{{period.period_name}}<br>@{{period.start_time | date : 'hh'}} - @{{period.end_time | date : 'hh'}}</th>
            </thead>
              <tbody>
                  <tr ng-repeat=" timemap in timings_map track by $index">
                    <td>@{{days[$index].day}}</td>
                    <td ng-repeat="item in target_items[$index]">
                   <ul class="days" > 
                    <li class="day" >
                    <p class="break-block" ng-if="item.is_break==1">@{{item.period_name}}</p>
                        <div ng-if="item.is_break==0" 
                       class="calender-staff">
                        <p class="empty-block" ng-if="item.is_assigned==0">{{getPhrase('leisure')}}</p>
                           <div 
                           ng-if="item.is_assigned==1" 
                           id="target_items-@{{item.id}}"
                           ng-click="getSyllabus(item)"
                           >
                            
                            <div class="user">
                                
                                <img ng-if="item.image==null || item.image==''" src="{{IMAGE_PATH_USERS_DEFAULT_THUMB}}" alt="">
                                <img ng-if="item.image!=null && item.image!=''" src="{{IMAGE_PATH_USERS_THUMB}}@{{item.image}}" alt="">

                            </div>
                            <h4>@{{item.name | uppercase}}</h4>
                            <p>@{{item.subject_title}}</p>
                            <p>@{{item.course_title}}</p>
                            
                            <div class="actions">
                                <span ng-if="item.is_lab==1" title="{{getPhrase('lab')}}"><i class="fa fa-flask text-primary"></i></span>
                                <span ng-if="item.is_elective==1" title="{{getPhrase('lab')}}"><i class="fa fa-hand-pointer-o text-primary"></i>
                                </span>
                            </div>
                            </div>
                          
                            <input type="hidden" name="staff[@{{item.id}}]" 

                            value="@{{item.user_id}}">
                            <input type="hidden" name="subject[@{{item.id}}]" value="@{{item.subject_id}}">
                        </div>


                                         
                    </li>
                    </ul>
                    </td>
                  </tr>
              </tbody>  
            </table>
           

            </div><!-- /. calendar -->
        </div><!-- /. wrap -->

 

