(function () {
    'use strict';

    angular.module('app').controller('CustomersCtrl', ['$rootScope', '$scope', '$uibModal', '$filter', '$location', '$timeout', '$window', 'request', 'validate', 'logger', 'langs', 'plugins', 'Page', CustomersCtrl]);

    function CustomersCtrl($rootScope, $scope, $uibModal, $filter, $location, $timeout, $window, request, validate, logger, langs, plugins, Page) {
        $scope.currentTeam = {};
        $scope.list = [];
        $scope.listFiltered = [];
        $scope.pagesList = [];
        $scope.numPerPage = 20;
        $scope.currentPage = 1;
        $scope.customers = {};
        $scope.customers.customer_type = '0';

        $scope.not_checked_users = [];
        $scope.checked_users = [];
        $scope.checked_ids = [];

        $scope.customer_id = $location.path().split('/')[3];

        $scope.initAdd = function() {
            request.send('/customers/get', {'customer_id': ($scope.customer_id || 0)}, function(data) {
                if ($scope.customer_id)
                {
                    $scope.customers = data;
                    $scope.checked_ids = $scope.customers.users_ids;
                    $scope.updateUserList();

                    $scope.customers.customer_type = $scope.customers.customer_type.toString();
                    $scope.old = angular.copy($scope.customers);
                }
            });

            $scope.getTeamUsers();
            $scope.getComment();

            window.onbeforeunload = function (e) {
               return "Are you sure you want to navigate away from this page";
            };
        };

        $scope.initList = function() {
            request.send('/customers/getList', {}, function(data) {
                $scope.print(data);
            });
        };

        $scope.print = function(data) {
            $scope.list = data;
            $scope.listFiltered = $scope.list;
            $scope.order('-created_at');
        };

        $scope.order = function(rowName) {
            $scope.row = rowName;
            $scope.listFiltered = $filter('orderBy')($scope.list, rowName);

            $scope.changePage(1);
            return $scope.currentPage = 1;
        };

        $scope.changePage = function(page) {
            var end, start;
            start = (page - 1) * $scope.numPerPage;
            end = start + $scope.numPerPage;
            //return $scope.pagesList = $scope.listFiltered.slice(start, end);
            return $scope.pagesList = $scope.listFiltered;
        };

		$scope.save = function() {
	    	var error = 1;
			error *= validate.check($scope.form.company_name, 'Nazwa firmy');
			if (error)
			{
                if ( ! $scope.customer_id)
                {
                    if ($scope.duplicate)
                    {
                        $scope.customers.allow_duplicate = 1;
                    }
                    $scope.customers.users_ids = $scope.checked_ids;
                    request.send('/customers/save', $scope.customers, function(data) {
                        if (data)
                        {
                            $scope.duplicate_customers = data;

                            if (data.duplicate)
                            {
                                $scope.duplicate = true;

                                /*$scope.$on('$locationChangeStart', function( event ) {
                                    var answer = confirm("Are you sure you want to leave this page?")
                                    if (!answer) {
                                        event.preventDefault();
                                    }
                                });*/
                            }
                            else
                            {
                                $timeout(function() {
                                    $window.location.href = "/customers/add/" + data;
                                }, 1000);
                            }

                        }
                    });
                }
                else
                {
                    $scope.customers.users_ids = $scope.checked_ids;
                    request.send('/customers/save', $scope.customers, function(data) {
                        if (data)
                        {
                            $scope.edit_general = false;
                            $scope.edit_address = false;
                            $scope.edit_rest = false;
                            $scope.reloadData();
                        }
                    });
                }
			}
		};

        $scope.remove = function(customer_id) {
            var modalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'CustomersDelete.html',
                controller: 'ModalCustomersDeleteCtrl',
                resolve: {
                    items: function () {
                        return {
                            'customer_id': customer_id
                        };
                    }
                }
            });

            modalInstance.result.then(function(response) {
                $timeout(function() {
                    $window.location.href = "/customers/list/";
                }, 1000);
            }, function () {

            });
        };

        $scope.reloadData = function() {
            $scope.initAdd();
        };

        $scope.addComment = function() {
            request.send('/customers/addComment', {
                'customer_id' : $scope.customer_id,
                'comment_text' : $scope.customers.comments
            }, function(data) {
                $scope.getComment();
                $scope.customers.comments = '';
            });
        };

        $scope.getComment = function() {
            request.send('/customers/getComment', {'customer_id' : $scope.customer_id}, function(data) {
                $scope.comments = data;
            });
        };

        $scope.editCustomers = function(block) {
            if (block == 'general')
            {
                $scope.edit_general = true;
            }

            if (block == 'address')
            {
                $scope.edit_address = true;
            }

            if (block == 'rest')
            {
                $scope.edit_rest = true;
            }

            $scope.old_customers = angular.copy($scope.customers);
        };

        $scope.cancelEdit = function(block) {
            if (block == 'general')
            {
                $scope.edit_general = false;

            }

            if (block == 'address')
            {
                $scope.edit_address = false;
            }

            if (block == 'rest')
            {
                $scope.edit_rest = false;
            }

            $scope.customers = angular.copy($scope.old_customers);
            delete $scope.old_customers;
        };

        $scope.getTeamUsers = function() {
            request.send('/users/getTeamUsers', {}, function(data) {
                $scope.original_users = data;
                $scope.users = [];

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

        /* Setting page titles */
        if ($scope.customer_id)
        {
            Page.setTitle('Kontrahent');
            Page.setIcon('fa fa-user');
        }

        if ($location.path() == '/customers/add/')
        {
            Page.setTitle('Utwórz Kontrahenta');
            Page.setIcon('fa fa-user-plus');
        }

        if ($location.path() == '/customers/list/')
        {
            Page.setTitle('Lista Kontrahentów');
            Page.setIcon('fa fa-list');
        }
    };
})();

(function () {
    'use strict';

    angular.module('app').controller('ModalCustomersDeleteCtrl', ['$rootScope', '$scope', '$uibModalInstance', '$filter', 'request', 'validate', 'logger', 'langs', 'items', ModalCustomersDeleteCtrl]);

    function ModalCustomersDeleteCtrl($rootScope, $scope, $uibModalInstance, $filter, request, validate, logger, langs, items) {
        $scope.customer_id = items.customer_id;

        $scope.delete = function(customer_id) {
            request.send('/customers/delete', {'customer_id': $scope.customer_id}, function(data) {
                $uibModalInstance.close();
            });
        };

        $scope.cancel = function() {
            $uibModalInstance.dismiss('cancel');
        };
    };
})();

;