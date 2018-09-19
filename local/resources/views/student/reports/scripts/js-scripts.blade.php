
@include('common.angular-factory')

<script>
 app.controller('TabController', function ($scope, $http, httpPreConfig)
  {
     @include('common.js-script-year-selection',array('user_slug'=>$user->slug))
 
      
      $scope.exam_categories = []; 
      $scope.exam_list       = []; 
      $scope.show_div = false;

      $scope.doCall     = function () {
      $scope.year_selected   = true;
      $scope.resetResult();
 
      academic_id          = $scope.selected_academic_id;
      parent_course_id     = $scope.selected_course_parent_id;
      course_id            = $scope.selected_course_id;

      year                 = $scope.selected_year;
      semister                 = $scope.selected_semister;
        user_id          = '{{$user->id}}';
      
        route   = '{{URL_STUDENT_RESULTS_GET_EXAM_CATEGORIES}}';  
        data    = {   _method: 'post', 
                  '_token':httpPreConfig.getToken(), 
                  'academic_id': academic_id, 
                  'parent_course_id': parent_course_id,
                  'course_id': course_id,
                  'year': year,
                  'semister': semister,
                  'user_id': user_id,
               };
               
         httpPreConfig.webServiceCallPost(route, data).then(function(result){
          result = result.data;
        categories = [];
        angular.forEach(result, function(value, key) {
            categories.push(value);
          })

        $scope.exam_categories = categories;
        if($scope.exam_categories.length >0 )
        $scope.show_div = true;
        });
    }
    $scope.setTab   = function(category_id){
      
    $scope.tab      = category_id;

      academic_id      = $scope.selected_academic_id;
      parent_course_id = $scope.selected_course_parent_id;
      course_id        = $scope.selected_course_id;
      year             = $scope.selected_year;
      semister         = $scope.selected_semister;
      user_id          = '{{$user->id}}';
      route            = '{{URL_STUDENT_RESULTS_GET_EXAMS}}';  
        data           = {   _method: 'post', 
                            '_token':httpPreConfig.getToken(), 
                            'academic_id': academic_id, 
                            'parent_course_id': parent_course_id,
                             'course_id': course_id,
                             'year': year,
                             'semister': semister,
                             'category_id': category_id,
                             'user_id': user_id,
                         };
               
         httpPreConfig.webServiceCallPost(route, data).then(function(result){
         result = result.data;
         examList = [];
        angular.forEach(result, function(value, key) {
            examList.push(value);
          })

        $scope.exam_list = examList;
        
     
        });
      
    };

    $scope.isSet         = function(tabNum){
      return $scope.tab === tabNum;
    };
    
    $scope.resetResult = function()
    {
       $scope.show_div = false;
       $scope.exam_list =[];
    }
});
 
  
</script>