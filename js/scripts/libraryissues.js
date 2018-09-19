var app = angular.module('academia', []);
app.controller('libraryIssues', function($scope, $http) {
	$scope.initAngData = function(data) {
		if(data=='')
		{
			$scope.subjectQuestions = '';
	 		$scope.subject 			= null;
			return;
		}
		// data = JSON.parse(data);
		// $scope.question_type = data.question_type;
	}
	 $scope.assetChanged = function(selected_number) {
    	selected_id = selected_number;
    	// console.log(subject_id);

    	$scope.asset_type = selected_number;

    	route = '/library/issues/get-masters';  
      	data= {_method: 'post', '_token':$scope.getToken(), 'asset_id': selected_id};
    	 $scope.topics =[];
      	$http.post(route, data).success(function(result, status) {
      		  // result = JSON.parse(result);
      			
             // $scope.topics = result.topics;
             $scope.subject = result.subject;
             // console.log(result.questions);
             console.log(result);
           $scope.topics = result.topics; 
           $scope.topic =$scope.topics[0];
            // $scope.fillTopics(result);
 			// console.log($scope.topics);
             $scope.subjectQuestions = result.questions;
        });

    }

     /**
     * Returns the token by fetching if from from form
     * 
     */
    $scope.getToken = function(){
      return  $('[name="_token"]').val();
    }
}