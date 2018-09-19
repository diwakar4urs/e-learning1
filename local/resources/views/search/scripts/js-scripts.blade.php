 @include('common.angular-factory')
<script>

 
 app.controller('TabController', function ($scope, $http, httpPreConfig)
  {
     @include('common.js-script-year-selection')
     $scope.tab             = 1;
      
      $scope.users = []; 
      $scope.exam_list      = []; 
      $scope.selected_user  = null;
      $scope.certificates_issued  = [];
      $scope.form_show = false;
      $scope.button_text = 'Issue New';

      $scope.toggleForm = function(){
        if($scope.form_show)
          $scope.form_show = false;
        else
          $scope.form_show = true;
      }
    $scope.doCall = function(){
      
      academic_id          = $scope.selected_academic_id;
      parent_course_id     = $scope.selected_course_parent_id;
      course_id            = $scope.selected_course_id;
      
      year                 = $scope.selected_year;
      semister             = $scope.selected_semister;

       route   = '{{URL_GET_STUDENTS}}';  
        data    = {   _method: 'post', 
                  '_token':httpPreConfig.getToken(), 
                  'academic_id': academic_id, 
                  'parent_course_id': parent_course_id,
                  'course_id': course_id,
                  'year': year,
                  'semister': semister,
               };
               
        $http.post(route, data).success(function(result, status) {
        $scope.result_data = [];
        angular.forEach(result, function(value, key) {
            $scope.result_data.push(value);
          })

      
     
        });
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
        httpPreConfig.
       httpPreConfig.webServiceCallPost(route, data).then(function(result){
        result = result.data
          if(result.length>0) {
       $scope.certificates_issued = [];
        angular.forEach(result, function(value,key){
        $scope.certificates_issued.push(value);
        });
  
      }
     
        });
}

});
 
  
</script>