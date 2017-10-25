(function () {
    'use strict';

    angular.module('app').controller('FinancesCtrl', ['$rootScope', '$scope', '$uibModal', '$filter', '$location', 'request', 'langs', 'Page', FinancesCtrl]);

    function FinancesCtrl($rootScope, $scope, $uibModal, $filter, $location, request, langs, Page) {
    	$scope.selectCustomer = function() {
            var modalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'SelectCustomer.html',
                controller: 'ModalSelectCustomerCtrl',
                resolve: {
                    items: function () {
                        return true;
                    }
                }
            });

            modalInstance.result.then(function(response) {
            }, function () {

            });
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
            });
        };

	    /* Setting page titles */
	    if ($scope.customer_id)
	    {
	        Page.setTitle('Kontrahent');
	        Page.setIcon('fa fa-user');
	    }

	    if ($location.path() == '/finances/add/')
	    {
	        Page.setTitle('Wystaw fakturę');
	        Page.setIcon('fa fa-plus');
	    }
	};
})();

(function () {
    'use strict';

    angular.module('app').controller('ModalSelectCustomerCtrl', ['$rootScope', '$scope', '$uibModalInstance', '$filter', 'request', 'validate', 'logger', 'langs', 'items', ModalSelectCustomerCtrl]);

    function ModalSelectCustomerCtrl($rootScope, $scope, $uibModalInstance, $filter, request, validate, logger, langs, items) {
    	$scope.list = [];
        $scope.listFiltered = [];
        $scope.pagesList = [];
        $scope.numPerPage = 5;
        $scope.currentPage = 1;

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
            return $scope.pagesList = $scope.listFiltered.slice(start, end);
            //return $scope.pagesList = $scope.listFiltered;
        };
    };
})();

;