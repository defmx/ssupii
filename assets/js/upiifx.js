(function(){
	var dz=angular.module('upii',[]);
	dz.controller('CTRL', ['$scope','$http', function($scope,$http){
	$http.get('http://ssupii.azurewebsites.net/z/s').
		success(function(data, status, headers, config) {
			data='{"a":"a","sch":'+data+'}';
			var a=JSON.parse(data);
			$scope.data=a;
		}).
		error(function(data, status, headers, config) {
		});
	}]);
})();