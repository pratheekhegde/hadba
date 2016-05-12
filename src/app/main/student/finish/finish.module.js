(function() {
  'use strict';

  angular
    .module('app.student.finish', [])
    .config(config);

  /** @ngInject */
  function config($stateProvider) {
    // State
    $stateProvider.state('app.student-finish', {
      url: '/student/finish',
      params: {
        feedback_finished: null
      },
      data: {
        pageTitle: 'Finish'
      },
      views: {
        'content@app': {
          templateUrl: 'app/main/student/finish/finish.html',
          controller: 'StudentFinishController as vm'
        }
      }
    });
  }
})();