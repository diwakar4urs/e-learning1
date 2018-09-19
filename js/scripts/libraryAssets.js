var app = angular.module('academia', []);
app.controller('angLibraryAssets', function($scope, $http) {
	
	$scope.initAngData = function(data) {
		if(data=='')
		{
			$scope.fine_eligiblity = 0;
			$scope.max_fine_limit = 0;
			return;
		}
		 data = JSON.parse(data);
		 $scope.fine_eligiblity = data.is_eligible_for_fine;
		 $scope.max_fine_limit = data.is_having_max_fine_limit;

		 
	}
});