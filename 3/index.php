<!DOCTYPE html>
<html ng-app="treeApp">
	<head>
		<title>Tree</title>
		<script src="/node_modules/angular/angular.js"></script>
		<script src="/node_modules/jquery/dist/jquery.js"></script>
		<script src="tree.js"></script>
	</head>
	<body ng-controller="treeController">
		<div>
			<div ng-repeat="branch in tree">{{branch}}</div>
		</div>
	</body>
</html>

