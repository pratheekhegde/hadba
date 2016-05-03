(function ()
{
    'use strict';

    angular
        .module('app.student.ready')
        .controller('StudentReadyController', StudentReadyController);

    /** @ngInject */
    function StudentReadyController($state, $interval, api)
    {
        var vm = this;
        var timer;

        // Run a timer everysecond to check the feedback session status
        timer =   $interval(function() {
                  // Get the FeedbackSessionStatus
                  api.student.getFeedbackSessionStatus.get({},
                          // Success
                          function (response)
                          {
                              if(response.status != 0){
                                $interval.cancel(timer);
                                $state.go('app.sample');
                              }
                              //console.log(response);
                          },
                          // Error
                          function (response)
                          {
                              console.error(response);
                          }
                  );
                }, 1000);

        // Data

        // Methods

        //

        //////////


    }
})();
