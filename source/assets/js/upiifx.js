 (function(){
	String.prototype.replaceAt=function(index, _char) {
		return this.substr(0, index) + _char + this.substr(index+_char.length);
	}
	var dz=angular.module('upii', ['ngAnimate', 'ui.bootstrap', 'ngCookies']);
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
				var capitalized = inputValue.toUpperCase();
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
	dz.controller('BCTRL', ['$scope','$http','$cookies', function($scope,$http){
			var ctrl=this;
			$scope.title="";
			$scope.currSemYr="Seleccionar";
			$scope.canAdd=false;
			$('#formdata').hide();
			$('#altnomdiv').hide();
			$http.get(endpoint+'?r=sas&n=b')
				.success(function(data, status, headers, config) {
					$scope.data2=data;
					$('#wait2').hide();
					}).
			error(function(data, status, headers, config) {
				   });
		ctrl.bOnClick=function(b){
			$scope.data3=b;
			$scope.bshowform=false;
			$('#formdata').show();
			$('#altnomdiv').hide();
			$('#nomdiv').show();
			$('#wait3').hide();
			$('#submitok').hide();
			if(b.bid<0){
				$('#altnomdiv').show();
				$('#nomdiv').hide();
				$scope.visible=false;
				b.altNom="Alumnos sin beca";
			}
			else{
				$scope.visible=true;
			}
			$scope.title=b.nom;
		}
	}]);
	dz.controller('ACTRL', ['$scope','$http','$cookies', function($scope,$http,ngDialog){
		var ctrl=this;
		$scope.master = {};
		$('.wait3').hide();
		$('.ok-gif').hide();
		$scope.currSemYr="Seleccionar";
		$scope.canAdd=false;
		$scope.reset = function() {
			$scope.a = angular.copy($scope.master);
		};
		$scope.dynamicPopover = {
			content: 'Hello, World!',
			templateUrl: 'myPopoverTemplate.html',
			title: 'Title'
		};
		$scope.placement = {
			options: [
			  'top',
			  'top-left',
			  'top-right',
			  'bottom',
			  'bottom-left',
			  'bottom-right',
			  'left',
			  'left-top',
			  'left-bottom',
			  'right',
			  'right-top',
			  'right-bottom'
			],
			selected: 'left'
		};
		$scope.newA = function() {
			$scope.reset();
			$scope.showAddForm=!$scope.showAddForm;
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
		$scope.ysOnClick=function(y,s){
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
			$('.wait3').show();
			$http.post(endpoint+'?r=waw&n=a',data)
				.success(function(data, status, headers, config) {
					if(status==200){
						$('.wait3').hide();
						$('.ok-gif').show();
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
					if(status==200){
						ctrl.ysOnClick($scope.currYr,$scope.currSem);
					}
				});
		}
		$scope.scope=function(a){
			$scope.a=a;
		}
		}]);
			 
	dz.controller('STACTRL', ['$scope','$http','$cookies', function($scope,$http){
		$scope.title="";
		
		$scope.xy=function(a){
			$http.get(endpoint+'?r=sta&n='+a)
				.success(function(data, status, headers, config) {
					if(status==200){
						//var chart = new CanvasJS.Chart("chartContainer", {"title":"","data":[{"dataPoints":[{"label":"(Sin beca)","y":54},{"label":"Institucional A","y":0},{"label":"Institucional B","y":0},{"label":"Institucional C","y":0},{"label":"Pronabes","y":12},{"label":"B\u00e9calos","y":1},{"label":"h-h","y":0},{"label":"Telmex","y":0},{"label":"Alto Rendimiento","y":0},{"label":"Probeup","y":2}],"type":"spline"}]});
						var chart = new CanvasJS.Chart("chartContainer", data);
						chart.render();
					}
			});
			
		}
	}]);
	dz.controller('LINTMPCTRL', ['$scope','$http','$cookies', function($scope,$http){
		$scope.title="";
		$('#wait1').hide();
		$scope.xy=function(a){
			$scope.a=a;
			$http.get(endpoint+'?r=stq&n='+a._id)
				.success(function(data, status, headers, config) {
					if(status==200){
						/*var chart = new CanvasJS.Chart("chartContainer"
							, {"title":""
							,animationEnabled: true
							,axisY:{
								title: "",
								titleFontFamily: "arial",
								interval:1,
								minimum:-1,
								thickness:1,
								labelFormatter: function(e){
									if(e.value==0)
										return  "";
									if(e.value==-1)
										return  "(Sin beca)";
									if(e.value==1)
										return  "Institucional A";
									if(e.value==2)
										return  "Institucional B";
									if(e.value==3)
										return  "Institucional C";
									if(e.value==4)
										return  "Pronabes";
									if(e.value==5)
										return  "Bécalos";
									if(e.value==6)
										return  "h-h";
									if(e.value==7)
										return  "Telmex";
									if(e.value==8)
										return  "Alto Rendimiento";
									if(e.value==9)
										return  "Probeup";
							}}
							,data:[
							{toolTipContent: "<span style='\"'color: {color};'\"'><strong>{name}</strong></span>"
							,"dataPoints":[{"label":"2010-1","y":-1},{"label":"2010-2","y":1,"name":"(Sin beca)"},{"label":"2011-1","y":4},{"label":"2011-2","y":3},{"label":"2012-1","y":2},{"label":"2012-1","y":1},{"label":"2013-1","y":5},{"label":"2013-2","y":6},{"label":"2014-1","y":7},{"label":"2014-2","y":8}],"type":"scatter"}
							]});*/
						data.axisY.labelFormatter=function(e){
									if(e.value==0)
										return  "";
									if(e.value==-1)
										return  "(Sin beca)";
									if(e.value==1)
										return  "Institucional A";
									if(e.value==2)
										return  "Institucional B";
									if(e.value==3)
										return  "Institucional C";
									if(e.value==4)
										return  "Pronabes";
									if(e.value==5)
										return  "Bécalos";
									if(e.value==6)
										return  "h-h";
									if(e.value==7)
										return  "Telmex";
									if(e.value==8)
										return  "Alto Rendimiento";
									if(e.value==9)
										return  "Probeup";
							};
						var chart = new CanvasJS.Chart("chartContainer", data);
						chart.render();
					}
			});
		}
		
		$scope.search=function(q){
			$('#wait1').show();
			if(!q)q='%';
			$http.get(endpoint+'?r=seek&q='+q)
				.success(function(data, status, headers, config) {
					if(status==200){
						$scope.data1=data;
						$('#wait1').hide();
					}
			});
		}
	}]);
	dz.controller('LCTRL', ['$scope','$http','$cookies', function($scope,$http,$cookies){
		$scope.showLoginErrMsg=false;
		$scope.mnu=new Object();
		if($cookies.get("sssnid")){
			$scope.sssn=new Object();
			$scope.sssn.id=$cookies.get("sssnid");
			$scope.sssn.usr=$cookies.get("sssnusr");
			$scope.sssn.flgs=$cookies.get("sssnflgs");
			$scope.showSessionInfo=true;
			$scope.mnu.a="alumnos.html";
			$scope.mnu.e="estadisticas.html";
			$scope.mnu.b="becas.html";
			$scope.mnu.l="lineatiempo.html";
		}
		else{
			$scope.showSessionInfo=false;	
			$scope.mnu.a=null;
			$scope.mnu.e=null;
			$scope.mnu.b=null;
			$scope.mnu.l=null;
		}
		$scope.login=function(u){
			$scope.showLoginErrMsg=false;
			var v=new Object();	
			v.id=u.id;
			v.z=btoa(u.z);
			$http.post(endpoint+'?r=zzz',v)
				.success(function(data, status, headers, config) {
					if(status==200){
						$scope.mnu.a="alumnos.html";
						$scope.mnu.e="estadisticas.html";
						$scope.mnu.b="becas.html";
						$scope.mnu.l="lineatiempo.html";
						var expd=new Date(data.created);
						expd.setSeconds(expd.getSeconds()+parseInt(data.duration));
						$cookies.put("sssnid",data.sssnid,{expires:expd});
						$cookies.put("sssnusr",data.user,{expires:expd});
						$cookies.put("sssnflgs",data.flags,{expires:expd});
						$scope.sssn=new Object();
						$scope.sssn.id=$cookies.get("sssnid");
						$scope.sssn.usr=$cookies.get("sssnusr");
						$scope.sssn.flgs=$cookies.get("sssnflgs");
						$scope.showSessionInfo=true;
					}
				})
				.error(function(data, status, headers, config) {
					if(status==404){
						$scope.showLoginErrMsg=true;
					}
				});;
		}
	}]);
  })();