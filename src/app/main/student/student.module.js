(function() {
  'use strict';

  angular
    .module('app.student', [
      'app.student.ready',
      'app.student.start',
      'app.student.feedback',
      'app.student.finish'
    ])
    .config(config);

  /** @ngInject */
  function config() {}

})();