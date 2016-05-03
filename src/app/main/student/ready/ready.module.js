(function ()
{
    'use strict';

    angular
        .module('app.student.ready', [])
        .config(config);

    /** @ngInject */
    function config($stateProvider)
    {
        // State
        $stateProvider.state('app.student-ready',
        {
            url: '/student/ready',
            views:
            {
                'content@app':
                {
                    templateUrl: 'app/main/student/ready/ready.html',
                    controller: 'StudentReadyController as vm'
                }
            }
        });
    }
})();
