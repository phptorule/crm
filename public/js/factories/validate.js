(function () {
    'use strict';

    angular.module('app').factory('validate', ['logger', validate])
	
	function validate(logger) {		
		return {
			check: function(field, name, object_field) {
				object_field = object_field || false;
				if (object_field && typeof(field.$viewValue) == 'object')
				{
					if (field.$viewValue[object_field] == '0')
					{
						logger.logError(':name is required', {'name': name});
						return false;
					}
				}

				
				if (field.$valid )
				{
					return true;
				}
				else
				{
					if ( field.$viewValue == '' || field.$viewValue == undefined )
					{
						logger.logError(':name is required', {'name': name});
					}
					else
					{
						logger.logError(':name is incorrect', {'name': name});
					}
					return false;
				}
			}
		};
	}
})();

;