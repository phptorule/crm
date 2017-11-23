(function () {
    'use strict';

    angular.module('app').controller('Task_managerCtrl', ['$rootScope', '$scope', '$uibModal', '$filter', '$location', '$timeout', '$window', 'request', 'validate', 'logger', 'langs', 'plugins', 'Page', Task_managerCtrl]);

    function Task_managerCtrl($rootScope, $scope, $uibModal, $filter, $location, $timeout, $window, request, validate, logger, langs, plugins, Page) {


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
        $scope.models = {};
        $scope.models.selected = null;
        $scope.show_settings = false;
        $scope.show_input_card = true;
        $scope.counter = 0;
        $scope.all = 0;



        $scope.task_title_edit = function() {

            if($scope.title == false){
                $scope.title = true;
                $scope.title_edit = false;
            }else{
                $scope.title = false;
                $scope.title_edit = true;
            }

        };

        $scope.saveTitle = function(id,name) {

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
            }else{
                $scope.button_add_card = false;
                $scope.button_input_card = true;
            }

        };


        $scope.getTask = function() {
            request.send('/TaskManager/getTask', $scope.list, function(data) {
                $scope.tasks = data;

                for (var k in data)
                {
                    $scope.cards[k] = data[k].cards;
                    $scope.all += data[k].cards.length;
                }
            });
        };

        $scope.deleteTask = function(id) {
            $scope.id = id;
            request.send('/TaskManager/deleteTask', {'id': $scope.id}, function(data) {
                $scope.tasks = data;
                for (var k in data)
                {
                    $scope.cards[k] = data[k].cards;
                }

            });
        };



        $scope.initTask = function() {

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
                    $scope.all += data[k].cards.length;
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

        $scope.initSortable = function() {
            $scope.counter++;
            if ($scope.counter == $scope.all) {
                $( function() {
                    $('.outer').sortable({
                        items: ".sortable-outer"
                    });

                    $('.inner').sortable({
                        items: ".sortable-inner"
                    });
                });
            }
        };
    };
})();


//modal
(function () {
    'use strict';

    angular.module('app').controller('ModalSelectCardCtrl', ['$rootScope', '$scope', '$uibModal', '$uibModalInstance', '$filter', 'request', 'validate', 'logger', 'langs', 'items', ModalSelectCardCtrl]);

    function ModalSelectCardCtrl($rootScope, $scope, $uibModal, $uibModalInstance, $filter, request, validate, logger, langs, items) {
        

        $scope.card = {};
        $scope.card.card_id = items;
        $scope.card_title = true;
        $scope.card_title_edit = false;
        $scope.card.comments = {};
        $scope.status_description = true;
        $scope.status_description_textarea = false;
        $scope.users_in_card = {};
        $scope.customers = {};
        $scope.customers.customer_type = '0';
        $scope.check = 1;
        $scope.not_checked_users = [];
        $scope.checked_users = [];
        $scope.checked_ids = [];
        $scope.discount_window = [];
        $scope.discount_window[0] = false;
        $scope.discount_sum_window = false;
        $scope.openCheklistForm = [];
        $scope.openCheklistForm[0] = false;
        $scope.vat_window = [];
        $scope.vat_window[0] = false;
        $scope.vat_sum_window = false;
        $scope.show_description = true;
        $scope.showAddUsers = false;
        $scope.editCardUser = false;
        $scope.temp_description = '';

        $scope.getTeamUsers = function() {
            request.send('/Taskmanager/getTeamUsers', {}, function(data) {
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


        $scope.SaveUserToCard = function(card_id) {       

            request.send('/TaskManager/saveUserToCard', {'users':$scope.checked_users, 'card_id':card_id}, function(data) {
                $scope.card.users_work_in_card = data;
                //console.log($scope.users_work_in_card);
            });

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

        $scope.makeDescriptionCopy = function() {
            $scope.old_description = angular.copy($scope.temp_description);
        };

        $scope.reset = function() {
            $scope.card.description = $scope.old_description;
            $scope.temp_description = $scope.old_description;
            $scope.show_description = true;
        };
        

        $scope.getCard = function() {
            request.send('/TaskManager/getCard', {'card_id': $scope.card.card_id}, function(data) {
                $scope.card = data;
                $scope.temp_description = $scope.card.description;
            });
        };

        $scope.saveCard = function() {
            $scope.card.description = $scope.temp_description;
            request.send('/TaskManager/saveCard', $scope.card, function(data) {
                $scope.card = data;
            });
            $scope.show_description = false;
        };


        $scope.getTask = function() {
            request.send('/TaskManager/getTask', $scope.list, function(data) {
                $scope.tasks = data;
            });
        };


        $scope.initTask = function() {
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

        $scope.openCheklistForm = function(index) {
            $scope.openCheklistForm[index] = ! $scope.openCheklistForm[index];
            $scope.vat_window[index] = false;
        };

        //comments begin
        $scope.initComments = function() {
            request.send('/TaskManager/initComments', {'card_id':items}, function(data) {
                $scope.card.comments = data;
            });
        };

        $scope.saveComment = function(text) {
            request.send('/TaskManager/saveComment', {'text':text, 'card_id':items}, function(data) {
                $scope.card.comments = data;
            });
        };
        //comments end


        //checklist begin
        $scope.initChecklist = function() {
            request.send('/TaskManager/initChecklist', {'card_id':items}, function(data) {
                $scope.card.checklist = data;
            });
        };

        $scope.saveChecklistTitle = function(title) {
            request.send('/TaskManager/saveChecklistTitle', {'title':title,'card_id':items}, function(data) {
                $scope.card.checklist = data;
            });
        };

        $scope.saveChecklistValue = function(checklist_id,title) {
            request.send('/TaskManager/saveChecklistValue', {'checklist_id':checklist_id,'title':title,'card_id':items}, function(data) {
                $scope.card.checklist = data;
            });
        };
        
        $scope.saveChangeChecklistStatus = function(checkbox_value_id) {
            request.send('/TaskManager/saveChangeChecklistStatus', {'checkbox_value_id':checkbox_value_id,'card_id':items}, function(data) {
                $scope.card.checklist = data;
            });
        };
        
        $scope.showChackBoxInput  = function(checklist_id) {

            if($scope.showChackBox == false){
                $scope.showChackBox = true;
                $scope.show_checkbox_input = checklist_id;
            }else{
                $scope.showChackBox = false;
                $scope.show_checkbox_input = checklist_id;
            }
        };

        $scope.deleteCheckList = function(id) {
            request.send('/TaskManager/deleteCheckList', {'checklist_id':id,'card_id':items}, function(data) {
                $scope.card.checklist = data;
            });
        };

        $scope.deleteCheckBox = function(id) {
            request.send('/TaskManager/deleteCheckBox', {'checkbox_id':id,'card_id':items}, function(data) {
                $scope.card.checklist = data;
            });
        };
        
        //checklist end

        //datapicker
        $scope.saveDeadline = function(deadline) {
            console.log(deadline);
            request.send('/TaskManager/saveDeadline', {'deadline':deadline,'card_id':items}, function(data) {
                $scope.card = data;
            });
        };

        $scope.dateOptions = {
            startingDay: 1,
            showWeeks: false
        };

        $scope.date = [{
            opened: false
        }, {
            opened: false
        }];

        $scope.calendarOpen = function(index) {
            $scope.date[index].opened = true;
        };

        $scope.setDate = function(issue_date, payment_date) {
            if (issue_date && payment_date)
            {
                $scope.finances_issue_date = new Date(issue_date);
                $scope.finances_payment_date = new Date(payment_date);
            }
            else
            {
                $scope.finances_issue_date = new Date();
                $scope.finances_payment_date = new Date();
            }
        };
        $scope.setDate();

        //datapicker end

    };
})();