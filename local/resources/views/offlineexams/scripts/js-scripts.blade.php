 

@include('common.angular-factory')

<script>
 app.controller('TabController', function ($scope, $http, $rootScope,httpPreConfig)
  {
     @include('common.js-script-year-selection')
    
     $scope.tab             = 1;
 
     $scope.exam_list      = []; 
    
    $scope.doCall = function(){
      
      academic_id          = $scope.selected_academic_id;
      parent_course_id     = $scope.selected_course_parent_id;
      course_id            = $scope.selected_course_id;

      year                 = $scope.selected_year;
      semister             = $scope.selected_semister;

       route   = '{{URL_OFFLINE_EXAMS_GET_INFORMATION}}';  
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
          $scope.result_data = [];
        angular.forEach(result, function(value, key) {
            $scope.result_data.push(value);
          })

      });
      console.log($scope.result_data);
    }

});
 
  
</script>