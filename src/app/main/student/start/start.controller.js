(function() {
  'use strict';

  angular
    .module('app.student.start')
    .controller('StudentStartController', StudentStartController);

  /** @ngInject */
  function StudentStartController($state, $mdToast, api, Timetable) {
    var vm = this;

    angular.element(document).ready(function() {
      toastr.warning('Feedback form of each subject can be filled and submitted only once!', 'Important', {
        positionClass: "toast-bottom-left",
        timeOut: 10000
      })
      toastr.info('Comments have been discontinued.', 'This is sad', {
        positionClass: "toast-bottom-left",
        timeOut: 10000
      })
    });



    // Data
    vm.timetable = Timetable.timetable;
    vm.sessionClassName = Timetable.class_name;
    
    // Methods

    //

    //////////


  }
})();