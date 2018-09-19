@include('common.angular-factory')
<script>

 app.controller('TabController', function ($scope, $http, httpPreConfig)
  {
      @include('offlineexams.js-script-year-selection')
      $scope.tab                  = 1;
      $scope.users                = []; 
      $scope.exam_list            = []; 
      $scope.to_years             = [];
      $scope.to_selected_year     = '';
      $scope.to_semisters         = [];
      $scope.to_selected_semister = '';
      $scope.to_course            = [];
      $scope.to_course_id         = '';
      $scope.to_selected_course_id='';
      $scope.to_total_years = 0;
      $scope.to_total_semisters = 0;
      $scope.current_user = {};
      $scope.current_user_remarks = '';
      $scope.blank_columns = 1;

    $scope.doCall     = function () {
      $scope.year_selected   = true;
      if($scope.to_years.length<=0)
        $scope.to_years      = $scope.years;
 
      academic_id          = $scope.selected_academic_id;
      parent_course_id     = $scope.selected_course_parent_id;
      course_id            = $scope.selected_course_id;
  
      year                 =  $scope.selected_year;
      semister             =  $scope.selected_semister;

      
        route   = '{{URL_OFFLINE_EXAMS_ADD}}';  
        data    = {   _method: 'post', 
                  '_token':httpPreConfig.getToken(), 
                  'academic_id': academic_id, 
                  'parent_course_id': parent_course_id,
                  'course_id': course_id,
                  'year': year,
                  'semister': semister,
               };
               
        httpPreConfig.webServiceCallPost(route, data).then(function(result){
        users = [];
        angular.forEach(result.data, function(value, key) {
            users.push(value);
          })

        $scope.result_data = users;
        
        
        $scope.class_title         = $scope.result_data[0].academic_year_title+'-'+$scope.result_data[0].course_title+' '+'Student List'; 

        $scope.class_title_yer_sem = $scope.result_data[0].academic_year_title+'-'+$scope.result_data[0].course_title+'-'+$scope.result_data[0].current_year+' '+'year'+'-'+$scope.result_data[0].current_semister+' '+'semester'+' '+'Student List'; 

        });
    }
 
 $scope.addColumns = function(n)
 {
  $scope.blank_columns = [];
  for(i=0; i<n; i++)
    $scope.blank_columns.push(i);
 }
 
 $scope.printIt = function(){
  dta = $('#printable_data').html();
  $('#html_data').val(dta);
  $('#htmlform').submit();
 }
});
 
  
</script>