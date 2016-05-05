(function() {
  'use strict';

  angular
    .module('app.student.feedback', [])
    .config(config);

  /** @ngInject */
  function config($stateProvider) {
    // State
    $stateProvider.state('app.student-feedback', {
      url: '/student/feedback',
      params: {
        subject: null,
        class_name: null
      },
      data: {
        pageTitle: 'Feedback Form'
      },
      views: {
        'content@app': {
          templateUrl: 'app/main/student/feedback/feedback.html',
          controller: 'StudentFeedbackController as vm'
        }
      },
      onEnter: function($stateParams, $location) {
        //If feedback is opened without subject and class_code redirect to start( eg: if he refreshes the page)
        if ($stateParams.subject == null || $stateParams.class_name == null) {
          $location.url('/student/start');
        }
      }
    });
  }
})();