(function ()
{
    'use strict';

    angular
        .module('app.student', [
          'app.student.ready'
    ])
        .config(config);

    /** @ngInject */
    function config()
    {}

})();
