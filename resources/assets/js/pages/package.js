app.controller('PackageController', function($scope, $http) {
  $http.get('/admin/packages/json/destinations').then(function successCallback(response) {
    if (200 == response.status) {
      $scope.destinations = response.data;
    }
  }, function errorCallback(response) {
    //
  });
});
