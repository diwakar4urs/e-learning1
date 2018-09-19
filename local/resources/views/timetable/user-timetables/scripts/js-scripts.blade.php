 <script src="{{JS}}angular.js"></script>
<script src="{{JS}}plugins/dragdrop/ngDraggable.js"></script>
<script>

 var app = angular.module('academia', ['ngDraggable']);
 app.controller('TimetableController', function ($scope, $http, $timeout)
  {
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
     $scope.topics_completed = [];
    $scope.selected_user    = null;
    $scope.timings_map      = [];
   $scope.maximum_periods_set = [];
  $scope.showCalender       = false;   
  $scope.is_printed         = false;

  $scope.days = [] ;
 
  $scope.total_periods = [];
      
      $scope.ingAngData = function(data) {
        
        $scope.maximum_periods_set = data.maximum_periods_set;
        $scope.days = data.days;
        
        $scope.timings_map = data.timemaps;
        $scope.target_items = data.timemaps;
        
         timetable_list = [];
        angular.forEach(data.timemaps, function(day, day_number){
          timetable_list.push(day.periods);
        })
        
        $scope.target_items = timetable_list;
      }


    /**
     * This method is used to find an element on specific condition in an array of objects
     * @param  {[type]} Array    [the sourse of an array]
     * @param  {[type]} property [the property of the object]
     * @param  {[type]} action   [the value need to be searched]
     * @return {[type]}          [returns an index of the element from source]
     */
     $scope.findIndexInData    =function (Array, property, action) {
          var result           = -1;
          angular.forEach(Array, function(value, index) {
             if(value[property]==action){
                result         =index;
             }
          });
          return result;
        }



     /**
     * Returns the token by fetching if from from form
     * 
     */
    $scope.getToken = function(){
      return  $('[name="_token"]').val();
    }

      $scope.yearChanged     = function (year_number) {
      $scope.year_selected   = true;
 
      academic_id          = $scope.selected_academic_id;
      parent_course_id     = $scope.selected_course_parent_id;
      course_id            = $scope.selected_course_id;
      $scope.selected_year = year_number;
      year                 = year_number;
 
      
        route   = '{{URL_GET_TIMETABLE_DETAILS}}';  
        data    = {   _method: 'post', 
                  '_token':$scope.getToken(), 
                  'academic_id': academic_id, 
                  'parent_course_id': parent_course_id,
                  'course_id': course_id,
                  'year': year,
               };
               
        $http.post(route, data).success(function(result, status) {
        users = [];
  
        $scope.days = result.days;
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
                  '_token':$scope.getToken(), 
                  'search_text': text,
               };
               
        $http.post(route, data).success(function(result, status) {
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
                  '_token':$scope.getToken(), 
                  'user_id': user.id,
                  'current_year': user.current_year,
                  'current_semister': user.current_semister,
               };
        $scope.selected_user = user;        
        $scope.form_show = false;
        $http.post(route, data).success(function(result, status) {
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
       $scope.getSyllabus = function(item){
        
          route = '{{URL_LESSION_PLANS_GET_LASTUPDATED_RECORDS}}';
          request_data    = {   _method: 'post', 
                  '_token':$scope.getToken(), 
                  'user_id': item.user_id,
                  'subject_id': item.subject_id,
                  'id': item.id
               };
        $http.post(route, request_data).success(function(result, status) {
          $scope.topics_completed = result;
         
          
        });

       
      
    }
 

});
 
  
</script>