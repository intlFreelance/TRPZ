app.controller('PackageController', function($scope, $http, $log, $filter, Upload, $window) {
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
  $scope.selectedCategories = [];
  $scope.selectActivityCategory = selectActivityCategory;
  $scope.addActivity = addActivity;
  $scope.removeActivity = removeActivity;
  $scope.addedActivities = [];
  $scope.submit = submit;
  $scope.isArray = angular.isArray;
  $scope.nonFormValidation = nonFormValidation;
  $scope.loadModel = loadModel;
  $scope.categories = [];
  
  getDestinations(null);
  getCategories();
  
  function getDestinations(destination) {
    $scope.hotels = [];
    $scope.activityCategories = [];
    $scope.activities = [];
    $scope.city = '';
    if (destination && destination.destinationCode) {
      $scope.addedActivities = [];
      $scope.addedHotels = [];
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
  function getCategories(){
    $http.get('/admin/categories/all')
    .then(function(response){
        $scope.categories = response.data;
    }).catch(function(error){
        $log.error('Failed to load categories', error);
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
      $scope.destinationSegments.push(destination);
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
    var endDate = new Date($scope.startDate);
    endDate.setDate(endDate.getDate() + $scope.numberOfDays);
    var hotelUrl = '/admin/search-hotels?' +
    'destination=' + destination.destinationCode +
    '&start-date=' + $scope.startDate +
    '&end-date=' +  $filter('date')(endDate, 'MM/dd/yyyy');
    $http.get(hotelUrl)
      .then(function(response) {
        $scope.hotels = response.data.Hotel;
        $scope.hotelsLoading = false;
      })
      .catch(function(error) {
        $scope.missingDates = true;
        $scope.hotelsLoading = false;
        $log.error('Failed to load hotels', error);
      });
  }

  function addHotel(hotel) {
	var alreadyAdded = false;
	$scope.addedHotels.forEach(function(addedHotel) {
            if(!alreadyAdded){
                if (parseInt(addedHotel.hotelId) === hotel.hotelId){
                   alreadyAdded = true;
                 }
            }
	});
    if (!alreadyAdded) {
      $scope.addedHotels.push(hotel);
    }
  }

  function removeHotel(hotel) {
    $scope.addedHotels.forEach(function(addedHotel) {
	  if (parseInt(addedHotel.hotelId) === parseInt(hotel.hotelId)){
            var indexToRemove = $scope.addedHotels.indexOf(addedHotel);
            $scope.addedHotels.splice(indexToRemove, 1);
          }
    });
  }

  function getActivities(destination) {
    $scope.activityCategories = [];
    $scope.activitiesLoading = true;
    $scope.missingDates = false;
    var endDate = new Date($scope.startDate);
    endDate.setDate(endDate.getDate() + $scope.numberOfDays);
    var activityUrl = '/admin/search-activities?' +
    'destination-id=' + destination.destinationId +
    '&start-date=' + $scope.startDate +
    '&end-date=' + $filter('date')(endDate, 'yyyy-MM-dd');
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
    var alreadyAdded = false;
    $scope.addedActivities.forEach(function(addedActivity) {
        if(!alreadyAdded){
            if (parseInt(addedActivity.activityId) === activity.activityId){
               alreadyAdded = true;
             }
        }
    });
    if (!alreadyAdded) {
      $scope.addedActivities.push(activity);
    }
  }

  function removeActivity(activity) {
    $scope.addedActivities.forEach(function(addedActivity) {
	  if (parseInt(addedActivity.activityId) === parseInt(activity.activityId)){
            var indexToRemove = $scope.addedActivities.indexOf(addedActivity);
            $scope.addedActivities.splice(indexToRemove, 1);
          }
    });
  }

  function submit(file, form) {
      // console.log(form.$valid,"form valid");
      // console.log(form,"form");
    if (!form.$valid || !nonFormValidation()) {
          return;
    }

    var formData = new FormData();
    formData.append("imgUpload", file);
    var newPackage = {
      id : $scope.id,
      name: $scope.name,
      categories: $scope.selectedCategories,
      amenities : $scope.amenities,
      highlights : $scope.highlights,
      finePrint : $scope.finePrint,
      tripItinerary : $scope.tripItinerary,
      frequentlyAskedQuestions : $scope.frequentlyAskedQuestions,
      otherNotes : $scope.otherNotes,
      numberOfDays: $scope.numberOfDays,
      startDate: $filter('date')($scope.startDate, 'yyyy-MM-dd'),
      endDate: $filter('date')($scope.endDate, 'yyyy-MM-dd'),
      numberOfPeople: $scope.numberOfPeople,
      dealEnd: $filter('date')($scope.dealEnd, 'yyyy-MM-dd hh:mm'),
      retailPrice: $scope.retailPrice,
      trpzPrice: $scope.trpzPrice,
      jetSetGoPrice: $scope.jetSetGoPrice,
      hotels: $scope.addedHotels,
      activities: $scope.addedActivities
    };
    formData.append("newPackage", JSON.stringify(newPackage));
    $http.post('/admin/save-package', formData,{
       headers: {'Content-Type': undefined },
       transformRequest: angular.identity
    }).then(function(response) {
        // console.log(response);
        $window.location.href = '/admin/packages';
      })
      .catch(function(error) {
        $log.error('Failed to create package', error);
      });
  }
  
  function loadModel(id){
    $http.get('/admin/get-package/'+id)
    .then(function(response){
        var package = response.data.package;
        var hotels = response.data.hotels;
        var activities = response.data.activities;
        var categories = response.data.categories;
        $scope.id = package.id;
        $scope.name = package.name;
        $scope.selectedCategories = categories;
        $scope.amenities = package.amenities;
        $scope.highlights = package.highlights;
        $scope.finePrint = package.finePrint;
        $scope.tripItinerary = package.tripItinerary;
        $scope.frequentlyAskedQuestions = package.frequentlyAskedQuestions;
        $scope.otherNotes = package.otherNotes;
        $scope.numberOfDays = package.numberOfDays;
        $scope.startDate = package.startDate;
        $scope.endDate = package.endDate;
        $scope.numberOfPeople = package.numberOfPeople;
        $scope.dealEnd = package.dealEndDate;
        $scope.retailPrice = parseFloat(package.retailPrice);
        $scope.trpzPrice = parseFloat(package.trpzPrice);
        $scope.jetSetGoPrice = parseFloat(package.jetSetGoPrice);
        $scope.addedHotels = hotels;
        $scope.addedActivities  = activities;
    }).catch(function(error){
          console.log(error);
    });
  }

  function dateValidation() {
    var currDate = new Date();
    var startDate = new Date($scope.startDate);
    var endDate = new Date($scope.endDate);
    var dealEnd = new Date($scope.dealEnd);
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
      return dateValidation() && hotelValidation() && categoriesValidation();
      
  }
  function categoriesValidation(){
    if ($scope.selectedCategories.length < 1) {
      return false;
    }
    return true;  
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