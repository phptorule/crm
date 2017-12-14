(function () {
    'use strict';


    angular.module('app').controller('Task_managerCtrl', ['$rootScope', '$scope', '$uibModal', '$filter', '$location', '$timeout', '$window', 'request', 'validate', 'logger', 'langs', 'plugins', 'Page', Task_managerCtrl]);

    function Task_managerCtrl($rootScope, $scope, $uibModal, $filter, $location, $timeout, $window, request, validate, logger, langs, plugins, Page) {


        $scope.list = {};
        $scope.desks = {};
        $scope.desk = {};
        $scope.tasks = {};
        $scope.card = {};
        $scope.class = "closed";
        $scope.cards = [];
        $scope.mass = [];
        $scope.users = {};
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
        $scope.task = {};
        $scope.desk_name = '';
        $scope.desk_id = '';
        $scope.task_name = '';

        $scope.initTaskManager = function() {
            $scope.getDesks();
        };

        /* Norm desks functionality */

        $scope.getDesks = function() {
            request.send('/TaskManager/getDesks', {}, function(data) {
                $scope.desks = data;
                $scope.desk_id = $scope.desks[0].id;
                $scope.getDeskTasks($scope.desk_id);
            });
        };

        $scope.getDeskTasks = function(desk_id) {
            $scope.desk_id = desk_id;

            request.send('/TaskManager/getTasks', {'desk_id': desk_id}, function(data) {
                $scope.tasks = data;

                for (var k in data)
                {
                    $scope.all += data[k].cards.length;
                }
            });
        };

        /* End of Norm desks functionality */

        $scope.saveDesc = function(desc_name) {
            request.send('/TaskManager/saveDesc', {'desc_name':desc_name}, function(data) {
                $scope.getDescs();
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
            request.send('/TaskManager/addTask', {'task_name': $scope.task_name, 'desk_id': $scope.desk_id}, function(data) {
                $scope.getDesks();
            });
        };

        $scope.saveTaskTitle = function(task) {
            request.send('/TaskManager/saveTaskTitle', {'task_id': task.id,'task_name': task.name}, function(data) {

            });

            $scope.title[task.id] = ! $scope.title[task.id];
        };

        $scope.deleteTask = function(id) {
            $scope.id = id;
            request.send('/TaskManager/deleteTask', {'id': $scope.id}, function(data) {
                $scope.getDesks();
            });
        };

        $scope.createCard = function(id) {
            $scope.card.task_id = id;
            request.send('/TaskManager/createCard', $scope.card, function(data) {
                $scope.getDesks();
            });
        };

        $scope.selectCard = function(card) {
            var modalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'SelectCard.html',
                controller: 'ModalSelectCardCtrl',
                resolve: {
                    items: card
                }
            });

            modalInstance.result.then(function(response) {

            }, function () {
                $scope.getDesks();
            });
        };

        $scope.savePosition = function(id,position) {
            request.send('/TaskManager/savePosition',{'id': id,'position': position}, function(data) {
            });
        };

        $scope.initSortable = function() {
            $scope.counter++;

            if ($scope.counter == $scope.all) {
                $( function() {
                    $('.outer').sortable({
                        items: ".sortable-outer",
                        update: function( event, ui ){
                            $scope.da = $(this).sortable('serialize');
                            $scope.savePosition($scope.da);
                        }
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
                if (m.target.closest('.task_manager_list')){
                    curDown = false;
                }else {
                    curDown = true;
                    curYPos = m.pageY;
                    curXPos = m.pageX;
                    curScroll = $('.task_manager_board').scrollLeft();
                }
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

(function () {
    'use strict';

    angular.module('app').directive('ngEnter', function () {
        return function (scope, element, attrs) {
            element.bind("keydown keypress", function (event) {
                if(event.which === 13) {
                    scope.$apply(function (){
                        scope.$eval(attrs.ngEnter);
                    });

                    event.preventDefault();
                }
            });
        };
    });
})();

(function () {
    'use strict';

    angular.module('app').controller('ModalSelectCardCtrl', ['$rootScope', '$scope', '$uibModal', '$uibModalInstance', '$filter', 'request', 'validate', 'logger', 'langs', 'items', ModalSelectCardCtrl]);

    function ModalSelectCardCtrl($rootScope, $scope, $uibModal, $uibModalInstance, $filter, request, validate, logger, langs, items) {
        $scope.card = items;
        $scope.checklists = items.checklists;
        $scope.temp_description = $scope.card.description;
        $scope.users = items.users;
        $scope.card_title = true;
        $scope.status_description = true;
        $scope.status_description_textarea = false;
        $scope.users_in_card = {};
        $scope.check = 1;
        $scope.openCheklistForm = false;
        $scope.show_description = true;
        $scope.showAddUsers = false;
        $scope.editCardUser = false;
        $scope.showCheckBox = {};
        $scope.checkbox_active = true;
        $scope.checklists = {};
        $scope.old_checkbox_description = [];
        $scope.cards_users = [];
        $scope.comment_text = '';
        $scope.card_users_ids = [];
        $scope.team_users_ids = [];
        $scope.temp_users_id = [];
        $scope.checkbox = {};
        $scope.editChecklistItem = {};
        $scope.checklist_title = {};
        $scope.checkbox_title = {};
        $scope.add_checkbox_title = {};
        $scope.deadline= {};
        $scope.temp_users = {};
        $scope.showChecklistTitle = {};
        $scope.not_checked_users = [];
        $scope.checked_users = [];
        $scope.checked_ids = [];
        $scope.checkbox_deadline = {};
        $scope.temp_checkbox_deadline = {};
        $scope.addCheckboxDeadline = false;

        $scope.initCard = function() {
            $scope.getTeamUsers();
            $scope.getCheckboxUsers();

        };

        $scope.saveCardTitle = function() {
            request.send('/TaskManager/saveCardTitle', {'card_id': $scope.card.cards_id,'card_name': $scope.card.name}, function(data) {

            });

            $scope.card_title = ! $scope.card_title;
        };

        $scope.saveCardDescription = function() {
            $scope.card.description = $scope.temp_description;
            request.send('/TaskManager/saveCardDescription', $scope.card, function(data) {

            });

            $scope.show_description = ! $scope.show_description;
        };

        $scope.saveChecklistTitle = function(checklist) {
            request.send('/TaskManager/saveChecklistTitle', {'checklist_id': checklist.id, 'checklist_title': checklist.title}, function(data) {

            });

            $scope.showChecklistTitle[checklist.id] = ! $scope.showChecklistTitle[checklist.id];
        };

        $scope.getTeamUsers = function() {
            request.send('/TaskManager/getTeamUsers', {'cards_id': $scope.card.cards_id}, function(data) {
                $scope.team_users = data;
                if($scope.team_users){
                    $scope.users_list = $scope.team_users[0].users_id.toString();
                }
            });
        };

        $scope.saveUserToCard = function(user_id) {
            request.send('/TaskManager/saveUserToCard', {'users_id': user_id, 'cards_id': $scope.card.cards_id}, function(data) {
                $scope.getTeamUsers();
            });
        };

        $scope.removeUser = function(user_id) {
            request.send('/TaskManager/removeUser', {'users_id': user_id, 'cards_id': $scope.card.cards_id}, function(data) {
                $scope.getTeamUsers();
            });
        };

        $scope.makeDescriptionCopy = function() {
            $scope.old_description = angular.copy($scope.temp_description);
            $scope.show_description = ! $scope.show_description;
        };

        $scope.resetCardDescription = function() {
            $scope.card.description = $scope.old_description;
            $scope.temp_description = $scope.old_description;
            $scope.show_description = true;
        };

        $scope.cancel = function() {
            $uibModalInstance.dismiss('cancel');
        };

        $scope.saveComment = function() {
            request.send('/TaskManager/saveComment', {'text': $scope.comment_text, 'cards_id': $scope.card.cards_id}, function(data) {

            });
        };

        $scope.makeCheckboxDescriptionCopy = function(checkbox) {
            $scope.checkbox_title[checkbox.id] = angular.copy(checkbox.title);
            $scope.editChecklistItem[checkbox.id] = ! $scope.editChecklistItem[checkbox.id];
        };

        $scope.saveCheckboxDescription = function(checkbox) {
            request.send('/TaskManager/saveCheckboxDescription', {'title': $scope.checkbox_title[checkbox.id], 'checkbox_id': checkbox.id}, function(data) {

            });

            checkbox.title = $scope.checkbox_title[checkbox.id];
            $scope.editChecklistItem[checkbox.id] = ! $scope.editChecklistItem[checkbox.id];
        };

        $scope.resetCheckboxDescription = function(checkbox) {
            $scope.editChecklistItem[checkbox.id] = ! $scope.editChecklistItem[checkbox.id];
        };

        $scope.saveChecklist = function() {
            request.send('/TaskManager/saveChecklist', {'title': $scope.checklists.title, 'cards_id': $scope.card.cards_id}, function(data) {
                $scope.getCard();
            });
        };

        $scope.addCheckbox = function(checklist) {
            $scope.checkbox.users = $scope.checked_ids;
            //$scope.checkbox.deadline = $scope.checked_users;
            $scope.checkbox.checklist_id = checklist.id;
            $scope.checkbox.checkbox_title = $scope.add_checkbox_title[checklist.id];
            $scope.temp_users = [];

            request.send('/TaskManager/addCheckbox', $scope.checkbox, function(data) {
                $scope.getCheckboxes(checklist);
            });

            $scope.showCheckBox[checklist.id] = ! $scope.showCheckBox[checklist.id];
            $scope.add_checkbox_title[checklist.id] = '';
            $scope.checked_ids = [];
            $scope.getCheckboxUsers();
        };

        $scope.deleteCheckbox = function(checkbox_id, checklist) {
            request.send('/TaskManager/deleteCheckbox', {'checkbox_id': checkbox_id}, function(data) {
                $scope.getCheckboxes(checklist);
            });
        };

        $scope.getCheckboxes = function(checklist) {
            request.send('/TaskManager/getCheckboxes', {'checklist_id': checklist.id}, function(data) {
                checklist.checkboxes = data;
            });
        };

        $scope.getCheckboxUsers = function() {
            $scope.checkbox_users = angular.copy($scope.users);
            $scope.updateUserList();
        };

        $scope.addUserToCheckbox = function(user_id) {
            $scope.checked_ids.push(user_id);
            $scope.updateUserList();
        };

        $scope.removeCheckboxUser = function(user_id) {
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

            for (var k in $scope.checkbox_users)
            {
                if ($scope.inArray($scope.checked_ids, $scope.checkbox_users[k].users_id))
                {
                    $scope.checked_users.push($scope.checkbox_users[k]);
                }
                else
                {
                    $scope.not_checked_users.push($scope.checkbox_users[k]);
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

        $scope.deletePreviewUserCheckbox = function(user) {
            var temp = [];

            $scope.checkbox_users.push(user);

            for (var k in $scope.temp_users) {

                if (user.users_id == $scope.temp_users[k].users_id){

                }else {
                    temp.push($scope.temp_users[k]);
                }
            }

            $scope.temp_users = temp;
        };

        $scope.addCheckboxDeadline = function() {
            $scope.temp_checkbox_deadline = $scope.checkbox_deadline;
            console.log($scope.checkbox_deadline);
        };

        $scope.clearCheckboxDeadline = function(deadline,h,m) {
            delete $scope.temp_deadline;
        };

        $scope.changeCheckboxStatus = function(checkbox_id) {
            request.send('/TaskManager/changeCheckboxStatus', {'checkbox_value_id': checkbox_id, 'cards_id': $scope.card.cards_id}, function(data) {

            });
        };

        $scope.deleteChecklists = function(id) {
            request.send('/TaskManager/deleteChecklists', {'checklists_id': id,'cards_id': $scope.card.cards_id}, function(data) {
                $scope.getChecklists();
            });
        };

        $scope.saveDeadline = function(deadline,h,m) {
            request.send('/TaskManager/saveDeadline', {'cards_id': $scope.card.cards_id,'deadline': deadline, 'h':h, 'm':m}, function(data) {
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

        $scope.setDate = function() {
            var checkbox_deadline_time = ($scope.checkbox_deadline_time) ? (new Date($scope.checkbox_deadline_time)) : (new Date());
            $scope.checkbox_deadline.hour = checkbox_deadline_time.getHours().toString();
            $scope.checkbox_deadline.minute = checkbox_deadline_time.getMinutes().toString();
            $scope.checkbox_deadline.date = ($scope.checkbox_deadline.date) ? (new Date($scope.checkbox_deadline.date)) : (new Date());
        };

        $scope.setDate();

        $scope.range = function(n) {
            var list = [];
            for (var i = 0; i <= n; i++)
            {
                list.push(i);
            }
            return list;
        };

        $scope.changeDone = function() {
            request.send('/TaskManager/changeDone', {'cards_id': $scope.card.cards_id}, function(data) {
                $scope.getCard();
            });
        };
    };
})();