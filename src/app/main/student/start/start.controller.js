(function() {
  'use strict';

  angular
    .module('app.student.start')
    .controller('StudentStartController', StudentStartController);

  /** @ngInject */
  function StudentStartController($state, $mdToast, $filter, $window, api, Timetable) {
    var vm = this;

    // Data
    vm.timetable = Timetable.timetable;
    vm.sessionClassName = Timetable.class_name;

    // Methods

    //////////

    init();

    /**
     * Initialize
     */
    function init() {
      //Get count of subjects whose feedback is not given yet
      var feedbackRemainingCount = vm.timetable.filter(function(subject) {
        return (subject.feedback_given == false);
      });

      //Redirect to finish when remaining becomes 0
      if (feedbackRemainingCount == 0) {

        $state.go('app.student-finish', {
          feedback_finished: true
        });
      }

      //Show Toast that submission can be done only once
      angular.element(document).ready(function() {
        toastr.warning('Feedback form of each subject can be filled and submitted only once!', 'Important', {
          positionClass: "toast-bottom-left",
          timeOut: 10000
        })
      });
    }


  }
})();