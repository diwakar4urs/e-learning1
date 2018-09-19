@include('common.angular-factory')

<script>
var app = angular.module('academia', []);
app.controller('staffController', function( $scope, $http) {
  $scope.courses        = [{'id':'-1','course_title':'Select Branch'}];
  $scope.course_id      = $scope.courses[0];
  $scope.selected_course_parent_id = '';
   $scope.getChildCourses = function(parent_course_id){
         
        if(parent_course_id=='')
           return ;
      $scope.selected_course_parent_id = parent_course_id;
      route = '{{URL_STUDENT_COURSES}}';  
      data = {   _method: 'post', 
                  '_token':$scope.getToken(), 
                  'parent_course_id': parent_course_id
             };
      $http.post(route, data).then(function(result){
          result = result.data;
          $scope.courses = result;
          $scope.course_id = $scope.courses[0];
        });
      }

    $scope.getToken = function(){
      return  $('[name="_token"]').val();
    }

    $scope.setOption = function(option){
      index = $scope.findIndexInData($scope.courses, 'id', option);
      $scope.course_id = $scope.courses[index];
    }

    $scope. findIndexInData    = function (Array, property, action) {
          var result           = -1;
          angular.forEach(Array, function(value, index) {
             if(value[property]==action){
                result         =index;
             }
          });
          return result;
        }
});

</script>

