(function () {
    'use strict';

    angular.module('app').controller('TeamsCtrl', ['$rootScope', '$scope', '$uibModal', '$filter', 'request', 'langs', 'plugins', TeamsCtrl]);

    function TeamsCtrl($rootScope, $scope, $uibModal, $filter, request, langs, plugins) {
    	$scope.list = [];
    	$scope.listFiltered = [];
		$scope.pagesList = [];
    	$scope.numPerPage = 20;
		$scope.currentPage = 1;

    	$scope.get = function() {
			request.send('/teams/get', {}, function(data) {
				if (data)
				{
					$scope.print(data);
				}
			}, 'GET');
		};

        $scope.remove = function(teams_id) {
            if (confirm(langs.get('Do you really want to remove this team?')))
            {
                request.send('/teams/remove', {'teams_id': teams_id}, function(data) {
                    if (data)
                    {
                        $scope.print(data);
                    }
                });
            }
        };

        $scope.leave = function(teams_id) {
            if (confirm(langs.get('Do you really want to leave this team?')))
            {
                request.send('/teams/leave', {'teams_id': teams_id}, function(data) {
                    if (data)
                    {
                        $scope.print(data);
                    }
                });
            }
        };

        $scope.decline = function(teams_id) {
            if (confirm(langs.get('Do you really want to decline invitation?')))
            {
                request.send('/teams/decline', {'teams_id': teams_id}, function(data) {
                    if (data)
                    {
                        $scope.print(data);
                    }
                });
            }
        };

        $scope.approve = function(teams_id) {
            request.send('/teams/approve', {'teams_id': teams_id}, function(data) {
                if (data)
                {
                    $scope.print(data);
                }
            });
        };

		$scope.print = function(data) {
			$scope.list = data;
			$scope.listFiltered = $scope.list;
			$scope.changePage($scope.currentPage);
		};

		$scope.create = function(teams_id, view) {
            teams_id = teams_id || false;
			view = view || false;

			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: 'TeamsCreate.html',
				controller: 'ModalTeamsCreateCtrl',
				resolve: {
					items: function () {
				  		return {'team': $scope.by_id(teams_id), 'view': view};
					}
				}
		    });

		    modalInstance.result.then(function(response) {
				$scope.print(response);
		    }, function () {

		    });
		};

        $scope.plugins = function(teams_id) {
            teams_id = teams_id || false;

            var modalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'TeamsPlugins.html',
                controller: 'ModalTeamsPluginsCtrl',
                resolve: {
                    items: function () {
                        return {'team': $scope.by_id(teams_id)};
                    }
                }
            });

            modalInstance.result.then(function(response) {
                $scope.print(response);
            }, function () {

            });
        };

		$scope.by_id = function(teams_id) {
			for (var k in $scope.list)
			{
				if ($scope.list[k].teams_id == teams_id)
				{
					return $scope.list[k];
				}
			}

			return {};
		};

		$scope.changePage = function(page) {
            var end, start;
            start = (page - 1) * $scope.numPerPage;
            end = start + $scope.numPerPage;
            return $scope.pagesList = $scope.listFiltered.slice(start, end);
        };

        $scope.order = function(rowName) {
            if ($scope.row === rowName)
            {
                return;
            }
            $scope.row = rowName;
            $scope.listFiltered = $filter('orderBy')($scope.list, rowName);

            $scope.changePage(1);
            return $scope.currentPage = 1;
        };

        $scope.switchTeam = function() {
            request.send('/users/getTeams', {}, function(data) {
                if (data)
                {
                    var modalInstance = $uibModal.open({
                        animation: true,
                        templateUrl: 'SwitchTeam.html',
                        controller: 'ModalSwitchTeamCtrl',
                        resolve: {
                            items: function () {
                                return data;
                            }
                        }
                    });
                }
            });
        };
    };
})();

;

(function () {
    'use strict';

    angular.module('app').controller('ModalTeamsCreateCtrl', ['$rootScope', '$scope', '$uibModalInstance', 'request', 'validate', 'logger', 'langs', 'items', ModalTeamsCreateCtrl]);

    function ModalTeamsCreateCtrl($rootScope, $scope, $uibModalInstance, request, validate, logger, langs, items) {
        $scope.team = angular.copy(items.team);
    	$scope.view = items.view;
        $rootScope.request_sent = false;
        $rootScope.user.pivot = {'teams_leader': 1,
                                 'teams_invite': 1,
                                 'teams_approved': 1};
    	$scope.members = $scope.team.users || [$rootScope.user];

    	$scope.addMember = function() {
    		if ($scope.email)
    		{
    			var exist = false;
    			for (var k in $scope.members)
    			{
    				if ($scope.members[k].users_email.toLowerCase() == $scope.email.toLowerCase())
    				{
    					exist = true;
    				}
    			}

    			if ( ! exist)
    			{
    				request.send('/users/check', {'email': $scope.email}, $scope.printMember);
    			}
    			else
    			{
    				logger.logWarning('You already invite this user');
    			}
    		}
    		else
    		{
    			logger.logError('Enter user\'s email to invite him to the team');
    		}
    	};

    	$scope.printMember = function(data) {
    		if (data)
    		{
    			$scope.members.push(data);
     			$scope.email = '';
    		}
    	};

    	$scope.getMember = function(users_id) {
    		for (var k in $scope.members)
    		{
    			if ($scope.members[k].users_id == users_id)
    			{
    				return $scope.members[k];
    			}
    		}

    		return false;
    	};

    	$scope.removeMember = function(users_id) {
    		if (confirm(langs.get('Do you really want to remove this user from the current team?')))
    		{
	    		var member = $scope.getMember(users_id);
	    		if (member)
	    		{
	    			member.removed = true;
	    		}
    		}
    	};

    	$scope.save = function() {
	    	var error = 1;
			error *= validate.check($scope.form.teams_name, 'Name');
			if (error)
			{
                $rootScope.request_sent = true;
                delete $scope.team.pivot;
                delete $scope.team.users;
                delete $scope.team.plugins;
				request.send('/teams/save', {'team': $scope.team, 'members': $scope.members}, function(data) {
					if (data)
					{
						$uibModalInstance.close(data);
					}
                    else
                    {
                        $rootScope.request_sent = false;
                    }
				});
			}
		};

		$scope.cancel = function() {
			$uibModalInstance.dismiss('cancel');
		};
    };
})();

;

(function () {
    'use strict';

    angular.module('app').controller('ModalTeamsPluginsCtrl', ['$rootScope', '$scope', '$uibModalInstance', 'plugins', 'items', ModalTeamsPluginsCtrl]);

    function ModalTeamsPluginsCtrl($rootScope, $scope, $uibModalInstance, plugins, items) {
        $scope.team = angular.copy(items.team);
        $scope.plugins_list = {};
        $scope.plugins = [];
        plugins.list().then(function(data) {
            $scope.plugins = data;
            $scope.setChecked();
        });

        $scope.isChecked = function(plugins_id) {
            for (var k in $scope.team.plugins)
            {
                if (plugins_id == $scope.team.plugins[k].plugins_id)
                {
                    return 1;
                }
            }
            return 0;
        };

        $scope.setChecked = function() {
            for (var k in $scope.plugins)
            {
                $scope.plugins_list[$scope.plugins[k].plugins_id] = $scope.isChecked($scope.plugins[k].plugins_id);
            }
        };

        $scope.setPlugin = function(plugins_id) {
            plugins.save($scope.team.teams_id, plugins_id, $scope.plugins_list[plugins_id]);
        };

        $scope.cancel = function() {
            $uibModalInstance.dismiss('cancel');
        };
    };
})();

;

(function () {
    'use strict';

    angular.module('app').controller('ModalSwitchTeamCtrl', ['$rootScope', '$scope', '$uibModalInstance', '$window', 'request', 'validate', 'logger', 'langs', 'items', ModalSwitchTeamCtrl]);

    function ModalSwitchTeamCtrl($rootScope, $scope, $uibModalInstance, $window, request, validate, logger, langs, items) {
        $scope.teams = items;
        $scope.current_team = '0';

        $scope.save = function () {
            $scope.teams.current_team = $scope.current_team;
            request.send('/users/saveTeam', {'current_team' : $scope.teams.current_team}, function(data) {
                $uibModalInstance.close();
                $window.location.reload();
            });
        };

        $scope.cancel = function() {
            $uibModalInstance.dismiss('cancel');
        };
    };
})();

;