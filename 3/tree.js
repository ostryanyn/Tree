var treeApp = angular.module('treeApp', []);

treeApp.controller('treeController', function treeController($scope) {

	// global SCOPE for debug purposes
	SCOPE = $scope;

	// tree array with branches
	$scope.tree = [];

	// functions {{{
	// load tree from db
	$scope.sync = function() {
		$.get(
			"api/load.php",
			function(data) {
				$scope.tree = JSON.parse( data );
				$scope.$digest();
			}
		)
		.fail( function() {/*error loading data*/});
	};

	$scope.sync();
	// }}}
});
