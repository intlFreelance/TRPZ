var app = angular.module('app', [
  'ui.bootstrap'
])
  .config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
  });
