(function () {
    'use strict';

    angular.module('app').controller('Task_managerCtrl', ['$rootScope', '$scope', '$uibModal', '$filter', '$location', '$timeout', '$window', 'request', 'validate', 'logger', 'langs', 'plugins', 'Page', Task_managerCtrl]);

    function Task_managerCtrl($rootScope, $scope, $uibModal, $filter, $location, $timeout, $window, request, validate, logger, langs, plugins, Page) {
    	$scope.types_list = ['By Month', 'By Year', 'Custom Period'];
		$scope.months_list = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        //
        $scope.list = {};
        $scope.desl = [];
        //$scope.name_task_block;
        //
        //$scope.list = [];
        $scope.tasks = {};
        $scope.card = {};


        //$scope.cards.ids = []

        
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


                //$scope.cards = data[0].cards;
                //console.log($scope.cards);
                //console.log($scope.tasks);


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


        /////////////////////////////////////////

        $scope.initTask = function() {
            //request.send('/add_task', {'post':$scope.name_task_block}, function(data) {
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
            //request.send('/add_task', {'post':$scope.name_task_block}, function(data) {
            //console.log(id);
            $scope.card.task_id = id;
            request.send('/TaskManager/createCard',$scope.card, function(data) {
                //$scope.card = data;

                $scope.tasks = data;

                for (var k in data)
                {
                    $scope.cards[k] = data[k].cards;
                }

            });


        };







        //////
        $scope.selectCard = function(card_id) {

            //console.log(card_id);
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
        


        $scope.card_id = items;


        $scope.list = {};
        $scope.desl = [];

        $scope.tasks = {};
        $scope.card = {};

        
        $scope.class = "closed";
        $scope.cards = [];
        $scope.mass = [];

        $scope.getCard = function() {

            console.log($scope.card_id);
            request.send('/TaskManager/getCard', {'card_id': $scope.card_id}, function(data) {

                $scope.card_modal = data;


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