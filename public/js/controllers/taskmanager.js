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
        
        $scope.users = {};

        $scope.title = true;
        $scope.title_edit = false;

        $scope.button_add_card = true;
        $scope.button_input_card = false;


        $scope.task_title_edit = function() {

            if($scope.title == false){
                $scope.title = true;
                $scope.title_edit = false;
                //$scope.show_button_card = false;
            }else{
                $scope.title = false;
                $scope.title_edit = true;
                //$scope.show_button_card = true;
            }

        };

        $scope.saveTitle = function(id,name) {

            //console.log('Works');

            request.send('/TaskManager/saveTitle', {'id': id,'name': name}, function(data) {

                $scope.tasks = data;

                for (var k in data)
                {
                    $scope.cards[k] = data[k].cards;
                }

            });
        };


        $scope.show_input_card = function() {

            if($scope.button_add_card == false){
                $scope.button_add_card = true;
                $scope.button_input_card = false;
                //$scope.show_button_card = false;
            }else{
                $scope.button_add_card = false;
                $scope.button_input_card = true;
                //$scope.show_button_card = true;
            }

        };

        
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
        $scope.card_title = true;
        $scope.card_title_edit = false;
        $scope.status_description = true;
        $scope.status_description_textarea = false;

        $scope.customers = {};
        $scope.customers.customer_type = '0';
        $scope.check = 1;
        $scope.not_checked_users = [];
        $scope.checked_users = [];
        $scope.checked_ids = [];
        $scope.discount_window = [];
        $scope.discount_window[0] = false;
        $scope.discount_sum_window = false;
        $scope.vat_window = [];
        $scope.vat_window[0] = false;
        $scope.vat_sum_window = false;



        $scope.getTeamUsers = function() {
            request.send('/users/getTeamUsers', {}, function(data) {
                $scope.original_users = data;
                $scope.users = [];
                $scope.users_list = $scope.original_users[0].users_id.toString();

                for (var k in $scope.original_users)
                {
                    if ($scope.inArray($scope.customers.users_ids, $scope.original_users[k].users_id))
                    {
                        $scope.users.push($scope.original_users[k]);
                    }
                }
                $scope.updateUserList();
            });
        };

        $scope.addUser = function(user_id) {
            $scope.checked_ids.push(user_id);
            $scope.updateUserList();
        };

        $scope.removeUser = function(user_id) {
            var temp = [];
            for (var k in $scope.checked_ids)
            {
                if ($scope.checked_ids[k] != user_id)
                {
                    temp.push($scope.checked_ids[k]);
                }
            }
            $scope.checked_ids = temp;

            $scope.updateUserList();
        };

        $scope.updateUserList = function() {
            $scope.not_checked_users = [];
            $scope.checked_users = [];

            for (var k in $scope.original_users)
            {
                if ($scope.inArray($scope.checked_ids, $scope.original_users[k].users_id))
                {
                    $scope.checked_users.push($scope.original_users[k]);
                }
                else
                {
                    $scope.not_checked_users.push($scope.original_users[k]);
                }
            }
        };

        $scope.inArray = function(list, value) {
            var result = false;

            for (var k in list)
            {
                if (list[k] == value)
                {
                    result = true;
                }
            }

            return result;
        };


        $scope.status_card_title_edit  = function() {

            if($scope.card_title == false){
                $scope.card_title = true;
                $scope.card_title_edit = false;
            }else{
                $scope.card_title = false;
                $scope.card_title_edit = true;
            }

        };

        $scope.saveCardTitle = function(id,name) {

            request.send('/TaskManager/saveCardTitle', {'id': id,'name': name}, function(data) {

                $scope.card = data;

            });
        };


        $scope.show_description  = function() {

            if($scope.status_description == false){
                $scope.status_description = true;
            }else{
                $scope.status_description = false;
            }


            if($scope.status_description_textarea == false){
                $scope.status_description_textarea = true;
            }else{
                $scope.status_description_textarea = false;
            }

        };

        $scope.addToCard = function(id) {

            request.send('/TaskManager/addToCard', {'user_id': id, 'card_id': $scope.card.id}, function(data) {
                $scope.card = data;
            });


        };


        $scope.reset = function(id) {

            request.send('/TaskManager/reset', {'card_id': id}, function(data) {
                $scope.card = data;
            });
        };
        

        $scope.getCard = function() {

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


        $scope.openDiscount = function(index) {
            $scope.discount_window[index] = ! $scope.discount_window[index];
            $scope.vat_window[index] = false;
        };
    };
})();