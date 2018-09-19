@include('common.angular-factory')
<script >
 
     app.controller('academic_controller', function ($scope, $http, httpPreConfig) {
      $scope.academic_year = '';
      $scope.select_academic_year = '';
      $scope.parent_login = '';
      $scope.showSearch = false;
      $scope.userDetails = false;
      $scope.parents = [];
      $scope.parent_user_name = '';
      $scope.parent_email = '';
      $scope.parent_user_id = '';
      $scope.parent_name = '';

        @include('common.js-script-year-selection',array('doCall'=>false))

    /**
     * Returns the token by fetching if from from form
     * 
     */
    $scope.getToken = function(){
      return  $('[name="_token"]').val();
    }

     $scope.findIndexInData =function (Array, property, action) {
          var result = -1;
        angular.forEach(Array, function(value, index) {
           if(value[property]==action){
              result=index;
           }
        });
        return result;
      }

      $scope.accountAvailable = function (availability)
      {
        
        if(!availability)
        {
          $scope.userDetails = true;
          $scope.showSearch = false;
          $scope.resetDetails();
        }
        else {
          $scope.resetDetails();
          $scope.showSearch = true;
          $scope.userDetails = false;
        }
        // URL_SEARCH_PARENT_RECORDS
      }

      $scope.getParentRecords = function (text) {

        route   = '{{URL_SEARCH_PARENT_RECORDS}}';
        data    = {   _method: 'post', 
                  '_token':$scope.getToken(), 
                  'search_text': text,
                  'user_id': $scope.current_user_id,
                  };
               
        $http.post(route, data).success(function(result, status) {
        users = [];
 
        angular.forEach(result, function(value, key) {

            users.push(value);
          })
        
        $scope.parents = users;
     
        });
      }

      $scope.resetDetails = function(){
        $scope.parent_user_name = '';
        $scope.parent_name = '';
        $scope.parent_email = '';
        $scope.parent_user_id = '';
        $scope.parents = [];
      }


      $scope.setAsCurrentItem = function (record) {
        $scope.parent_name = record.name;
        $scope.parent_user_name = record.username;
        $scope.parent_email = record.email;
        $scope.parent_user_id = record.id;
         $scope.userDetails = true;
      }

    });


 
</script>