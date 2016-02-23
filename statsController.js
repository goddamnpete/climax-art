 var app = angular.module('app', []);

app.controller("statsController", function($rootScope, $scope, $http) {
	$scope.c1 = 'Asuna';
	$scope.predicate = 'matchcount';
	$scope.reverse = false;
	$http.post('getrec.php', {}). success(function(data, status, headers, config) {
				$scope.dbresults = data;
		}); 
});