 (function(){
  var dz=angular.module('upii',[]);
  var endpoint="http://ss.localhost:82/rest/api.php";
  dz.controller('BCTRL', ['$scope','$http', function($scope,$http){
			var ctrl=this;
			$scope.title="";
			$scope.currSemYr="Seleccionar";
			$scope.canAdd=false;
			$http.get(endpoint+'?r=sas&n=a')
				.success(function(data, status, headers, config) {
					$scope.data1=data;
					$('#wait2').hide();
					})
				.error(function(data, status, headers, config) {
				   });
			$http.get(endpoint+'?r=sas&n=b')
				.success(function(data, status, headers, config) {
					$scope.data2=data;
					$('#wait2').hide();
					}).
			error(function(data, status, headers, config) {
				   });
		ctrl.bOnClick=function(id,name){
			$scope.data3=null;
			$('#wait1').show();
			$scope.title=name;
			$http.get(endpoint+'?r=sas&n=a&bid='+id)
				.success(function(data, status, headers, config) {
					$scope.data11=data;
					$('#wait1').hide();
					})
				.error(function(data, status, headers, config) {
				   });
			 }
			 }]);
	dz.controller('ACTRL', ['$scope','$http', function($scope,$http){
		var ctrl=this;
		$scope.currSemYr="Seleccionar";
		$scope.canAdd=false;
		$scope.formSemData = {
			availableOptions: [
			  {id: '1', name: '1'},
			  {id: '2', name: '2'}
			],
			selectedOption: {id: '1', name: '1'}
		};
		$http.get(endpoint+'?r=sab&n=d')
			.success(function(data, status, headers, config) {
				$scope.data3=data;
				$scope.formYearData = {
					availableOptions: data,
					selectedOption: {sem: '2', year: '2016'}
				};
				$('#wait2').hide();
				})
			.error(function(data, status, headers, config) {
			   });
		ctrl.ysOnClick=function(y,s){
			$scope.data31=null;
			$('#wait1').show();
			$scope.canAdd=true;
			$scope.currSem=s;
			$scope.currYr=y;
			$scope.currSemYr=' '+y+' - '+s;
			$http.get(endpoint+'?r=sas&n=a&s='+s+'&y='+y)
				.success(function(data, status, headers, config) {
					 $scope.data31=data;
					 $('#wait1').hide();
					 })
				.error(function(data, status, headers, config) {
				   });
			 }
		$scope.updateA=function(a){
			var data=$scope.a;
			$http.post(endpoint+'?r=waw&n=a',data)
				.success(function(data, status, headers, config) {
					if(data.err){
						alert(data.err);
					}
				})
				.error(function(data, status, headers, config) {
				});
		}
			 }]);
  })();