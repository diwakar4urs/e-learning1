
 <script src="{{JS}}angular.js"></script>
 <script src='{{JS}}moment.min.js'></script>
 <script src='{{JS}}fullcalendar.min.js'></script>
<script >
  var app = angular.module('academia', []);
</script>

@include('common.angular-factory',array('load_module'=> FALSE))

<script>

 
 app.controller('TabController', function ($scope, $http, $rootScope, httpPreConfig)
  {
     
  
    @include('common.js-script-year-selection',array('user_slug'=>$user->slug))
   
     $scope.attendance_date           = [];
     $scope.attendance_code           = [];

     $scope.tab             = 1;
     $scope.year_selected   = false;
     
     $scope.selected_attendance_date  = '';
     $scope.selected_attendance_code  = '';
     $scope.student_id = '{{$student_id}}';

     $scope.total_classes = 0;
     $scope.present = 0;
     $scope.absent = 0;
     $scope.leave = 0;
     $rootScope.attendance_data =[];
      $scope.topics_completed=[];
 
  
      $scope.doCall     = function () {
 
      $scope.year_selected   = true;
  
      academic_id          = $scope.selected_academic_id;
      parent_course_id     = $scope.selected_course_parent_id;
      course_id            = $scope.selected_course_id;

      attendance_date      = $scope.selected_attendance_date;
      attendance_code      = $scope.selected_attendance_code;

      
      year                 = $scope.selected_year;
      semister             = $scope.selected_semister;
      student_id           = $scope.student_id;

      
        route   = '{{URL_STUDENT_ATTENDENCE_SUMMARY}}';  
        data    = {   _method       : 'post', 
                  '_token'          : httpPreConfig.getToken(), 
                  'academic_id'     : academic_id, 
                  'parent_course_id': parent_course_id,
                  'course_id'       : course_id,
                  'year'            : year,
                  'semister'        : semister,
                  'student_id'      : student_id
               };
          $scope.result_data = [];

        httpPreConfig.webServiceCallPost(route, data).then(function(result){
          result = result.data;
          $scope.total_classes = 0;

        present  = 0;
        absent   = 0;
        leave    = 0;
        angular.forEach(result.attendance, function(value, key) {
          data = {};
            $scope.total_classes += parseInt(value.total_class,10);
            if(value.attendance_code=='P')
            {
              data = {
                        'title' : value.subject_title+' ('+value.total_class+')', 
                        'start' : value.attendance_date,
                        'color' : '{{ATTENDANCE_COLOR_PRESENT}}',
                        'textColor': '{{ATTENDANCE_COLOR_FORE_COLOR}}',
                        'staff_id':value.staff_id,
                        'subject_id':value.subject_id,
                        'subject_title': value.subject_title
                      };
              present += parseInt(value.total_class,10);

            }
            else if(value.attendance_code=='A')
            {
              data = {
                'title' : '{{getPhrase("absent")}}: '+value.subject_title+' ('+value.total_class+')', 
                'start' : value.attendance_date,
                'color' : '{{ATTENDANCE_COLOR_ABSENT}}',
                'textColor': '{{ATTENDANCE_COLOR_FORE_COLOR}}',
                'staff_id':value.staff_id,
                'subject_id':value.subject_id,
                'subject_title': value.subject_title

              };
              absent += parseInt(value.total_class, 10);
            }
            else if(value.attendance_code=='L')
            {
              data = {
                'title' : '{{getPhrase("leave")}}: '+value.subject_title+' ('+value.total_class+')', 
                'start' : value.attendance_date,
                'color' : '{{ATTENDANCE_COLOR_LEAVE}}',
                'textColor': '{{ATTENDANCE_COLOR_FORE_COLOR}}',
                'staff_id':value.staff_id,
                'subject_id':value.subject_id,
                'subject_title': value.subject_title
              };
              leave += parseInt(value.total_class,10);
            }
            $scope.result_data.push(data);
          });

        $scope.present  = present;
        $scope.absent   = absent;
        $scope.leave = leave;
       old_events = $rootScope.attendance_data;
       $rootScope.attendance_data = $scope.result_data;
       new_data = $rootScope.attendance_data;
        $('#calendar').fullCalendar( 'removeEventSource', old_events);
        $('#calendar').fullCalendar( 'addEventSource', new_data);         
        $('#calendar').fullCalendar( 'refetchEvents' );
       $scope.showCalender();
        });

        $('#attendance_summary').modal('show');

    }

    $scope.showCalender = function() {
      
       $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today'
                    , center: 'title'
                    , right: 'month'
                }
                , defaultDate: '{{date("Y-m-d")}}' 
                , editable: false
                , eventLimit: 4,  
                events: $rootScope.attendance_data,
          
                 selectable: true,
                 eventClick: function(calEvent, jsEvent, view) {
           
          $scope.selected_subject_name = calEvent.subject_title;

          route = '{{URL_STUDENT_ATTENDANCE_LESSIONPLAN}}';
          request_data    = {   _method: 'post', 
                  '_token':httpPreConfig.getToken(), 
                  'user_id': calEvent.staff_id,
                  'subject_id': calEvent.subject_id,
               };
       httpPreConfig.webServiceCallPost(route, request_data).then(function(result){
        result = result.data;
          $scope.topics_completed = result;
          $('#lessionplan_summary').modal('show');
        
          
          
        });

    }
            });
    }
    
});
 
  
</script>