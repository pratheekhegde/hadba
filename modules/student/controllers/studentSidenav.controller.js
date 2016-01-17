'use strict';
/**
 * @ngdoc controller
 * @name openFFS.controller:studentSidenavController
 * @description
 * # Sidenav Controller
 * Controller of the openFFSApp
 */
angular.module('openFFSApp')
  .controller('studentSidenavController', function($scope, $mdSidenav) {

    // TO get Current Date
    $scope.date = new Date();

    //For Sidebar Toggle on Resize
    $scope.toggle = function() {
      $mdSidenav('studentLeftSidenav').toggle();
    };

  });
