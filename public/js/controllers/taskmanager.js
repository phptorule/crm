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
        //$scope.title = true;
        $scope.title = {};
        $scope.title_edit = false;
        $scope.button_add_card = true;
        $scope.button_input_card = false;
        $scope.models = {};
        $scope.models.selected = null;
        $scope.show_settings = false;
        $scope.show_input_card = true;
        $scope.counter = 0;
        $scope.all = 0;

        $scope.getTask = function() {
            request.send('/TaskManager/getTask', {}, function(data) {
                $scope.tasks = data;

                for (var k in data)
                {
                    $scope.all += data[k].cards.length;
                }

                console.log($scope.tasks);
            });
        };

        $scope.getListTeamUsers = function(list_id) {
            request.send('/TaskManager/getListTeamUsers', {'list_id': list_id}, function(data) {
                $scope.list.this_lists_id = list_id;
                $scope.users = data.users;
                $scope.team_users = data.users_not_checked;
                $scope.users_list = $scope.team_users[0].users_id.toString();
            });
        };

        $scope.saveUserToList = function(user_id,list_id) {
            request.send('/TaskManager/saveUserToList', {'users_id': user_id, 'lists_id': list_id}, function(data) {
                $scope.getListTeamUsers(list_id);
            });
        };

        $scope.removeUserList = function(user_id,list_id) {
            request.send('/TaskManager/removeUserList', {'users_id': user_id, 'lists_id': list_id}, function(data) {
                $scope.getListTeamUsers(list_id);
            });
        };

        $scope.addTask = function() {
            request.send('/TaskManager/addTask', $scope.list, function(data) {
                $scope.getTask();
            });
        };

        $scope.saveTitle = function(id,name) {
            request.send('/TaskManager/saveTitle', {'id': id,'name': name}, function(data) {
                //$scope.getTask();
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

        $scope.selectCard = function(cards_id) {
            var modalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'SelectCard.html',
                controller: 'ModalSelectCardCtrl',
                resolve: {
                    items: cards_id
                }
            });

            modalInstance.result.then(function(response) {
            }, function () {

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

        $scope.$watch('$viewContentLoaded', function(){
            $scope.initScroll();
        });

        $scope.initScroll = function(){

              var curDown = false,
                  curYPos = 0,
                  curXPos = 0,
                  curScroll = 0;


              $('.task_manager_board').mousemove(function(m){
                if(curDown === true){
                 $('.task_manager_board').scrollLeft(curScroll + (curXPos - m.pageX));
                }
              });

              $('.task_manager_board').mousedown(function(m){
                curDown = true;
                curYPos = m.pageY;
                curXPos = m.pageX;
                curScroll = $('.task_manager_board').scrollLeft();
              });

              $('.task_manager_board').mouseup(function(){
                curDown = false;
              });
        }

    };
})();

(function () {
    'use strict';

    angular.module('app').directive('focusMe', ['$timeout', '$parse', function ($timeout, $parse) {
        return {
            link: function (scope, element, attrs) {
                var model = $parse(attrs.focusMe);
                scope.$watch(model, function (value) {
                    if (value === true) {
                        $timeout(function () {
                            element[0].selectionStart = element[0].value.length;
                            element[0].selectionEnd = element[0].value.length;
                            element[0].focus();
                        });
                    }
                });
            }
        };
    }]);

})();


//modal
(function () {
    'use strict';

    angular.module('app').controller('ModalSelectCardCtrl', ['$rootScope', '$scope', '$uibModal', '$uibModalInstance', '$filter', 'request', 'validate', 'logger', 'langs', 'items', ModalSelectCardCtrl]);

    function ModalSelectCardCtrl($rootScope, $scope, $uibModal, $uibModalInstance, $filter, request, validate, logger, langs, items) {


        $scope.card = {};
        $scope.card.cards_id = items;
        $scope.card_title = true;
        //$scope.card_title_edit = false;
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
        $scope.comment_text = '';
        $scope.card_users_ids = [];
        $scope.team_users_ids = [];
        $scope.team_userss = [];
        $scope.users_teamssa = [];

        $scope.editChecklistItem = [];
        for (var i = 0; i < 20; i++)
        {
            $scope.editChecklistItem[i] = true;
        }

        $scope.initCard = function() {
            $scope.getCard();
            $scope.getTeamUsers();
        };

        $scope.getCard = function() {
            request.send('/TaskManager/getCard', {'cards_id': $scope.card.cards_id}, function(data) {
                $scope.card = data;
                $scope.checklists = data.checklists;
                $scope.comments = data.comments;
                $scope.temp_description = $scope.card.description;
                $scope.users = data.users;
            });
        };

        $scope.getTeamUsers = function() {
            request.send('/TaskManager/getTeamUsers', {'cards_id': $scope.card.cards_id}, function(data) {
                $scope.team_users = data;
                $scope.users_list = $scope.team_users[0].users_id.toString();
            });
        };

        $scope.saveUserToCard = function(user_id) {
            request.send('/TaskManager/saveUserToCard', {'users_id': user_id, 'cards_id': $scope.card.cards_id}, function(data) {
                $scope.getCard();
                $scope.getTeamUsers();
            });
        };

        $scope.removeUser = function(user_id) {
            request.send('/TaskManager/removeUser', {'users_id': user_id, 'cards_id': $scope.card.cards_id}, function(data) {
                $scope.getCard();
                $scope.getTeamUsers();
            });
        };

        $scope.saveCardTitle = function(id,name) {
            request.send('/TaskManager/saveCardTitle', {'id': id,'name': name}, function(data) {
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

        $scope.saveCardDescription = function() {
            $scope.card.description = $scope.temp_description;
            request.send('/TaskManager/saveCardDescription', $scope.card, function(data) {
                $scope.getCard();
            });
            $scope.show_description = false;
        };

        $scope.cancel = function() {
            $uibModalInstance.dismiss('cancel');
        };

        //comments begin
        $scope.saveComment = function() {
            request.send('/TaskManager/saveComment', {'text': $scope.comment_text, 'cards_id': $scope.card.cards_id}, function(data) {
                $scope.getCard();
            });
        };
        //comments end


        //checklists begin
        $scope.makeCheckboxDescriptionCopy = function(k, l) {
            $scope.old_checkbox_description = angular.copy($scope.checklists[l].checkboxes[k].title);
        };

        $scope.resetCheckboxDescription = function(k, l) {
            $scope.checklists[l].checkboxes[k].title = $scope.old_checkbox_description;
        };

        $scope.saveChecklist = function() {
            request.send('/TaskManager/saveChecklist', {'title': $scope.checklists.title, 'cards_id': $scope.card.cards_id}, function(data) {
                $scope.getCard();
            });
        };

        $scope.addCheckbox = function(checkbox) {
            request.send('/TaskManager/addCheckbox', checkbox, function(data) {
                $scope.getCard();
            });
        };

        $scope.changeCheckboxStatus = function(checkbox_id) {
            request.send('/TaskManager/changeCheckboxStatus', {'checkbox_value_id': checkbox_id, 'cards_id': $scope.card.cards_id}, function(data) {
                $scope.getCard();
            });
        };

        $scope.deleteChecklists = function(id) {
            request.send('/TaskManager/deleteChecklists', {'checklists_id': id,'cards_id': $scope.card.cards_id}, function(data) {
                $scope.getChecklists();
            });
        };

        $scope.deleteCheckBox = function(id) {
            request.send('/TaskManager/deleteCheckBox', {'checkbox_id': id,'cards_id': $scope.card.cards_id}, function(data) {
                $scope.getCard();
            });
        };
        //checklists end

        //datapicker
        $scope.saveDeadline = function(deadline) {
            request.send('/TaskManager/saveDeadline', {'deadline': deadline,'cards_id': $scope.card.cards_id}, function(data) {
                $scope.getCard();
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
        //datapicker end

    };
})();