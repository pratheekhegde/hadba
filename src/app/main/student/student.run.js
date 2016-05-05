(function() {
  'use strict';

  angular
    .module('app.student')
    .run(runBlock);

  /** @ngInject */
  function runBlock($rootScope, $timeout, $state, $window, api) {
    // On state change check if session is running or not
    $rootScope.$on('$stateChangeStart', function() {
      // Get the FeedbackSessionStatus
      api.student.getFeedbackSessionStatus.get({},
        // Success
        function(response) {
          //set status value to sessionStorage
          $window.sessionStorage.setItem('session-status', response.status);
          if (response.status == 0) {
            //redirect to ready page
            $state.go('app.student-ready');
          } else if (response.status == 1) {
            //Get FeedbackSessionClass
            api.student.getFeedbackSessionClass.get({},
              // Success
              function(response) {
                //set session class value to sessionStorage
                $window.sessionStorage.setItem('session-class', response.class_code);
              },
              // Error
              function(response) {
                console.error(response);
              }
            );
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