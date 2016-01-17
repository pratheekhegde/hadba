angular.module('openFFSApp', [
  //  'ngResource', // Resource objects for HTTP operations
    'ngMaterial', //Material design components
    'ngMessages', // Input validation messages
    'ngAnimate', //Animation support in AngularJS
    'ui.router', // Single-page application routing,
    'ngMeta', //Update meta tags based on path
    'angular-loading-bar' //Angula Loading Bar
  ])
  .config(function($stateProvider, $urlRouterProvider, ngMetaProvider, $mdThemingProvider, $locationProvider) {

    // [TODO] redirect it to the app homepage
    $urlRouterProvider
     .when('/','/student/feedback')
     .otherwise('/404');

     // Pretty URL (Remove HASHBANG)
    $locationProvider.html5Mode(true);

    // configure the states
    $stateProvider
      .state('feedback', {
        url: '/student/feedback',
        templateUrl: 'modules/student/views/studentHome.html',
        controller: 'studentHomeController',
        meta: {
          title: 'openFFS - Student'
        }
      })
      .state('feedbackStart', {
        url: '/student/feedback/start',
        templateUrl: 'modules/student/views/subjectList.html',
        controller: 'subjectListController',
        meta: {
          title: 'Student - Start Feedback'
        }
      })
      .state('feedbackSend', {
        url: '/student/feedback/form',
        templateUrl: 'modules/student/views/feedbackForm.html',
        controller: 'feedbackFormController',
        meta: {
          title: 'Feedback Form'
        }
      })
      .state('feedbackFinish', {
        url: '/student/feedback/finish',
        templateUrl: 'modules/student/views/feedbackFinish.html',
        controller: 'feedbackFinishController',
        meta: {
          title: 'Student - Finish Feedback'
        }
      })
      .state('404', {
        url: '/404',
        templateUrl: '404.html',
        meta: {
          title: 'oops!'
        }
      });


  })
  .run(function(ngMeta) {
      //Initialize ngMeta
      ngMeta.init();
  });