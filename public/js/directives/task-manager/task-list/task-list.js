(function () {
    'use strict';

    angular.module('app').directive('taskList', function () {
        return {
        	scope: {
        		tlId: '=',
        		tlTitle: '=',
        		tlCards: '='
        	},
            templateUrl: '/js/directives/task-manager/task-list/task-list.html',
            controller: ['$scope', 'request', '$uibModal', function TaskListController($scope, request, $uibModal) {
            	$scope.task = {};
            	$scope.taskListTitle = {};
            	$scope.showAddNewCard = {};
            	$scope.list = {};

            	$scope.editTaskListTitle = function(id, title) {
            		$scope.showAddNewCard = {};
            		$scope.taskListTitle = {};
            		$scope.task.title = title;
            		$scope.taskListTitle[id] = ! $scope.taskListTitle[id];
		        };

		        $scope.saveTaskListTitle = function(id, title) {
		            request.send('/TaskManager/saveTaskTitle', {'task_id': id, 'task_title': title});
		            $scope.tlTitle = title;
		            $scope.taskListTitle[id] = ! $scope.taskListTitle[id];
		        };

		        $scope.getListTeamUsers = function() {
		            request.send('/TaskManager/getListTeamUsers', {'list_id': $scope.tlId}, function(data) {
		                $scope.users = data.users;
		                $scope.team_users = data.users_not_checked;
		                $scope.users_list = $scope.team_users[0].users_id.toString();
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

		        $scope.deleteList = function(id) {
		            var modalInstance = $uibModal.open({
		                animation: true,
		                size: 'sm',
		                templateUrl: 'ConfirmWindow.html',
		                controller: 'ModalConfirmWindowCtrl',
		                resolve: {
		                    items: function () {
		                        return {
		                            'deleted_item': 'task',
		                            'task_id': id
		                        };
		                    }
		                }
		            });

		            modalInstance.result.then(function(response) {
		                $scope.getDeskLists($scope.desk);
		            }, function () {

		            });
		        };

		        $scope.addNewCard = function(id) {
		            $scope.showAddNewCard = {};
		            $scope.taskListTitle = {};
		            $scope.showAddNewCard[id] = ! $scope.showAddNewCard[id];
		        };

		        $scope.createCard = function(task_id, card_name) {
		            request.send('/TaskManager/createCard', {'card_name': card_name, 'task_id': task_id}, function(data) {
		                $scope.tlCards = data;
		            });

		            $scope.card_name = '';
		            $scope.showAddNewCard[task_id] = ! $scope.showAddNewCard[task_id];
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
		                //$scope.getDeskLists($scope.desk);
		                $scope.tlCards = response;
		            }, function () {

		            });
		        };
            }]
        };
    });
})();