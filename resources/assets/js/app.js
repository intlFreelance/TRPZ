var app = angular.module('app', [
  'ui.bootstrap',
  'textAngular',
  'ngFileUpload',
  'ui.multiselect',
  'datetimepicker'
])
  .config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
  });
