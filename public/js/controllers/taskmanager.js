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
        $scope.task = {};
        $scope.check_desc = 1;

        $scope.changeDesc = function(desc_id) {
            $scope.check_desc = desc_id;
        };

        $scope.getDescs = function() {
            //console.log(desc_id);
            request.send('/TaskManager/getDescs', {}, function(data) {

                //console.log(data);
                $scope.descs = data;

                for (var k in data)
                {
                    $scope.tasks = data[k].tasks;

                    for (var l in $scope.tasks)
                    {
                        $scope.all += $scope.tasks[l].cards.length;
                    }
                }
            });
        };

        $scope.saveDesc = function(desc_name) {
            console.log(desc_name);
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

        $scope.addTask = function(name_task_block) {
            request.send('/TaskManager/addTask', {'name_task_block':name_task_block, 'desc_id':$scope.check_desc}, function(data) {
                $scope.getDescs();
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
                $scope.getDescs();
            });
        };

        $scope.createCard = function(id) {
            $scope.card.task_id = id;
            request.send('/TaskManager/createCard', $scope.card, function(data) {
                $scope.getDescs();
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
                $scope.getDescs();
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


//modal
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
        $scope.showCheckBox = true;
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
        $scope.title = {};
        $scope.checkbox_title = {};
        $scope.deadline= {};
        $scope.temp_users = {};

        $scope.initCard = function() {
            $scope.getTeamUsers();
            $scope.getCard();
        };

        $scope.getCard = function() {
            request.send('/TaskManager/getCard', {'cards_id': $scope.card.cards_id}, function(data) {
                $scope.card = data;
                $scope.checklists = data.checklists;
                $scope.comments = data.comments;
                $scope.temp_description = $scope.card.description;
                $scope.users = data.users;
                $scope.deadline = data.this_data;
                $scope.time_h = data.time_h;
                $scope.time_m = data.time_m;
                $scope.hh = $scope.time_h[0].toString();
                $scope.mm = $scope.time_m[0].toString();

                //console.log(data);
            });

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
                $scope.getCard();
                $scope.getTeamUsers();
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

        $scope.saveComment = function() {
            request.send('/TaskManager/saveComment', {'text': $scope.comment_text, 'cards_id': $scope.card.cards_id}, function(data) {
                $scope.getCard();
            });
        };

        $scope.makeCheckboxDescriptionCopy = function(checkbox) {
            $scope.checkbox_title[checkbox.id] = angular.copy(checkbox.title);
            $scope.editChecklistItem[checkbox.id] = ! $scope.editChecklistItem[checkbox.id];
        };

        $scope.saveCheckboxDescription = function(checkbox) {
            request.send('/TaskManager/saveCheckboxDescription', {'title': $scope.checkbox_title[checkbox.id], 'checkbox_id': checkbox.id}, function(data) {
                $scope.getCard();
            });

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

        $scope.addCheckbox = function(checklist_id, checkbox_title) {
            $scope.checkbox.users = $scope.temp_users_id;
            $scope.checkbox.deadline = $scope.temp_deadline;
            $scope.checkbox.checklist_id = checklist_id;
            $scope.checkbox.checkbox_title = checkbox_title;

            $scope.temp_users = {};

            request.send('/TaskManager/addCheckbox', $scope.checkbox, function(data) {
                $scope.getCard();
            });
        };

        $scope.saveUserToCheckbox = function(user_id) {
            $scope.temp_users_id.push(user_id);

            for (var k in $scope.users) {

                if(user_id == $scope.users[k].users_id){
                    $scope.temp_users[k] = $scope.users[k];
                }
            };

            console.log($scope.temp_users);

        };


        $scope.deletePreviewUserCheckbox = function(user_id) {
            var temp = [];

            for (var k in $scope.temp_users) {

                //console.log(scope.temp_users[k].users_id);


                if(user_id == $scope.temp_users[k].users_id){

                }else {
                    temp.push($scope.temp_users[k]);
                }
            };
            $scope.temp_users = temp;


            console.log($scope.temp_users);
        };

        $scope.saveCheckboxDeadline = function(deadline,h,m) {
            request.send('/TaskManager/saveCheckboxDeadline', {'deadline': deadline, 'h': h, 'm': m}, function(data) {
                $scope.temp_deadline = data;
            });
        };

        $scope.clearCheckboxDeadline = function(deadline,h,m) {
            delete $scope.temp_deadline;
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

        $scope.changeDone = function() {
            request.send('/TaskManager/changeDone', {'cards_id': $scope.card.cards_id}, function(data) {
                $scope.getCard();
            });
        };

        $scope.saveChecklistTitle = function(checklist_id, value) {
            request.send('/TaskManager/saveChecklistTitle', {'checklist_id': checklist_id, 'value': value}, function(data) {
                $scope.getCard();
            });
        };
    };
})();