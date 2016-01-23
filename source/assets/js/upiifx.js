 (function(){
	String.prototype.replaceAt=function(index, _char) {
		return this.substr(0, index) + _char + this.substr(index+_char.length);
	}
  var dz=angular.module('upii',[]);
  var endpoint="http://ss.localhost:82/rest/api.php";
  dz.directive('ngConfirmClick', [
        function(){
            return {
                link: function (scope, element, attr) {
                    var msg = attr.ngConfirmClick;
                    var clickAction = attr.confirmedClick;
                    element.bind('click',function (event) {
                        if ( window.confirm(msg) ) {
                            scope.$eval(clickAction)
                        }
                    });
                }
            };
    }]);
  dz.directive('capitalizeFirst', function(uppercaseFilter, $parse) {
	   return {
		 require: 'ngModel',
		 link: function(scope, element, attrs, modelCtrl) {
			var capitalize = function(inputValue) {
				if(!inputValue) return null;
			   var capitalized = inputValue.charAt(0).toUpperCase() + inputValue.substring(1);
			   if(inputValue.indexOf(' ')>0){
				   capitalized=capitalized.replaceAt(inputValue.indexOf(' ')+1,inputValue.substring(inputValue.indexOf(' ')+1).charAt(0).toUpperCase());
			   }
			   if(capitalized !== inputValue) {
				  modelCtrl.$setViewValue(capitalized);
				  modelCtrl.$render();
				}
				return capitalized;
			 }
			 var model = $parse(attrs.ngModel);
			 modelCtrl.$parsers.push(capitalize);
			 capitalize(model(scope));
		 }
	   };
	});
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
		$scope.master = {};
		$('#wait3').hide();
		$('#submitok').hide();
		$scope.currSemYr="Seleccionar";
		$scope.canAdd=false;
		$scope.reset = function() {
			$scope.a = angular.copy($scope.master);
		};
		$http.get(endpoint+'?r=sas&n=c')
				.success(function(data, status, headers, config) {
					$scope.data1=data;
				});
		$http.get(endpoint+'?r=sas&n=b')
			.success(function(data, status, headers, config) {
				$scope.data2=data;
			});
		$http.get(endpoint+'?r=sab&n=d')
			.success(function(data, status, headers, config) {
				$scope.data3=data;
				$scope.formYearData = {
					availableOptions: data,
					selectedOption: {sem: '2', year: '2016'}
				};
				$('#wait2').hide();
			});
		ctrl.ysOnClick=function(y,s){
			$scope.data31=null;
			$('#wait1').show();
			$scope.canAdd=true;
			$scope.currSem=s;
			$scope.currYr=y;
			$scope.currSemYr=' '+y+' - '+s;
			$http.get(endpoint+'?r=sas&n=b')
				.success(function(data, status, headers, config) {
					$scope.data30=data;
				});
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
			data.bid=$scope.mnuBecas.bid;
			data.cid=$scope.mnuCarr.cid;
			data.sem=$scope.currSem;
			data.yr=$scope.currYr;
			$('#wait3').show();
			$http.post(endpoint+'?r=waw&n=a',data)
				.success(function(data, status, headers, config) {
					if(status===200){
						$('#wait3').hide();
						$('#submitok').show();
						$scope.reset();
						ctrl.ysOnClick($scope.currYr,$scope.currSem);
						setTimeout(function() {
							$('#submitok').hide();
						}, 3000);
					}
				});
		}
		$scope.deleteA=function(a){
			$http.delete(endpoint+'?r=del&n=a&i='+a.id)
				.success(function(data, status, headers, config) {
					if(status===200){
						ctrl.ysOnClick($scope.currYr,$scope.currSem);
					}
				});
		}
			 }]);
  })();