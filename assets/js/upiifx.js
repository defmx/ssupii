 (function(){
  var dz=angular.module('upii',[]);
  dz.controller('CTRL', ['$scope','$http', function($scope,$http){
                         var ctrl=this;
                         $scope.title="";
                         $scope.currSem="14 - 2";
                         $http.get('http://ssupii.azurewebsites.net/z/ls?q=sch').
                         success(function(data, status, headers, config) {
                                 data='{"a":"a","sch":'+data+'}';
                                 var a=JSON.parse(data);
                                 $scope.data1=a;
                                 }).
                         error(function(data, status, headers, config) {
                               });
                         $http.get('http://ssupii.azurewebsites.net/z/ls?q=sem').
                         success(function(data, status, headers, config) {
                                 data='{"a":"a","sem":'+data+'}';
                                 var a=JSON.parse(data);
                                 $scope.data2=a;
                                 }).
                         error(function(data, status, headers, config) {
                               });
                         ctrl.bOnClick=function(id,name){
                         $scope.title=name;
                         $http.get('http://ssupii.azurewebsites.net/z/ls?q=alumn&w='+id).
                         success(function(data, status, headers, config) {
                                 data='{"a":"a","alumn":'+data+'}';
                                 var a=JSON.parse(data);
                                 $scope.data3=a;
                                 }).
                         error(function(data, status, headers, config) {
                               });
                         }
                         ctrl.semOnClick=function(y,s){
                         $scope.currSem=' '+y+' - '+s;
                         $http.get('http://ssupii.azurewebsites.net/z/ls?q=alumn&sem='+y+'-'+s).
                         success(function(data, status, headers, config) {
                                 data='{"a":"a","sem":'+data+'}';
                                 var a=JSON.parse(data);
                                 $scope.data=a;
                                 }).
                         error(function(data, status, headers, config) {
                               });
                         }
                         }]);
  })();