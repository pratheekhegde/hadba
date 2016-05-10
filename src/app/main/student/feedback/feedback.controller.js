(function() {
  'use strict';

  angular
    .module('app.student.feedback')
    .controller('StudentFeedbackController', StudentFeedbackController);

  /** @ngInject */
  function StudentFeedbackController($state, $mdToast, $mdDialog, $stateParams, $window, api) {
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
    vm.submitFeedbackForm = submitFeedbackForm;

    //////////

    /**
     * Submit Feedback form
     *
     * @param ev
     */
    function submitFeedbackForm(ev) {
      //prepare the payload
      var feedback = {
        emp_code: vm.subject.emp_code,
        class_code: $window.sessionStorage.getItem('session-class'),
        feedback: vm.feedbackForm.marks
      }

      $mdDialog.show({
        controller: function($scope, $mdDialog, feedbackData, api) {
          $scope.feedbackData = feedbackData;
          
          // API call to save the Feedback
          api.student.sendFeedback.save(feedbackData).$promise.then(function(response) {
            if (response.status == "201") {
              $mdDialog.hide();
              toastr.success('Your Feedback was saved.', 'Awesome!', {
                positionClass: "toast-bottom-left",
                timeOut: 3000
              })
              $state.go('app.student-start');

            } else if (response.status == "400") {
              $mdDialog.hide();
              toastr.error('Something went wrong while saving!', 'Ouch!', {
                positionClass: "toast-bottom-left",
                timeOut: 3000
              })
              $state.go('app.student-start');

            }
          });
        },
        template: '<md-dialog>' +
          '  <md-dialog-content>' +
          '<div layout="row" layout-align="space-around"><md-progress-circular class="md-accent md-hue-1" md-diameter="90" md-mode="indeterminate"></md-progress-circular></div>' +
          '<h2 align="center">Saving feedback</h2>' +
          '</md-dialog-content>' +
          '</md-dialog>',
        parent: angular.element('body'),
        targetEvent: ev,
        locals: {
          feedbackData: feedback,
          api: api,
        },
        clickOutsideToClose: false,
        escapeToClose: false
      });

      // Clear the form data
      vm.feedbackForm.marks = {};
    }


  }
})();