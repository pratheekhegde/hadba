(function() {
  'use strict';

  angular
    .module('app.student.start', [])
    .config(config);

  /** @ngInject */
  function config($stateProvider) {
    // State
    $stateProvider.state('app.student-start', {
      url: '/student/start',
      data: {
        pageTitle: 'Start Feedback'
      },
      views: {
        'content@app': {
          templateUrl: 'app/main/student/start/start.html',
          controller: 'StudentStartController as vm'
        }
      },
      resolve: {
        Timetable: function(apiResolver, $window) {
          return apiResolver.resolve('student.getClassTimetable@get', {
            'class_code': $window.sessionStorage.getItem('session-class')
          });
        }
      }
    });
  }
})();