app.controller('PackageController', function($scope, $http, $log, $filter, Upload) {
  $scope.destinationSegments = [];
  $scope.destinationSegmentIds = [];
  $scope.getDestinations = getDestinations;
  $scope.getDestinationByBreadcrumb = getDestinationByBreadcrumb;
  $scope.missingDates = false;
  $scope.addHotel = addHotel;
  $scope.removeHotel = removeHotel;
  $scope.addedHotels = [];
  $scope.categories = [];
  $scope.selectActivityCategory = selectActivityCategory;
  $scope.addActivity = addActivity;
  $scope.removeActivity = removeActivity;
  $scope.addedActivities = [];
  $scope.submit = submit;
  
  getDestinations(null);
  
  function getDestinations(destination) {
    $scope.city = '';
    if (destination && destination.destinationCode) {
      getHotels(destination);
      getActivities(destination);
      return;
    }
    storeDestination(destination);
    var destinationPath = $scope.destinationSegmentIds.join('/');
    $http.get('/admin/packages/json/destinations/' + destinationPath)
      .then(function successCallback(response) {
        if (response.data[0].destinationId === '0') {
          getCitiesWithoutState(response.data);
          return;
        }
        $scope.destinations = response.data;
    })
    .catch(function errorCallback(error) {
      $log.error('Failed to load destination', error);
    });
  }

  function getCitiesWithoutState(emptyState) {
    var destinationPath = $scope.destinationSegmentIds.join('/');
    destinationPath += '/' + emptyState[0].id;
    $http.get('/admin/packages/json/destinations/' + destinationPath)
      .then(function(response) {
        $scope.destinations = response.data;
      })
      .catch(function(error) {
        $log.error('Failed to load destination', error);
      });
  }

  function storeDestination(destination) {
    if (destination) {
      $scope.destinationSegments.push(destination)
      $scope.destinationSegmentIds.push(destination.id);
    }
  }

  function getDestinationByBreadcrumb(destination, $index) {
    if ($index > 0) {
      $scope.destinationSegments = $scope.destinationSegments.slice(0, $index);
      $scope.destinationSegmentIds = $scope.destinationSegmentIds.slice(0, $index);
      getDestinations(destination);
      return;
    }
    $scope.destinationSegments = [];
    $scope.destinationSegmentIds = [];
    getDestinations(destination);
  }

  function getHotels(destination) {
    $scope.missingDates = false;
    $scope.city = destination.name;
    var hotelUrl = '/admin/search-hotels?' +
    'destination=' + destination.destinationCode +
    '&start-date=' + $filter('date')($scope.startDate, 'yyyy-MM-dd') +
    '&end-date=' + $filter('date')($scope.endDate, 'yyyy-MM-dd');
    $http.get(hotelUrl)
      .then(function(response) {
        console.log(response.data);
        $scope.hotels = response.data.Hotel;
      })
      .catch(function(error) {
        $scope.missingDates = true;
        $log.error('Failed to load hotels', error);
      });
  }

  function addHotel(hotel) {
    var alreadyAddedIndex = $scope.addedHotels.indexOf(hotel);
    if (alreadyAddedIndex < 0) {
      $scope.addedHotels.push(hotel);
    }
  }

  function removeHotel(hotel) {
    var indexToRemove = $scope.addedHotels.indexOf(hotel);
    $scope.addedHotels.splice(indexToRemove, 1);
  }

  function getActivities(destination) {
    $scope.missingDates = false;
    var activityUrl = '/admin/search-activities?' +
    'destination-id=' + destination.destinationId +
    '&start-date=' + $filter('date')($scope.startDate, 'yyyy-MM-dd') +
    '&end-date=' + $filter('date')($scope.endDate, 'yyyy-MM-dd');
    $http.get(activityUrl)
      .then(function(response) {
        console.log(response.data);
        $scope.activityCategories = response.data.Category;
      })
      .catch(function(error) {
        $scope.missingDates = true;
        $log.error('Failed to load Activities', error);
      });
  }

  function selectActivityCategory(category) {
    selectedActivityCategory = category;
    $scope.activities = category.Activities.Activity;
  }

  function addActivity(activity) {
    var alreadyAddedIndex = $scope.addedActivities.indexOf(activity);
    if (alreadyAddedIndex < 0) {
      $scope.addedActivities.push(activity);
    }
    console.log($scope.addedActivities);
  }

  function removeActivity(activity) {
    var indexToRemove = $scope.addedHotels.indexOf(activity);
    $scope.addedActivities.splice(indexToRemove, 1);
  }

  function submit(file) {
    var formData = new FormData();
    formData.append("imgUpload", file);
    var newPackage = {
      name: $scope.name,
      categoryId: $scope.categoryId,
      description: $scope.description,
      numberOfDays: $scope.numberOfDays,
      startDate: $filter('date')($scope.startDate, 'yyyy-MM-dd'),
      endDate: $filter('date')($scope.endDate, 'yyyy-MM-dd'),
      numberOfPeople: $scope.numberOfPeople,
      dealEnd: $filter('date')($scope.dealEnd, 'yyyy-MM-dd H:mm'),
      markup: $scope.markup,
      hotelIds: getHotelIds(),
      activityIds: getActivityIds()
    };
    formData.append("newPackage", JSON.stringify(newPackage));
    $http.post('/admin/save-package', formData,{
       headers: {'Content-Type': undefined },
       transformRequest: angular.identity
    }).then(function(response) {
        console.log(response);
      })
      .catch(function(error) {
        $log.error('Failed to create package', error);
      });
  }

  function getHotelIds() {
    var ids = [];
    $scope.addedHotels.forEach(function(hotel) {
      ids.push(hotel.hotelId);
    });
    return ids;
  }

  function getActivityIds() {
    var ids = [];
    $scope.addedActivities.forEach(function(activity) {
      ids.push(activity.activityId);
    });
    return ids;
  }
});
