var app = angular.module('academia', []);
app.controller('questionsController', function($scope, $http) {
	
	$scope.initAngData = function(data) {
		console.log(data);
		 if(data=='')
		{
			$scope.question_type = '';
			$scope.total_answers = 0;
			$scope.answers = null;
			$scope.total_correct_answers = 0;
			$scope.total_para_options = 0;
			return;
		}
		data = JSON.parse(data);
		$scope.question_type = data.question_type;
		$scope.total_answers = data.total_answers;
		$scope.total_para_options = data.answers[0].total_options;
		$scope.answers 		 = data.answers;
		$scope.correct_answers 		= data.correct_answers;

		$scope.total_correct_answers = data.total_correct_answers;
		// if($scope.question_type=='checkbox')
		// 	$scope.answers = data.answers;

		// $scope.total_correct_answers = data.total_correct_answers;
		// $("select#total_answers").prop('selectedIndex', $scope.total_answers);

		// $scope.answersChanged($scope.total_answers);
		console.log(data);
		// $scope.discount = data.discount_for;
		
	}

	 $scope.range = function(count) {
        var range = []; 
		for (var i = 0; i < count; i++) { 
		  range.push(i) 
		} 
  		return range;
    }

    $scope.answersChanged = function(selected_number) {
    	$scope.total_answers = selected_number;

    }
    $scope.correctAnswersChanged = function(selected_number) {
    	$scope.total_correct_answers = selected_number;

    }
    $scope.paraOptionsChanged = function(selected_number) {
    	$scope.total_para_options = selected_number;

    }
	
	$scope.getToken = function(){
      return  $('[name="_token"]').val();
    }
	
});

 