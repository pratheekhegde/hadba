(function ()
{
    'use strict';

    angular
        .module('app.navigation')
        .controller('NavigationController', NavigationController);

    /** @ngInject */
    function NavigationController($log)
    {
        var vm = this;

        // Data
        vm.currentDate = new Date();
        $log.error('apiResolver.resolve requires correct action parameter (ResourceName@methodName)');

        // Methods


        //////////

    }

})();
