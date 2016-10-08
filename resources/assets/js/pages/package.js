app.controller('PackageController', function($scope, $http, $log, $filter, Upload) {
  $scope.destinationSegments = [];
  $scope.destinationSegmentIds = [];
  $scope.getDestinations = getDestinations;
  $scope.getDestinationByBreadcrumb = getDestinationByBreadcrumb;
  $scope.missingDates = false;
  $scope.hotelsLoading = false;
  $scope.activitiesLoading = false;
  $scope.addHotel = addHotel;
  $scope.removeHotel = removeHotel;
  $scope.addedHotels = [];
  $scope.categories = [];
  $scope.selectActivityCategory = selectActivityCategory;
  $scope.addActivity = addActivity;
  $scope.removeActivity = removeActivity;
  $scope.addedActivities = [];
  $scope.submit = submit;
  $scope.isArray = angular.isArray;
  $scope.nonFormValidation = nonFormValidation;
  
  getDestinations(null);
  
  function getDestinations(destination) {
    $scope.hotels = [];
    $scope.activityCategories = [];
    $scope.activities = [];
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
    $scope.hotelsLoading = true;
    $scope.missingDates = false;
    $scope.city = destination.name;
    var hotelUrl = '/admin/search-hotels?' +
    'destination=' + destination.destinationCode +
    '&start-date=' + $filter('date')($scope.startDate, 'yyyy-MM-dd') +
    '&end-date=' + $filter('date')($scope.endDate, 'yyyy-MM-dd');
    $http.get(hotelUrl)
      .then(function(response) {
        $scope.hotels = response.data.Hotel;
        console.log($scope.hotels, "hotels");
        $scope.hotelsLoading = false;
      })
      .catch(function(error) {
        $scope.missingDates = true;
        $scope.hotelsLoading = false;
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
    $scope.activityCategories = [];
    $scope.activitiesLoading = true;
    $scope.missingDates = false;
    var activityUrl = '/admin/search-activities?' +
    'destination-id=' + destination.destinationId +
    '&start-date=' + $filter('date')($scope.startDate, 'yyyy-MM-dd') +
    '&end-date=' + $filter('date')($scope.endDate, 'yyyy-MM-dd');
    $http.get(activityUrl)
      .then(function(response) {
        $scope.activityCategories = parseActivities(response.data.Category);
        $scope.activitiesLoading = false;
      })
      .catch(function(error) {
        $scope.missingDates = true;
        $scope.activitiesLoading = false;
        $log.error('Failed to load Activities', error);
      });
  }

  function selectActivityCategory(category) {
    selectedActivityCategory = category;
    $scope.activities = category.activities;
  }

  function addActivity(activity) {
    var alreadyAddedIndex = $scope.addedActivities.indexOf(activity);
    if (alreadyAddedIndex < 0) {
      $scope.addedActivities.push(activity);
    }
  }

  function removeActivity(activity) {
    var indexToRemove = $scope.addedHotels.indexOf(activity);
    $scope.addedActivities.splice(indexToRemove, 1);
  }

  function submit(file, form) {
    if (!form.$valid || !nonFormValidation()) {
          return;
    }

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
      retailPrice: $scope.retailPrice,
      trpzPrice: $scope.trpzPrice,
      jetSetGoPrice: $scope.jetSetGoPrice,
      hotels: $scope.addedHotels,
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


  function getActivityIds() {
    var ids = [];
    $scope.addedActivities.forEach(function(activity) {
      ids.push(activity.activityId);
    });
    return ids;
  }

  function dateValidation() {
    var currDate = new Date();
    var startDate = $scope.startDate;
    var endDate = $scope.endDate;
    var dealEnd = $scope.dealEnd;
    if (startDate < currDate) {
      $scope.startDateMessage = "Start Date must be on or after current date.";
      return false;
    } else if(startDate >= endDate) {
      $scope.startDateMessage = "Start Date must be before End Date date.";
      return false;
    }
    if (dealEnd >= startDate ) {
      $scope.dealEndMessage = "Deal Ends must be before Start Date";
      return false;
    }
    $scope.startDateMessage = '';
    $scope.dealEndMessage = '';
    return true;
  }

  function hotelValidation() {
    if ($scope.addedHotels.length < 1) {
      return false;
    }
    return true;
  }

  function nonFormValidation() {
      return dateValidation() && hotelValidation();
      
  }
});

function parseActivities(categories) {
    var activityCategories = [];
    if (!angular.isArray(categories)) {
      if (!categories || Object.keys(categories).length === 0) {
        return [];
      }
      categories = [categories];
    }
    categories.forEach(function parseCategories(category) {
      var parsedCategory = {};
      parsedCategory['categoryId'] = category.categoryId;
      parsedCategory['categoryName'] = category.categoryName;
      parsedCategory['activities'] = [];
      if (!angular.isArray(category.Activities.Activity)) {
        category.Activities.Activity = [category.Activities.Activity];
      }
      category.Activities.Activity.forEach(function(activity) {
        var parsedActivity = {};
        parsedActivity['activityId'] = activity.activityId;
        parsedActivity['currency'] = activity.currency;
        parsedActivity['name'] = activity.name;
        parsedActivity['starsLevel'] = activity.starsLevel;
        parsedActivity['thumbURL'] = activity.thumbURL;
        parsedActivity['description'] = activity.description;
        parsedActivity['address'] = activity.Location.address;
        parsedActivity['city'] = activity.Location.city;
        parsedActivity['countryCode'] = activity.Location.countryCode;
        parsedActivity['searchingCity'] = activity.Location.searchingCity;
        parsedActivity['options'] = [];
        if (!angular.isArray(activity.ActivityOptions.ActivityOption)) {
          activity.ActivityOptions.ActivityOption = [activity.ActivityOptions.ActivityOption];
        }
        activity.ActivityOptions.ActivityOption.forEach(function(activityOption) {
          var parsedOption = {};
          parsedOption['name'] = activityOption.name;
          parsedOption['type'] = activityOption.type;
          parsedOption['availabilities'] = [];
          if (!angular.isArray(activityOption.Availabilities.Availability)) {
            activityOption.Availabilities.Availability = [activityOption.Availabilities.Availability];
          }
          activityOption.Availabilities.Availability.forEach(function(availability) {
            var parsedAvailability = {};
            parsedAvailability['adultPrice'] = availability.adultPrice;
            parsedAvailability['childPrice'] = availability.childPrice;
            parsedAvailability['unitPrice'] = availability.unitPrice;
            parsedOption.availabilities.push(parsedAvailability);
          });
          parsedActivity.options.push(parsedOption);
        });
        parsedCategory.activities.push(parsedActivity);
      });
      activityCategories.push(parsedCategory);
    });
    return activityCategories;
  }