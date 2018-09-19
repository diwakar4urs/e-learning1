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
      $scope.quiz_categories = [];
      $scope.subjects = [];
      $scope.students = [];
      $scope.course_title = '';
 
    $scope.doCall = function(){
      
      academic_id          = $scope.selected_academic_id;
      parent_course_id     = $scope.selected_course_parent_id;
      course_id            = $scope.selected_course_id;
      
      year                 = $scope.selected_year;
      semister             = $scope.selected_semister;

       route   = '{{URL_STUDENT_CLASS_OFFLINE_EXAMS_LIST}}';  
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
        $scope.quiz_categories = [];
        $scope.offline_quiz_category_id =0;
        angular.forEach(result, function(value, key) {
          obj = {'title': value.title, 'id': value.id};
        
            $scope.quiz_categories.push(obj);
          });
        });
    }
 
 $scope.getStudentMarks112 = function(){
    academic_id          = $scope.selected_academic_id;
      parent_course_id     = $scope.selected_course_parent_id;
      course_id            = $scope.selected_course_id;
      
      year                 = $scope.selected_year;
      semister             = $scope.selected_semister;
      $scope.students=[];
      if(!$scope.offline_quiz_category_id)
        return;
      
      offline_quiz_category_id = $scope.offline_quiz_category_id;
       
      
       route   = '{{URL_STUDENT_CLASS_MARKS}}';  
        data    = {   _method: 'post', 
                  '_token':httpPreConfig.getToken(), 
                  'academic_id': academic_id, 
                  'parent_course_id': parent_course_id,
                  'course_id': course_id,
                  'year': year,
                  'semister': semister,
                  'offline_quiz_category_id': offline_quiz_category_id
               };
               
      httpPreConfig.webServiceCallPost(route, data).then(function(result){
        result = result.data;
        $scope.result_data = result;
 

        $scope.subjects = result.subjects;
        $scope.students = result.students;

        $scope.course_title = result.course_title;
      });
 }
 
 $scope.printIt = function(){
  dta = $('#printable_data').html();
  $('#html_data').val(dta);
  $('#htmlform').submit();
 }
});
 
  
</script>