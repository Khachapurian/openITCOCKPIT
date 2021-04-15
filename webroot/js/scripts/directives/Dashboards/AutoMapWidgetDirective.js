angular.module('openITCOCKPIT').directive('automapWidget', function($http, $interval){
    return {
        restrict: 'E',
        templateUrl: '/automaps/automapWidget.html',
        scope: {
            'widget': '='
        },

        controller: function($scope){
            $scope.init = true;
            $scope.automap = {
                automap_id: null,
            };

            $scope.load = function(){
                $http.get("/automaps/automapWidget.json", {
                    params: {
                        'angular': true,
                        'widgetId': $scope.widget.id
                    }
                }).then(function(result){
                    $scope.automap.automap_id = result.data.config.automap_id;
                    $scope.automap.useScroll = result.data.config.useScroll;
                    $scope.automap.scroll_interval = result.data.config.scroll_interval;
                    //Do not trigger watch on page load
                    setTimeout(function(){
                        $scope.init = false;
                    }, 250);
                });
            };

            $scope.loadAutoMaps = function(searchString){
                $http.get("/automaps/loadAutomapsByString.json", {
                    params: {
                        'angular': true,
                        'filter[Automap.name]': searchString,
                        'selected[]': $scope.automap.automap_id
                    }
                }).then(function(result){
                    $scope.automaps = result.data.automaps;
                });
            };

            $scope.showConfig = function(){
                $scope.$broadcast('FLIP_EVENT_OUT');
                $scope.loadAutoMaps('');
            };

            $scope.hideConfig = function(){
                $scope.$broadcast('FLIP_EVENT_IN');
            };

            $scope.saveAutomap = function(){
                $http.post("/automaps/automapWidget.json?angular=true",
                    {
                        Widget: {
                            id: $scope.widget.id
                        },
                        automap_id: $scope.automap.automap_id,
                        scroll_interval: $scope.scroll_interval,
                        useScroll: $scope.useScroll
                    }
                ).then(function(result){
                    //Update status
                    $scope.hideConfig();
                });
            };

            $scope.loadTimezone = function(){
                $http.get("/angular/user_timezone.json", {
                    params: {
                        'angular': true
                    }
                }).then(function(result){
                    $scope.timezone = result.data.timezone;
                });
            };

            $scope.load();
            $scope.loadTimezone();
        },

        link: function($scope, element, attr){

        }
    }
});
