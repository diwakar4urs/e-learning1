var app = angular.module('academia', []);
app.controller('angLmsController', function($scope, $http) {
	
	$scope.initAngData = function(data) {
		if(data=='')
		{
			$scope.is_series = 0;
			$scope.series = '';
			$scope.content_type = '';
			return;
		}
		 data = JSON.parse(data);
		 $scope.is_series 		= data.is_series;
		 $scope.series 			= data.series;
		 $scope.content_type 	= data.content_type;
	}
});