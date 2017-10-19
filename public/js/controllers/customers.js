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

        var customer_id = $location.path().split('/')[3];
        $scope.customer_id = customer_id;

        $scope.get = function() {
            if ($scope.team)
            {
                if (customer_id)
                {
                    request.send('/customers/get', {'teams_id' : $scope.team.teams_id, 'customer_id' : customer_id}, function(data) {
                        $scope.customers = data[0];
                        $scope.customers.customer_type = $scope.customers.customer_type.toString();
                        $scope.old = angular.copy($scope.customers);
                    });

                    $scope.getComment();
                }
                else
                {
                    request.send('/customers/get', {'teams_id' : $scope.team.teams_id}, function(data) {
                        $scope.print(data);
                    });
                }
            }
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
                $scope.customers.teams_id = $scope.team.teams_id;

                if ( ! customer_id)
                {
                    request.send('/customers/save', $scope.customers, function(data) {
                        if (data)
                        {
                            $timeout(function() {
                                $window.location.href = "/customers/add/" + data;
                            }, 2000);
                        }
                    });
                }
                else
                {
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
                $scope.reloadData();
            }, function () {

            });
        };

        $scope.reloadData = function() {
            $scope.get();
        };

        $scope.addComment = function() {
            request.send('/customers/addComment', {
                'teams_id' : $scope.team.teams_id,
                'customer_id' : customer_id,
                'comment_text' : $scope.customers.comments
            }, function(data) {
                $scope.getComment();
                $scope.customers.comments = '';
            });
        };

        $scope.getComment = function() {
            request.send('/customers/getComment', {'teams_id' : $scope.team.teams_id, 'customer_id' : customer_id}, function(data) {
                $scope.comments = data;
            });
        };

        $scope.editCustomers = function(block) {
            if (block = 'general')
            {
                $scope.edit_general = true;
            }

            if (block = 'address')
            {
                $scope.edit_address = true;
            }

            if (block = 'rest')
            {
                $scope.edit_rest = true;
            }

            $scope.old_customers = angular.copy($scope.customers);
        };

        $scope.cancelEdit = function(block) {
            if (block = 'general')
            {
                $scope.edit_general = false;

            }

            if (block = 'address')
            {
                $scope.edit_address = false;
            }

            if (block = 'rest')
            {
                $scope.edit_rest = false;
            }

            $scope.customers = angular.copy($scope.old_customers);
            delete $scope.old_customers;
        };

        /* Setting page titles */
        if (customer_id)
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
            request.send('/customers/delete', {'customer_id': customer_id, 'teams_id' : $scope.team.teams_id}, function(data) {
                $uibModalInstance.close();
            });
        };

        $scope.cancel = function() {
            $uibModalInstance.dismiss('cancel');
        };
    };
})();

;