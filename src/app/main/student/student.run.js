(function() {
  'use strict';

  angular
    .module('app.student')
    .run(runBlock);

  /** @ngInject */
  function runBlock($rootScope, $timeout, $state, api) {
    // On state change check if session is running or not
    $rootScope.$on('$stateChangeStart', function() {
      // Get the FeedbackSessionStatus
      api.student.getFeedbackSessionStatus.get({},
        // Success
        function(response) {
          if (response.status == 0) {
            //redirect to ready page
            $state.go('app.student-ready');
          }
          //console.log(response);
        },
        // Error
        function(response) {
          console.error(response);
        }
      );
    });


  }
})();