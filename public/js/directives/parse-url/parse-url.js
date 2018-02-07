(function () {
    'use strict';

    angular.module('app').directive('parseUrl', function () {
        
        var urlPattern = /(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/gi;
        return {
            restrict: 'A',
            require: 'ngModel',
            replace: true,
            scope: {
                props: '=parseUrl',
                ngModel: '=ngModel'
            },
            link: function compile(scope, element, attrs, controller) {
                scope.$watch('ngModel', function (value) {
                    
                    var html = value.toString().replace(urlPattern, '<a target="' + scope.props.target + '" href="$&" class="comment_link">link zewnętrzny</a>');
                    element.html(html);
                });
            }
        };
    });
})();