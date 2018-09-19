<script src="{{JS}}angular.js"></script>
<script src="{{JS}}angular-messages.js"></script>

<script >
var app = angular.module('academia', ['ngMessages']);
</script>

@include('common.angular-factory',array('load_module'=> FALSE))

<script>


app.controller('attendanceController', function($scope, $http, httpPreConfig) {
    
    $scope.initAngData = function(data) {
      
      $scope.total = data;
      $scope.present = data;
      $scope.absent = 0;
      $scope.leave = 0;
      $scope.updateCount();
    }

    $scope.updateCount = function () {

     
      var RadiobtnValues    =$("div #myForm").find('input:checked');
      present = 0;
      absent = 0;
      leave = 0;

    RadiobtnValues.each(function(index,elem){
        value = elem.value;
        if(value=='P')
        {
          present++;
         
        }
        else if(value=='L')
        {
          leave++;
          
        }
        else if(value=='A')
        {
          absent++;
        }

    });
      
      
      $scope.present = present;
      $scope.absent = absent;
      $scope.leave = leave;
    
    }
 });
</script>