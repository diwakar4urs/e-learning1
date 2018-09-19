var app = angular.module('academia', []);
app.controller('angLibraryController', function($scope, $http) {
	
	$scope.initAngData = function(data) {
		if(data=='')
		{
			
			$scope.series = 0;
			
			return;
		}
		 data = JSON.parse(data);
		 $scope.is_series = data.is_series;
		 
	}
});