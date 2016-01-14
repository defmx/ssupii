 (function(){
  var dz=angular.module('upii',[]);
  var endpoint="http://ss.localhost:82/rest/api.php";
  dz.controller('CTRL', ['$scope','$http', function($scope,$http){
			var ctrl=this;
			$scope.title="";
			$scope.currSem="Seleccionar";
			$http.get(endpoint+'?r=sas&n=a').
			success(function(data, status, headers, config) {
					$scope.data1=data;
					$('#wait2').hide();
					}).
			error(function(data, status, headers, config) {
				   });
			$http.get(endpoint+'?r=sas&n=b').
			success(function(data, status, headers, config) {
					$scope.data2=data;
					$('#wait2').hide();
					}).
			error(function(data, status, headers, config) {
				   });
			$http.get(endpoint+'?r=sab&n=d').
			success(function(data, status, headers, config) {
					$scope.data3=data;
					$('#wait2').hide();
					}).
			error(function(data, status, headers, config) {
				   });
		ctrl.bOnClick=function(id,name){
			$scope.data3=null;
			$('#wait1').show();
			$scope.title=name;
			$http.get(endpoint+'?r=sas&n=a&bid='+id).
				success(function(data, status, headers, config) {
					$scope.data11=data;
					$('#wait1').hide();
					}).
				error(function(data, status, headers, config) {
				   });
			 }
		ctrl.ysOnClick=function(y,s){
			$scope.data31=null;
			$('#wait1').show();
			$scope.currSem=' '+y+' - '+s;
			$http.get(endpoint+'?r=sas&n=a&s='+s+'&y='+y).
				success(function(data, status, headers, config) {
					 $scope.data31=data;
					 $('.wait-gif').hide();
					 }).
				error(function(data, status, headers, config) {
				   });
			 }
			 }]);
  })();