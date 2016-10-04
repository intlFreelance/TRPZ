var app = angular.module('app', [
  'ui.bootstrap',
  'textAngular'
])
  .config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
  });
