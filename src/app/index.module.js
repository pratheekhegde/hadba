(function() {
  'use strict';

  angular
    .module('openffs', [
      'ngAnimate',
      'ngCookies',
      'ngSanitize',
      'ngMessages',
      'ngResource',
      'ui.router',
      'ngMaterial',
      'toastr',

      // Modules of the app
      'app.navigation',
      'app.toolbar'
    ]);

})();
