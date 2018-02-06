(function () {
    'use strict';

    angular.module('app').directive('taskCard', function () {
        return {
        	scope: {

        	},
            templateUrl: '/js/directives/task-manager/task-card/task-list.html'
        };
    });
})();