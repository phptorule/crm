(function () {
    'use strict';

    angular.module('app').controller('Task_managerCtrl', ['$rootScope', '$scope', '$uibModal', '$filter', '$location', '$timeout', '$window', 'request', 'validate', 'logger', 'langs', 'plugins', 'Page', Task_managerCtrl]);

    function Task_managerCtrl($rootScope, $scope, $uibModal, $filter, $location, $timeout, $window, request, validate, logger, langs, plugins, Page) {
    	$scope.types_list = ['By Month', 'By Year', 'Custom Period'];
		$scope.months_list = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $scope.list = {};
        $scope.desl = [];

        $scope.tasks = {};
        $scope.card = {};

        
        $scope.class = "closed";
        $scope.cards = [];

        $scope.mass = [];
        



        
        $scope.getTask = function() {

            request.send('/TaskManager/getTask', $scope.list, function(data) {

                $scope.tasks = data;

                for (var k in data)
                {
                    $scope.cards[k] = data[k].cards;
                }

            });
        };

        $scope.deleteTask = function(id) {
            $scope.id = id;
            console.log($scope.id);
            request.send('/TaskManager/deleteTask', {'id': $scope.id}, function(data) {
                $scope.tasks = data;

                for (var k in data)
                {
                    $scope.cards[k] = data[k].cards;
                }

            });
        };



        $scope.initTask = function() {

            console.log($scope.list);
            request.send('/TaskManager/addTask', $scope.list, function(data) {
                $scope.tasks = data;

                for (var k in data)
                {
                    $scope.cards[k] = data[k].cards;
                }

            });
        };

        $scope.createCard = function(id) {


            $scope.card.task_id = id;
            request.send('/TaskManager/createCard',$scope.card, function(data) {

                $scope.tasks = data;

                for (var k in data)
                {
                    $scope.cards[k] = data[k].cards;
                }

            });


        };


        $scope.selectCard = function(card_id) {

            var modalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'SelectCard.html',
                controller: 'ModalSelectCardCtrl',
                resolve: {
                    items: card_id
                }
            });
        };
	};
})();


//Модалак
(function () {
    'use strict';

    angular.module('app').controller('ModalSelectCardCtrl', ['$rootScope', '$scope', '$uibModal', '$uibModalInstance', '$filter', 'request', 'validate', 'logger', 'langs', 'items', ModalSelectCardCtrl]);

    function ModalSelectCardCtrl($rootScope, $scope, $uibModal, $uibModalInstance, $filter, request, validate, logger, langs, items) {
        

        $scope.card = {};
        $scope.card.card_id = items;
        

        $scope.getCard = function() {

            console.log($scope.card.card_id);
            request.send('/TaskManager/getCard', {'card_id': $scope.card.card_id}, function(data) {

                $scope.card = data;

            });
        };


        $scope.saveCard = function() {

            request.send('/TaskManager/saveCard', $scope.card, function(data) {

                $scope.card = data;

            });
        };


        $scope.getTask = function() {

            request.send('/TaskManager/getTask', $scope.list, function(data) {

                $scope.tasks = data;

            });
        };


        $scope.initTask = function() {

            console.log($scope.list);
            request.send('/TaskManager/addTask', $scope.list, function(data) {
                $scope.tasks = data;

                for (var k in data)
                {
                    $scope.cards[k] = data[k].cards;
                }

            });
        };





        $scope.cancel = function() {
            $uibModalInstance.dismiss('cancel');
        };
    };
})();