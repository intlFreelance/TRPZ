var app = angular.module('app', [
  'ui.bootstrap',
  'textAngular',
  'ngFileUpload',
  'ui.multiselect'
])
  .config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
  });
