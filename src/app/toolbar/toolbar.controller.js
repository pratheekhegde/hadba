(function() {
  'use strict';

  angular
    .module('app.toolbar')
    .controller('ToolbarController', ToolbarController);

  /** @ngInject */
  function ToolbarController($rootScope, $mdSidenav, $translate, $mdToast, $interval) {
    var vm = this;
    vm.clock = "";
    var timer;

    // Run a timer everysecond to display the current time (Simulate a clock)
    timer = $interval(function() {
      vm.clock = Date.now();
    }, 1000);

    // Data
    vm.bodyEl = angular.element('body');

    // Methods
    vm.toggleSidenav = toggleSidenav;
    vm.toggleHorizontalMobileMenu = toggleHorizontalMobileMenu;

    //////////

    init();

    /**
     * Initialize
     */
    function init() {

    }

    /**
     * Toggle sidenav
     *
     * @param sidenavId
     */
    function toggleSidenav(sidenavId) {
      $mdSidenav(sidenavId).toggle();
    }

    /**
     * Toggle horizontal mobile menu
     */
    function toggleHorizontalMobileMenu() {
      vm.bodyEl.toggleClass('ms-navigation-horizontal-mobile-menu-active');
    }
  }

})();