(function() {
  'use strict';

  angular
    .module('app.student.feedback')
    .controller('StudentFeedbackController', StudentFeedbackController);

  /** @ngInject */
  function StudentFeedbackController($state, $mdToast, $stateParams, api) {
    var vm = this;

    // Data
    vm.subject = $stateParams.subject;
    vm.class_name = $stateParams.class_name;

    //[TODO] load question from an API
    vm.questions = [{
      "q_num": "1",
      "question": "Is enthusiastic and seems to enjoy teaching."
    }, {
      "q_num": "2",
      "question": "Objectives and plan of the course were specified clearly."
    }]

    // Methods

    //

    //////////


  }
})();