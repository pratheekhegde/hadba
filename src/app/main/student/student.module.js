(function ()
{
    'use strict';

    angular
        .module('app.student', [
          'app.student.ready',
          'app.student.start'
    ])
        .config(config);

    /** @ngInject */
    function config()
    {}

})();
