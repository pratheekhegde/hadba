(function ()
{
    'use strict';

    angular
        .module('app.student.start', [])
        .config(config);

    /** @ngInject */
    function config($stateProvider)
    {
        // State
        $stateProvider.state('app.student-start',
        {
            url: '/student/start',
            views:
            {
                'content@app':
                {
                    templateUrl: 'app/main/student/start/start.html',
                    controller: 'StudentStartController as vm'
                }
            }
        });
    }
})();
