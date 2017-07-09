var myApp = angular.module('myApp', ['dndLists']);

myApp.controller('myController', function treeController($scope, $http) {

	// global SCOPE for debug purposes
	SCOPE = $scope;

	// tree array with branches
	$scope.data = null;

	// functions {{{
	// load tree from db
	$scope.sync = function() {
		$http.get("api/select.php")
		.then(
			function(response){
				$scope.data = response.data;
			},
			function(response) {/*error*/}
		);
	};

	$scope.init = function() {
		$scope.sync();
	}
	$scope.init();
	// }}}
});

myApp.component('tree', {
	bindings: {
		array: '='
	},
	controller: function($http) {
		// addBranch() {{{
		function addBranch(newBranchName, parentBranch) {
			let parentID = parentBranch.id;
			$http.get("api/insert.php?branch_name=" + newBranchName + "&parent_id=" + parentID)
			.then(
				function(response){
					if(!response.data.error) {
						let newBranch = {
							id: response.data.last_id,
							name: newBranchName,
							branch: [],
							parent_id: parentID
						};
						parentBranch.branch.push(newBranch);
					}
					else
						alert("Error adding new branch!");
				},
				function(response) {/*error*/}
			);
		}
		// }}}
		// cutBranch() {{{
		function cutBranch(branch) {
			let parentBranch = this.array;
			let branchIndex = this.array.indexOf(branch);
			let branchID = branch.id;
			$http.get("api/delete.php?branch_id=" + branchID)
			.then(
				function(response){
					if(!response.data.error)
						parentBranch.splice(branchIndex, 1);
					else
						alert("Error deleting!");
				},
				function(response) {/*error*/}
			);
		}
		// }}}
		// updateBranchName() {{{
		function updateBranchName(newName, branch) {
			let branchID = branch.id;
			$http.get("api/update.php?branch_id=" + branchID + "&new_name=" + newName)
			.then(
				function(response){
					if(!response.data.error)
						branch.name = newName;
					else
						alert("Error updating branch name!");
				},
				function(response) {/*error*/}
			);
		}
		// }}}
		// updateBranchParentID() {{{
		function updateBranchParentID(item, newParentID) {
			let branchID = item.id;
			$http.get("api/update.php?branch_id=" + branchID + "&new_parent_id=" + newParentID)
			.then(
				function(response){
					if(!response.data.error)
						item.parent_id = newParentID;
					else
						alert("Error updating branch parent id!");
				},
				function(response) {/*error*/}
			);
		}
		// }}}
		this.addBranch = addBranch;
		this.cutBranch = cutBranch;
		this.updateBranchName = updateBranchName;
		this.updateBranchParentID = updateBranchParentID;
	},
	template: `
		<ul style="list-style-type: none">
			<li data-ng-repeat="branch in $ctrl.array"
				dnd-list="branch.branch"
				dnd-draggable="branch"
				dnd-effect-allowed="move"
				dnd-moved="$ctrl.array.splice($index, 1)"
				dnd-inserted="$ctrl.updateBranchParentID(item, branch.id)"
			>
				<div
					ng-mouseleave="showActions=false"
				>
					<a role="button" class="lead"
						ng-show="branch.branch.length > 0"
						ng-init="childrenAreHidden=false"
						ng-click="childrenAreHidden=!childrenAreHidden"
					>
						{{childrenAreHidden ? '+' : '-'}}
					</a>
					<span class="lead"
						ng-show="!nameIsEditable"
						ng-mouseover="showActions=true"
						ng-dblclick="nameIsEditable=true"
					>
						{{branch.name}}
					</span>
					<input
						ng-show="nameIsEditable"
						ng-init="newName=branch.name"
						ng-model="newName"
						ng-blur="$ctrl.updateBranchName(newName, branch); nameIsEditable=false"
					/>
					<a role="button" class="text-success"
						ng-show="showActions && !addingNewBranch"
						ng-click="addingNewBranch=true"
					>
						add
					</a>
					<input
						ng-show="addingNewBranch"
						ng-model="newBranchName"
						ng-blur="$ctrl.addBranch(newBranchName, branch); addingNewBranch=false"
						placeholder="Enter new branch name..."
					/>
					<a role="button" class="text-danger"
						ng-show="showActions"
						ng-click="$ctrl.cutBranch(branch);"
					>
						delete
					</a>
				</div>
				<tree ng-if="branch.branch" array="branch.branch" ng-show="!childrenAreHidden"></tree>
			</li>
		</ul>
	`
});
