(function() {
  'use strict';

  angular
    .module('openffs')
    .config(routerConfig);

  /** @ngInject */
  function routerConfig($stateProvider, $urlRouterProvider, $locationProvider) {

    //$locationProvider.html5Mode(true);

    $urlRouterProvider.otherwise('/');

    // State definitions
      $stateProvider
          .state('app',
          {
              abstract: true,
              views:
              {
                  'main@':
                  {
                      templateUrl: 'app/core/layout/main.html',
                      controller: 'MainController as vm'
                  },
                  'toolbar@app':
                  {
                      templateUrl: 'app/toolbar/layout/toolbar.html',
                      controller: 'ToolbarController as vm'
                  },
                  'navigation@app':
                  {
                      templateUrl: 'app/navigation/layout/navigation.html',
                      controller: 'NavigationController as vm'
                  }
              }
          });
  }

})();
