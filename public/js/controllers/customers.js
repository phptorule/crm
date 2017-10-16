(function () {
    'use strict';

    angular.module('app').controller('CustomersCtrl', ['$rootScope', '$scope', '$uibModal', '$filter', '$location', 'request', 'validate', 'logger', 'langs', 'plugins', CustomersCtrl]);

    function CustomersCtrl($rootScope, $scope, $uibModal, $filter, $location, request, validate, logger, langs, plugins) {
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

    	$scope.init = function() {
            $scope.get();
		};

        $scope.get = function() {
            if ($scope.team)
            {
                if (customer_id)
                {
                    request.send('/customers/get', {'teams_id' : $scope.team.teams_id, 'customer_id' : customer_id}, function(data) {
                        $scope.customers = data[0];
                    });
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
				request.send('/customers/save', $scope.customers, function(data) {});
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