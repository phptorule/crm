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
        $scope.card.id = items;
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
        $scope.openCheklistForm = false;
        $scope.vat_window = [];
        $scope.vat_window[0] = false;
        $scope.vat_sum_window = false;
        $scope.show_description = true;
        $scope.showAddUsers = false;
        $scope.editCardUser = false;
        $scope.showCheckBox = true;
        $scope.temp_description = '';
        $scope.checkbox_active = true;
        $scope.checklists = {};
        $scope.old_checkbox_description = [];
        $scope.cards_users = [];

        $scope.editChecklistItem = [];
        for (var i = 0; i < 20; i++)
        {
            $scope.editChecklistItem[i] = true;
        }

        $scope.initCard = function() {
            $scope.getCard();
            $scope.getCardUsers();
            $scope.getTeamUsers();
            $scope.getChecklists();
            $scope.getComments();
        };

        $scope.getCard = function() {
            request.send('/Taskmanager/getCard', {'card_id': $scope.card.id}, function(data) {
                $scope.card = data;
                $scope.temp_description = $scope.card.description;
            });
        };

        $scope.getTeamUsers = function() {
            request.send('/Taskmanager/getTeamUsers', {}, function(data) {
                $scope.team_users = data;
                $scope.not_checked_ids = [];
                $scope.users_list = $scope.team_users[0].users_id.toString();

                for (var k in $scope.team_users)
                {
                    $scope.not_checked_ids[k] = $scope.team_users[k].users_id;
                }

                $scope.updateUserList();
            });
        };

        $scope.updateUserList = function() {
            $scope.not_checked_users = [];
            $scope.checked_users = [];

            if ($scope.cards_users != 0)
            {
                $scope.not_checked_users = [];
                //console.log($scope.cards_users);
                for (var k in $scope.team_users)
                {
                    if ($scope.inArray($scope.cards_users, $scope.team_users[k].users_id))
                    {

                    }
                    else
                    {
                        $scope.not_checked_users.push($scope.team_users[k]);
                        $scope.users_list = $scope.not_checked_users[0].users_id.toString();
                    }
                }
            }
            else
            {
                for (var k in $scope.team_users)
                {
                    $scope.not_checked_users.push($scope.team_users[k]);
                    $scope.users_list = $scope.not_checked_users[0].users_id.toString();
                }
            }

        };

        $scope.getCardUsers = function() {
            request.send('/Taskmanager/getCardUsers', {'card_id': $scope.card.id}, function(data) {
                $scope.users = data;

                for (var k in data)
                {
                    $scope.cards_users[k] = data[k].users_id;
                }

                $scope.updateUserList();
            });
        };

        $scope.saveUserToCard = function(user_id) {
            request.send('/Taskmanager/saveUserToCard', {'user_id': user_id, 'card_id': $scope.card.id}, function(data) {
                $scope.users = data;

                for (var k in data)
                {
                    $scope.cards_users[k] = data[k].user_id;
                }

                $scope.updateUserList();
                $scope.getCardUsers();
            });
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

        $scope.saveCardTitle = function(id,name) {
            request.send('/Taskmanager/saveCardTitle', {'id': id,'name': name}, function(data) {
                $scope.card = data;
            });
        };

        $scope.addToCard = function(id) {
            request.send('/Taskmanager/addToCard', {'user_id': id, 'card_id': $scope.card.id}, function(data) {
                $scope.card = data;
            });
        };

        $scope.makeDescriptionCopy = function() {
            $scope.old_description = angular.copy($scope.temp_description);
        };

        $scope.resetCardDescription = function() {
            $scope.card.description = $scope.old_description;
            $scope.temp_description = $scope.old_description;
            $scope.show_description = true;
        };

        $scope.saveCard = function() {
            $scope.card.description = $scope.temp_description;
            request.send('/Taskmanager/saveCard', $scope.card, function(data) {
                $scope.card = data;
            });
            $scope.show_description = false;
        };


        $scope.getTask = function() {
            request.send('/Taskmanager/getTask', $scope.list, function(data) {
                $scope.tasks = data;
            });
        };

        $scope.initTask = function() {
            request.send('/Taskmanager/addTask', $scope.list, function(data) {
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

        //comments begin
        $scope.getComments = function(text) {
            request.send('/Taskmanager/getComments', {'card_id': $scope.card.id}, function(data) {
                $scope.comments = data;
            });
        };

        $scope.saveComment = function(text) {
            request.send('/Taskmanager/saveComment', {'text':text, 'card_id': $scope.card.id}, function(data) {
                $scope.getComments();
            });
        };
        //comments end


        //checklist begin
        $scope.getChecklists = function() {
            request.send('/Taskmanager/getChecklists', {'card_id': $scope.card.id}, function(data) {
                $scope.checklists = data;
            });
        };

        $scope.makeCheckboxDescriptionCopy = function(k, l) {
            $scope.old_checkbox_description = angular.copy($scope.checklists[l].checkboxes[k].title);
        };

        $scope.resetCheckboxDescription = function(k, l) {
            $scope.checklists[l].checkboxes[k].title = $scope.old_checkbox_description;
        };

        $scope.saveChecklist = function() {
            request.send('/Taskmanager/saveChecklist', {'title': $scope.checklists.title, 'card_id': $scope.card.id}, function(data) {
                $scope.getChecklists();
            });
        };

        $scope.saveChecklistValue = function(checkbox) {
            request.send('/Taskmanager/saveChecklistValue', checkbox, function(data) {
                $scope.getChecklists();
            });
        };

        $scope.createCheckboxItem = function(checkbox) {
            request.send('/Taskmanager/createCheckboxItem', checkbox, function(data) {
                $scope.getChecklists();
            });
        };

        $scope.saveChangeChecklistStatus = function(checkbox_id) {
            request.send('/Taskmanager/saveChangeChecklistStatus', {'checkbox_value_id': checkbox_id, 'card_id': $scope.card.id}, function(data) {
                $scope.getChecklists();
            });
        };

        $scope.deleteCheckList = function(id) {
            request.send('/Taskmanager/deleteCheckList', {'checklist_id': id,'card_id': $scope.card.id}, function(data) {
                $scope.getChecklists();
            });
        };

        $scope.deleteCheckBox = function(id) {
            request.send('/Taskmanager/deleteCheckBox', {'checkbox_id': id,'card_id': $scope.card.id}, function(data) {
                $scope.getChecklists();
            });
        };

        //checklist end

        //datapicker
        $scope.saveDeadline = function(deadline) {
            request.send('/Taskmanager/saveDeadline', {'deadline': deadline,'card_id': $scope.card.id}, function(data) {
                $scope.card.deadline = data.deadline;
                $scope.card.reddata = data.reddata;
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