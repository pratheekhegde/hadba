(function ()
{
    'use strict';

    angular
        .module('app.elearning', [])
        .config(config);

    /** @ngInject */
    function config($stateProvider, msNavigationServiceProvider)
    {
        $stateProvider.state('app.elearning',
        {
            data:
            {
                restricted: true
            },
            url: '/elearning',
            views:
            {
                'content@app':
                {
                    templateUrl: 'app/main/elearning/elearning.html',
                    controller: 'ElearningController as vm'
                }
            },
            resolve:
            {
                EMaterial: function (apiResolver, EMaterialService)
                {
                    return EMaterialService.getEMaterialData();
                }
            },
            bodyClass: 'elearning'
        });

        // Navigation
        msNavigationServiceProvider.saveItem('elearning',
        {
            title: 'ELearning',
            icon: 'icon-book',
            state: 'app.elearning',
            weight: 6
        });
    }
})();
