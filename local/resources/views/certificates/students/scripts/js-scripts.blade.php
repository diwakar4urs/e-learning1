 

@include('common.angular-factory')

<script>
 app.controller('TabController', function ($scope, $http, $rootScope,httpPreConfig)
  {
     @include('common.js-script-year-selection')
    
     $scope.tab             = 1;
     $scope.users = []; 
     $scope.exam_list      = []; 
     $scope.selected_user  = null;
     $scope.certificates_issued  = [];
     $scope.form_show = false;
     $scope.button_text = 'Issue New';
     $scope.selected_certificate_type = 'bonafide';

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
        
      httpPreConfig.webServiceCallPost(route, data).then(function(result){
        result = result.data;
          $scope.result_data = [];
        angular.forEach(result, function(value, key) {
            $scope.result_data.push(value);
          })
           
      });
      $scope.users = $scope.result_data;

    }

    $scope.certificateTypeChanged = function(data){
      $scope.users = [];
      $scope.selected_user = null;
      $scope.form_show = false;
      $scope.certificates_issued = [];
      $scope.search = '';
    }

 $scope.printDiv = function() 
{

  var divToPrint=document.getElementById('DivIdToPrint');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}

$scope.textChanged = function (text) {
 
  route = '{{URL_STUDENT_SEARCH}}';
  certificate_type = $scope.selected_certificate_type;
  data    = {   _method: 'post', 
                  '_token':httpPreConfig.getToken(), 
                  'search_text': text,
                  'certificate_type': certificate_type,
               };
               
         httpPreConfig.webServiceCallPost(route, data).then(function(result){
        users = [];
 
        angular.forEach(result.data, function(value, key) {
            users.push(value);
          })

        $scope.users = users;
     
        });

}

$scope.getUserDetails = function (user) {
  $scope.certificates_issued = [];
  certificate_type = $scope.selected_certificate_type;
   route = '{{URL_CHECK_CERTIFICATE_ISSUED}}';
  data    = {     _method           : 'post', 
                  '_token'          :httpPreConfig.getToken(), 
                  'user_id'         : user.id,
                  'current_year'    : user.current_year,
                  'current_semister': user.current_semister,
                  'certificate_type': certificate_type,
               };
        $scope.selected_user = user;        
        $scope.form_show = false;
        httpPreConfig.webServiceCallPost(route, data).then(function(result){
          $scope.books_return     = result.data.books_need_to_return;
          $scope.certificate_type = result.data.certificate_type;
          if(result.data.records.length>0) {
              $scope.certificates_issued = [];
              angular.forEach(result.data.records, function(value,key){
                $scope.certificates_issued.push(value);

              });
          }
     
        });
}

});
 
  
</script>