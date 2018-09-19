 <script src="{{JS}}angular.js"></script>
<script src="{{JS}}plugins/dragdrop/ngDraggable.js"></script>

<script >
  var app = angular.module('academia', ['ngDraggable']);
</script>

@include('common.angular-factory',array('load_module'=> FALSE))

<script>
 
 app.controller('TimetableController', function ($scope, $http, $timeout, httpPreConfig)
  {
    @include('common.js-script-year-selection')
    $scope.parent_courses  = [];
    $scope.courses         = [];
    $scope.parent_selected = false;
    $scope.years           = [];
     
    $scope.year_selected   = false;
    $scope.selected_academic_id      = 1;
    $scope.selected_course_parent_id = 1;
    $scope.selected_course_id        = 3;
    $scope.selected_year             = 1;
     
    $scope.source_items    = [];
    $scope.target_items    = [];
     
    $scope.selected_user    = null;
    $scope.timings_map      = [];
    $scope.maximum_periods_set = [];
    $scope.showCalender       = false;   
    $scope.is_printed         = false;



  $scope.days = [ {day_no:0, day:'Sun'},
                  {day_no:1, day:'Mon'},
                  {day_no:2, day:'Tue'},
                  {day_no:3, day:'Wed'},
                  {day_no:4, day:'Thr'},
                  {day_no:5, day:'Fri'},
                  {day_no:6, day:'Sat'}
                ] ;
  $scope.total_periods = [];
      
      $scope.ingAngData = function(data) {
         
      }
 
      $scope.doCall     = function () {
      $scope.year_selected   = true;
 
      academic_id          = $scope.selected_academic_id;
      parent_course_id     = $scope.selected_course_parent_id;
      course_id            = $scope.selected_course_id;
      year                 = $scope.selected_year;
      semister             = $scope.selected_semister;
      if(!semister)
        semister=0;
 
        route   = '{{URL_GET_TIMETABLE_DETAILS}}';  
        data    = {   _method: 'post', 
                  '_token':httpPreConfig.getToken(), 
                  'academic_id': academic_id, 
                  'parent_course_id': parent_course_id,
                  'course_id': course_id,
                  'year': year,
                  'semister': semister,
               };
               
       httpPreConfig.webServiceCallPost(route, data).then(function(result){
        result = result.data;
        users = [];
 
         $scope.timings_map = result.timemaps;
        
         $scope.maximum_periods_set = result.maximum_periods_set;
         $scope.source_items = result.staff_records;
        timetable_list = [];
        angular.forEach($scope.timings_map, function(day, day_number){
          timetable_list.push(day.periods);
        })
        
        $scope.target_items = timetable_list;
        
        $scope.toggleCalender();
        });

    }

//  $scope.printDiv = function() 
// {

//   var divToPrint=document.getElementById('DivIdToPrint');

//   var newWin=window.open('','Print-Window');

//   newWin.document.open();

//   newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

//   newWin.document.close();

//   setTimeout(function(){newWin.close();},10);

// }

$scope.toggleCalender = function () {
  
  if($scope.showCalender)
  {
      $scope.showCalender = false;
    $('#selection-view').addClass('animated {{ANIMATION_ADD}}');
  }
  else
  {
    $('#calendar-wrap').addClass('animated {{ANIMATION_ADD}}');
    $scope.showCalender = true;
  }
}

$scope.textChanged = function (text) {
  
  route = '{{URL_STUDENT_SEARCH}}';
  data    = {   _method: 'post', 
                  '_token':httpPreConfig.getToken(), 
                  'search_text': text,
               };
               
        httpPreConfig.webServiceCallPost(route, data).then(function(result){
          result = result.data;
        users = [];
        
        angular.forEach(result, function(value, key) {
            users.push(value);
          })

        $scope.users = users;
     
        });

}

$scope.getUserDetails = function (user) {
   route = '{{URL_CHECK_CERTIFICATE_ISSUED}}';
  data    = {   _method: 'post', 
                  '_token':httpPreConfig.getToken(), 
                  'user_id': user.id,
                  'current_year': user.current_year,
                  'current_semister': user.current_semister,
               };
        $scope.selected_user = user;        
        $scope.form_show = false;
        httpPreConfig.webServiceCallPost(route, data).then(function(result){
          result = result.data;
          if(result.length>0) {
        
         
      }
     
        });
}


 /**
         * This event is triggered when an item is dropped on droppable div
         * @param  {[type]} data [description]
         * @param  {[type]} evt  [description]
         * @return {[type]}      [description]
         */
       $scope.onDropComplete=function(data, evt, id, day_number){
        
          route = '{{URL_TIMETABLE_IS_STAFF_AVAILABLE}}';
          request_data    = {   _method: 'post', 
                  '_token':httpPreConfig.getToken(), 
                  'user_id': data.staff_user_id,
                  'id': id
               };
         httpPreConfig.webServiceCallPost(route, request_data).then(function(result){
          result = result.data;
          if(result.status==0)
          {
            alertify.error(result.message);
            return;
          }
          //Staff is available for that time slot, allocate the time slot
         index = httpPreConfig.findIndexInData($scope.target_items[day_number-1], 'id', id);
          if(index!=-1)  
          {
            
            $scope.target_items[day_number-1][index].is_assigned = 1;
            $scope.target_items[day_number-1][index].name = data.name;
            $scope.target_items[day_number-1][index].user_id = data.staff_user_id;
            $scope.target_items[day_number-1][index].subject_title = data.subject_title;
            $scope.target_items[day_number-1][index].subject_id = data.subject_id;
            $scope.target_items[day_number-1][index].is_elective = data.is_elective;
            $scope.target_items[day_number-1][index].is_lab = data.is_lab;
            $scope.target_items[day_number-1][index].image = data.image;
          }
          
        });

       
      
    }

    $scope.removeItem = function(item, source, id) { 
       httpPreConfig.showConfirmation().then(function(result){
                 
        if(result==1){
        index = httpPreConfig.findIndexInData(source, 'id', item.id);
         $scope.target_items[item.day_number-1][index].is_assigned = 0;
         $scope.target_items[item.day_number-1][index].name = null;
         $scope.target_items[item.day_number-1][index].user_id = null;
         $scope.target_items[item.day_number-1][index].subject_title = null;
         $scope.target_items[item.day_number-1][index].subject_id = null;
         $scope.target_items[item.day_number-1][index].is_elective = null;
         $scope.target_items[item.day_number-1][index].is_lab = null;
         $scope.target_items[item.day_number-1][index].image = null;
        
          }


        });
          
        }


});
 
  
</script>