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
    }, {
      "q_num": "3",
      "question": "Possesses good teaching skills and gives clear explanations."
    }, {
      "q_num": "4",
      "question": "Possesses good communication skills."
    }, {
      "q_num": "5",
      "question": "Has good knowledge of the subject and answers any questions."
    }, {
      "q_num": "6",
      "question": "Comes prepared for the class and doesn’t get upset by questions."
    }, {
      "q_num": "7",
      "question": "Motivates the students to learn more about the subject."
    }]

    // Methods

    //

    //////////


  }
})();