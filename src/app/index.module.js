(function ()
{
    'use strict';

    /**
     * Main module of the Fuse
     */
    angular
        .module('openffs', [

            // Core
            'app.core',

            // Navigation
            'app.navigation',

            // Toolbar
            'app.toolbar',

            // Quick panel
          //  'app.quick-panel',

            // Sample
            'app.sample',

            // Student Module
            'app.student'
        ]);
})();