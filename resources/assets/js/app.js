var app = angular.module('app', [
  'ui.bootstrap',
  'textAngular',
  'ngFileUpload'
])
  .config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
  });
