(function ()
{
    'use strict';

    angular
        .module('app.elearning')
        .controller('ElearningController', ElearningController);

    /** @ngInject */
    function ElearningController($mdDialog, $document, $mdSidenav, EMaterialService, eResourceFilters)
    {
        var vm = this;
        // Data
        vm.eMaterial = EMaterialService.data;
        //The factory were the sidenav filter values are stored.
        vm.cardFilters = eResourceFilters;
        vm.cards = vm.eMaterial;

        // Methods
        vm.toggleSidenav = toggleSidenav;
        //Filter cards when showing in ng-repeat
        vm.cardFilter = cardFilter;
        vm.showVideo = showVideo;

        //////////

        /**
         * Toggle sidenav
         *
         * @param sidenavId
         */
        function toggleSidenav(sidenavId)
        {
            $mdSidenav(sidenavId).toggle();
        }

        /**
         * Show Video dialog
         *
         * @param card
         */
        function showVideo(e, card)
        {
            showVideoDialog(e, card);
        }

        /**
         * Show showVideo  dialog
         *
         * @param e
         * @param card
         */
        function showVideoDialog(e, card)
        {
            $mdDialog.show(
            {
                controller: 'ShowVideoDialogController',
                controllerAs: 'vm',
                templateUrl: 'app/main/elearning/dialogs/show-video/show-video-dialog.html',
                parent: angular.element($document.body),
                targetEvent: e,
                clickOutsideToClose: true,
                locals:
                {
                    Card: card
                }
            })
        }

        /**
         * Elearning Resources Card filter
         *
         * @param card
         * @returns {*}
         */
        function cardFilter(card)
        {

            try
            {
                if (angular.lowercase(card.resourceName).indexOf(angular.lowercase(vm.cardFilters.name)) < 0)
                {
                    throw false;
                }

                if (vm.cardFilters.eMaterialSkilltype.length > 0)
                {
                    if (vm.cardFilters.eMaterialSkilltype.indexOf(card.skillType) == -1)
                    {
                        throw false;
                    }
                }

            }
            catch (err)
            {
                return err;
            }

            return true;
        }

    }

})();
