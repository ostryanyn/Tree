<!DOCTYPE html>
<html ng-app="myApp">
	<head>
		<title>Tree</title>
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-theme.css.css">
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<link rel="stylesheet" type="text/css" href="assets/css/tree.css">
		<script src="assets/js/angular.js"></script>
		<script src="assets/js/angular-drag-and-drop-lists.js"></script>
		<!--<script src="node_modules/jquery/dist/jquery.js"></script>-->
		<script src="assets/js/app.js"></script>
	</head>
	<body>
		<div class="container" ng-controller="myController as ctrl">
			<h1>Tree</h1>
			<tree class="tree" array="data"></tree>
		</div>
	</body>
</html>

