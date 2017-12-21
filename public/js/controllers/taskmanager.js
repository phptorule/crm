(function () {
    'use strict';


    angular.module('app').controller('TaskManagerCtrl', ['$rootScope', '$scope', '$uibModal', '$filter', '$location', '$timeout', '$window', 'request', 'validate', 'logger', 'langs', 'plugins', 'Page', TaskManagerCtrl]);

    function TaskManagerCtrl($rootScope, $scope, $uibModal, $filter, $location, $timeout, $window, request, validate, logger, langs, plugins, Page) {
        $scope.list = {};
        $scope.desks = {};
        $scope.tasks = {};
        $scope.card = {};
        $scope.class = "closed";
        $scope.users = {};
        $scope.title = {};
        $scope.title_edit = false;
        $scope.showCreateNewCard = {};
        $scope.desk_title = true;
        $scope.counter = 0;
        $scope.all = 0;
        $scope.task = {};
        $scope.desk_name = '';
        $scope.create_desk_name = '';
        $scope.desk_id = '';
        $scope.task_name = '';
        $scope.card_name = {};

        $scope.getDesks = function() {
            request.send('/TaskManager/getDesks', {}, function(data) {
                $scope.desks = data;
                $scope.desk = data[0];
                $scope.getDeskLists($scope.desk);
            });
        };

        $scope.saveDeskTitle = function() {
            request.send('/TaskManager/saveDeskTitle', $scope.desk, function(data) {

            });

            $scope.desk_title = ! $scope.desk_title;
        };

        $scope.saveDesk = function(desc_name) {
            request.send('/TaskManager/saveDesk', {'desc_name':desc_name}, function(data) {
                $scope.getDesks();
            });
        };

        $scope.getDeskLists = function(desk) {
            $scope.desk = desk;

            request.send('/TaskManager/getDeskLists', {'desk_id': $scope.desk.id}, function(data) {
                $scope.tasks = data;

                for (var k in data)
                {
                    $scope.all += data[k].cards.length;
                }
            });
        };

        $scope.saveUserToList = function(user_id, list_id) {
            request.send('/TaskManager/saveUserToList', {'users_id': user_id, 'lists_id': list_id}, function(data) {
                $scope.getListTeamUsers(list_id);
            });
        };

        $scope.removeUserList = function(user_id, list_id) {
            request.send('/TaskManager/removeUserList', {'users_id': user_id, 'lists_id': list_id}, function(data) {
                $scope.getListTeamUsers(list_id);
            });
        };

        $scope.addTaskList = function() {
            request.send('/TaskManager/addTaskList', {'task_name': $scope.task_name, 'desk_id': $scope.desk.id}, function(data) {
                $scope.getDeskLists($scope.desk);
            });
        };

        $scope.createCard = function(task) {
            request.send('/TaskManager/createCard', {'card_name': $scope.card_name[task.id], 'task_id': task.id}, function(data) {
                task.cards = data;
            });

            $scope.card_name[task.id] = '';
            $scope.showCreateNewCard[task.id] = ! $scope.showCreateNewCard[task.id];
        };

        $scope.getListTeamUsers = function(list_id) {
            request.send('/TaskManager/getListTeamUsers', {'list_id': list_id}, function(data) {
                $scope.list.this_lists_id = list_id;
                $scope.users = data.users;
                $scope.team_users = data.users_not_checked;
                $scope.users_list = $scope.team_users[0].users_id.toString();
            });
        };

        $scope.saveTaskTitle = function(task) {
            request.send('/TaskManager/saveTaskTitle', {'task_id': task.id, 'task_name': task.name}, function(data) {

            });

            $scope.title[task.id] = ! $scope.title[task.id];
        };

        $scope.deleteDesk = function() {
            var modalInstance = $uibModal.open({
                animation: true,
                size: 'sm',
                templateUrl: 'ConfirmWindow.html',
                controller: 'ModalConfirmWindowCtrl',
                resolve: {
                    items: function () {
                        return {
                            'deleted_item': 'desk',
                            'desk': $scope.desk
                        };
                    }
                }
            });

            modalInstance.result.then(function(response) {
                $scope.getDesks();
            }, function () {

            });
        }

        $scope.deleteList = function(task) {
            var modalInstance = $uibModal.open({
                animation: true,
                size: 'sm',
                templateUrl: 'ConfirmWindow.html',
                controller: 'ModalConfirmWindowCtrl',
                resolve: {
                    items: function () {
                        return {
                            'deleted_item': 'task',
                            'task': task
                        };
                    }
                }
            });

            modalInstance.result.then(function(response) {
                $scope.getDeskLists($scope.desk);
            }, function () {

            });
        };

        $scope.addNewCard = function(task) {
            $scope.showCreateNewCard = {};
            $scope.showCreateNewCard[task.id] = ! $scope.showCreateNewCard[task.id];
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
                $scope.getDeskLists($scope.desk);
            }, function () {

            });
        };

        $scope.savePosition = function(id, position) {
            request.send('/TaskManager/savePosition',{'id': id, 'position': position}, function(data) {
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
        $scope.checkboxes = {};
        $scope.temp_description = $scope.card.description;
        $scope.card_title = true;
        $scope.check = 1;
        $scope.show_description = true;
        $scope.showCheckBox = {};
        $scope.checkbox_active = true;
        $scope.old_checkbox_description = [];
        $scope.cards_users = [];
        $scope.comment_text = '';
        $scope.card_users_ids = [];
        $scope.team_users_ids = [];
        $scope.temp_users_id = [];
        $scope.checkbox = {};
        $scope.editCheckbox = {};
        $scope.checklist_title = {};
        $scope.checkbox_title = {};
        $scope.add_checkbox_title = {};
        $scope.deadline= {};
        $scope.temp_users = {};
        $scope.showChecklistTitle = {};
        $scope.not_checked_users = [];
        $scope.checked_users = [];
        $scope.checked_ids = [];
        $scope.card_deadline = {};
        $scope.checkbox_deadline = {};
        $scope.temp_checkbox_deadline = {};
        $scope.showCheckboxDeadline = false;
        $scope.checklist_title = '';

        console.log($scope.show_description);

        $scope.initCard = function() {
            $scope.getTeamUsers();
            $scope.getChecklists();
            $scope.getComments();
            $scope.updateUserList();
        };

        $scope.saveCardTitle = function() {
            request.send('/TaskManager/saveCardTitle', {'card_id': $scope.card.cards_id,'card_name': $scope.card.name}, function(data) {

            });

            $scope.card_title = true;
        };

        $scope.saveCardDescription = function() {
            $scope.card.description = $scope.temp_description;
            request.send('/TaskManager/saveCardDescription', $scope.card, function(data) {

            });

            $scope.show_description = true;
        };

        $scope.deleteCard = function() {
            var modalInstance = $uibModal.open({
                animation: true,
                size: 'sm',
                templateUrl: 'ConfirmWindow.html',
                controller: 'ModalConfirmWindowCtrl',
                resolve: {
                    items: function () {
                        return {
                            'deleted_item': 'card',
                            'card': $scope.card
                        };
                    }
                }
            });

            modalInstance.result.then(function(response) {
                $uibModalInstance.close();
            }, function () {

            });
        };

        $scope.changeDone = function() {
            request.send('/TaskManager/changeDone', {'cards_id': $scope.card.cards_id}, function(data) {
                $scope.card.done = data;
            });
        };

        ////////////////////////////////////

        /* CHECKLISTS */

        $scope.getChecklists = function(card) {
            request.send('/TaskManager/getChecklists', {'cards_id': $scope.card.cards_id}, function(data) {
                $scope.checklists = data;

                for (var k in $scope.checklists)
                {
                    $scope.getCheckboxes($scope.checklists[k]);
                }
            });
        };

        $scope.saveChecklist = function() {
            request.send('/TaskManager/saveChecklist', {'title': $scope.checklist_title, 'cards_id': $scope.card.cards_id}, function(data) {
                console.log(data);
                $scope.checklists = data;
                $scope.checklist_title = '';
            });
        };

        $scope.saveChecklistTitle = function(checklist) {
            request.send('/TaskManager/saveChecklistTitle', {'checklist_id': checklist.id, 'checklist_title': checklist.title}, function(data) {

            });

            $scope.showChecklistTitle[checklist.id] = ! $scope.showChecklistTitle[checklist.id];
        };

        $scope.deleteChecklist = function(checklist) {
            var modalInstance = $uibModal.open({
                animation: true,
                size: 'sm',
                templateUrl: 'ConfirmWindow.html',
                controller: 'ModalConfirmWindowCtrl',
                resolve: {
                    items: function () {
                        return {
                            'deleted_item': 'checklist',
                            'checklist': checklist
                        };
                    }
                }
            });

            modalInstance.result.then(function(response) {
                $scope.getChecklists($scope.card);
            }, function () {

            });
        };

        /* END CHECKLISTS */

        ////////////////////////////////////

        /* CHECKBOXES */

        $scope.getCheckboxes = function(checklist) {
            request.send('/TaskManager/getCheckboxes', {'checklist_id': checklist.id}, function(data) {
                $scope.checkboxes[checklist.id] = data;
            });
        };

        $scope.selectCheckbox = function(checkbox) {
            $scope.editCheckbox = {};
            $scope.showCheckBox = {};
            $scope.temp_checkbox_deadline = {};
            $scope.checkbox_title[checkbox.id] = angular.copy(checkbox.title);
            $scope.editCheckbox[checkbox.id] = ! $scope.editCheckbox[checkbox.id];
            if (checkbox.deadline != '') {
                $scope.temp_checkbox_deadline[checkbox.id] = checkbox.deadline;
            }
        };

        $scope.saveCheckboxDescription = function(checkbox) {
            $scope.chekbox_users_ids = [];
            for (var k in checkbox.users)
            {
                $scope.chekbox_users_ids[k] = checkbox.users[k].users_id;
            }

            $scope.checkbox.title = $scope.checkbox_title[checkbox.id];
            $scope.checkbox.id = checkbox.id;
            $scope.checkbox.users = $scope.chekbox_users_ids;
            $scope.checkbox.deadline = $scope.temp_checkbox_deadline[checkbox.id];

            request.send('/TaskManager/saveCheckboxDescription', $scope.checkbox, function(data) {
                checkbox.deadline = data;
            });

            checkbox.title = $scope.checkbox_title[checkbox.id];
            $scope.editCheckbox[checkbox.id] = ! $scope.editCheckbox[checkbox.id];
        };

        $scope.resetCheckboxDescription = function(checkbox) {
            $scope.editCheckbox[checkbox.id] = ! $scope.editCheckbox[checkbox.id];
        };

        $scope.createNewCheckbox = function(checklist) {
            $scope.editCheckbox = {};
            $scope.checked_users = {};
            $scope.checked_ids = [];
            $scope.temp_checkbox_deadline = {};
            $scope.showCheckboxDeadline = false;
            $scope.showCheckBox = {};
            $scope.showCheckBox[checklist.id] = ! $scope.showCheckBox[checklist.id];
            $scope.card_users = angular.copy($scope.card.users);
            $scope.updateUserList();
        };

        $scope.addCheckbox = function(checklist) {
            $scope.checkbox.users = $scope.checked_ids;
            $scope.checkbox.deadline = $scope.temp_checkbox_deadline;
            $scope.checkbox.checklist_id = checklist.id;
            $scope.checkbox.checkbox_title = $scope.add_checkbox_title[checklist.id];
            $scope.temp_users = [];

            request.send('/TaskManager/addCheckbox', $scope.checkbox, function(data) {
                $scope.getCheckboxes(checklist);
            });

            $scope.showCheckBox[checklist.id] = ! $scope.showCheckBox[checklist.id];
            $scope.add_checkbox_title[checklist.id] = '';
            $scope.checked_ids = [];
        };

        $scope.deleteCheckbox = function(checkbox, checklist) {
            var modalInstance = $uibModal.open({
                animation: true,
                size: 'sm',
                templateUrl: 'ConfirmWindow.html',
                controller: 'ModalConfirmWindowCtrl',
                resolve: {
                    items: function () {
                        return {
                            'deleted_item': 'checkbox',
                            'task_id': checkbox
                        };
                    }
                }
            });

            modalInstance.result.then(function(response) {
                $scope.getCheckboxes(checklist);
            }, function () {

            });
        };

        $scope.uncheckedUsers = function(checkbox) {
            return function(value, index, array) {
                for (var k in checkbox.users) {
                    if (checkbox.users[k].users_id == value.users_id) {
                        return false;
                    }
                }

                return true;
            }
        };

        $scope.addCheckboxUser = function(checkbox, user_id) {
            for (var k in $scope.card.users)
            {
                if ($scope.card.users[k].users_id == user_id)
                {
                    checkbox.users.push($scope.card.users[k]);
                }
            }
        };

        $scope.addUserToList = function(user_id) {
            $scope.checked_ids.push(user_id);
            $scope.updateUserList();
        };

        $scope.removeUserFromCheckbox = function(checkbox, user_id) {
            var temp = [];
            for (var k in checkbox.users)
            {
                if (checkbox.users[k].users_id != user_id)
                {
                    temp.push(checkbox.users[k]);
                }
            }

            checkbox.users = temp;

            $scope.updateUserList();
        };

        $scope.removeUserFromList = function(user_id) {
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

            for (var k in $scope.card_users)
            {
                if ($scope.inArray($scope.checked_ids, $scope.card_users[k].users_id))
                {
                    $scope.checked_users.push($scope.card_users[k]);
                }
                else
                {
                    $scope.not_checked_users.push($scope.card_users[k]);
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

        $scope.addTempCheckboxDeadline = function(checkbox) {
            var date = $scope.checkbox_deadline.date;

            if (checkbox) {
                $scope.temp_checkbox_deadline[checkbox.id] = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate() + ' ' + $scope.checkbox_deadline.hour + ':' + $scope.checkbox_deadline.minute;
            }else {
                $scope.temp_checkbox_deadline = date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate() + ' ' + $scope.checkbox_deadline.hour + ':' + $scope.checkbox_deadline.minute;
            }

            $scope.showCheckboxDeadline = true;
        };

        $scope.removeTempCheckboxDeadline = function() {
            $scope.temp_checkbox_deadline = {};
        };

        $scope.changeCheckboxStatus = function(checkbox) {
            request.send('/TaskManager/changeCheckboxStatus', {'checkbox_id': checkbox.id, 'cards_id': $scope.card.cards_id}, function(data) {
                checkbox.status = data;
            });
        };

        /* END CHECKBOXES */

        ////////////////////////////////////

        /* COMMENTS */

        $scope.getComments = function() {
            request.send('/TaskManager/getComments', {'cards_id': $scope.card.cards_id}, function(data) {
                $scope.comments = data;
            });
        };

        $scope.saveComment = function() {
            request.send('/TaskManager/saveComment', {'text': $scope.comment_text, 'cards_id': $scope.card.cards_id}, function(data) {
                $scope.comments = data;
                $scope.comment_text = '';
            });
        };

        /* END COMMENTS */

        ////////////////////////////////////

        $scope.getTeamUsers = function() {
            request.send('/TaskManager/getTeamUsers', {'cards_id': $scope.card.cards_id}, function(data) {
                $scope.team_users = data;
                if($scope.team_users){
                    $scope.users_list = $scope.team_users[0].users_id.toString();
                }
            });
        };

        $scope.addUserToCard = function(user_id) {
            request.send('/TaskManager/addUserToCard', {'users_id': user_id, 'cards_id': $scope.card.cards_id}, function(data) {
                $scope.getTeamUsers();
                $scope.card.users = data;
            });
        };

        $scope.removeUserFromCard = function(user_id) {
            $scope.checkbox = {};

                for (var k in $scope.checkboxes) {
                    for (var l in $scope.checkboxes[k]) {
                        $scope.checkbox[k] = $scope.checkboxes[k][l].id;
                    }
                }

            /*request.send('/TaskManager/removeUserFromCard', {'users_id': user_id, 'cards_id': $scope.card.cards_id}, function(data) {
                $scope.getTeamUsers();
                $scope.card.users = data;
            });*/
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

        $scope.saveCardDeadline = function() {
            request.send('/TaskManager/saveCardDeadline', {'cards_id': $scope.card.cards_id, 'deadline': $scope.card_deadline}, function(data) {
                $scope.card.deadline = data;
            });
        };

        $scope.removeCardDeadline = function() {
            request.send('/TaskManager/removeCardDeadline', {'cards_id': $scope.card.cards_id}, function(data) {
                $scope.card.deadline = data;
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
            $scope.checkbox_deadline.hour = ((checkbox_deadline_time.getHours() < 10 ? '0' : '') + checkbox_deadline_time.getHours()).toString();
            $scope.checkbox_deadline.minute = ((checkbox_deadline_time.getMinutes() < 10 ? '0' : '') + checkbox_deadline_time.getMinutes()).toString();
            $scope.checkbox_deadline.date = ($scope.checkbox_deadline.date) ? (new Date($scope.checkbox_deadline.date)) : (new Date());

            var card_deadline_time = ($scope.card_deadline_time) ? (new Date($scope.card_deadline_time)) : (new Date());
            $scope.card_deadline.hour = ((card_deadline_time.getHours() < 10 ? '0' : '') + card_deadline_time.getHours()).toString();
            $scope.card_deadline.minute = ((card_deadline_time.getMinutes() < 10 ? '0' : '') + card_deadline_time.getMinutes()).toString();
            $scope.card_deadline.date = ($scope.card_deadline.date) ? (new Date($scope.card_deadline.date)) : (new Date());
        };

        $scope.setDate();

        $scope.range = function(n) {
            var list = [];
            for (var i = 0; i <= n; i++)
            {
                if (i < 10) {
                    var am = '0' + i;
                    list.push(am);
                }else {
                   list.push(i);
                }
            }
            return list;
        };
    };
})();

(function () {
    'use strict';

    angular.module('app').controller('ModalConfirmWindowCtrl', ['$rootScope', '$scope', '$uibModal', '$uibModalInstance', '$filter', 'request', 'validate', 'logger', 'langs', 'items', ModalConfirmWindowCtrl]);

    function ModalConfirmWindowCtrl($rootScope, $scope, $uibModal, $uibModalInstance, $filter, request, validate, logger, langs, items) {
        if (items.deleted_item == 'checkbox') {
            $scope.delete = function() {
                request.send('/TaskManager/deleteCheckbox', items.checkbox, function(data) {
                    $uibModalInstance.close();
                });
            };
        }

        if (items.deleted_item == 'task') {
            $scope.delete = function() {
                request.send('/TaskManager/deleteList', {'id': items.task.id}, function(data) {
                    $uibModalInstance.close();
                });
            };
        }

        if (items.deleted_item == 'desk') {
            $scope.delete = function() {
                request.send('/TaskManager/deleteDesk', {'desk_id': items.desk.id}, function(data) {
                    $uibModalInstance.close();
                });
            };
        }

        if (items.deleted_item == 'checklist') {
            $scope.delete = function() {
                request.send('/TaskManager/deleteChecklist', {'checklist_id': items.checklist.id}, function(data) {
                    $uibModalInstance.close();
                });
            };
        }

        if (items.deleted_item == 'card') {
            $scope.delete = function() {
                request.send('/TaskManager/deleteCard', {'cards_id': items.card.cards_id}, function(data) {
                    $uibModalInstance.close();
                });
            };
        }

        $scope.cancel = function() {
            $uibModalInstance.dismiss('cancel');
        };
    };
})();
