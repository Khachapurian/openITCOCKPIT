angular.module('openITCOCKPIT')
    .controller('HostsAddwizardController', function($scope, $http){
        $scope.post = {
            Container: {
                Container: [],
                container_id: 0
            },
            Host: {
                name: '',
                address: '',
                satellite_id: 0,
                container_id: 0,
                own_contacts: 0,
                own_contactgroups: 0,
                own_customvariables: 0,
                description: '',
                host_url: '',
                hosttemplate_id: 0,
                Contact: [],
                Contactgroup: [],
                Hostgroup: [],
                Parenthost: [],
                notify_period_id: 0,
                check_period_id: 0,
                command_id: 0,
                host_type: 1,
                uuid: ''
            },
        };

        $scope.selectedContainer = 0;
        $scope.selectedHosttemplate = 0;
        $scope.hostname = 0;
        $scope.hostaddress = 0;
        $scope.init = true;
        $scope.discovered = false;

        $scope.load = function(){
            $http.get("/hosts/loadContainers.json", {
                params: {
                    'angular': true
                }
            }).then(function(result){
                $scope.containers = result.data.containers;
                $scope.init = false;
            });
        };

        $scope.containerSelected = function(){
            var contianerID = $scope.post.Container.container_id;
            $scope.selectedContainer = contianerID;
            $scope.post.Host.container_id = contianerID;
        };

        $scope.hosttemplateSelected = function(){
            $scope.selectedHosttemplate = $scope.post.Host.hosttemplate_id;
        };


        $scope.loadData = function(){
            if($scope.init){
                return;
            }
            $http.get("/hosts/loadElementsByContainerId/" + $scope.selectedContainer + ".json", {
                params: {
                    'angular': true
                    //'containerId': $scope.selectedContainer,
                    //'filter[Hosttemplate.name]': searchString,
                    //'selected[]': $scope.post.Hostgroup.Hosttemplate
                }
            }).then(function(result){
                $scope.hosttemplates = result.data.hosttemplates;
                $scope.contacts = result.data.contacts;
                $scope.contactgroups = result.data.contactgroups;
            });
        };

        $scope.loadHosttemplateData = function(){
            if($scope.init){
                return;
            }
            $http.get("/hosts/loadHosttemplateData/" + $scope.selectedHosttemplate + ".json", {
                params: {
                    'angular': true
                    //'containerId': $scope.selectedContainer,
                    //'filter[Hosttemplate.name]': searchString,
                    //'selected[]': $scope.post.Hostgroup.Hosttemplate
                }
            }).then(function(result){
                $scope.post.Host.description = result.data.hosttemplate.Hosttemplate.description;
                $scope.post.Host.host_type = result.data.hosttemplate.Hosttemplate.host_type;
                $scope.post.Host.command_id = result.data.hosttemplate.Hosttemplate.command_id;
                $scope.post.Host.Contact = result.data.hosttemplate.ContactIds;
                $scope.post.Contact = result.data.hosttemplate.ContactIds;
                $scope.post.Contact = result.data.hosttemplate.ContactIds;
                $scope.post.Contactgroup = result.data.hosttemplate.ContactgroupIds;
                $scope.post.Host.Contactgroup = result.data.hosttemplate.ContactgroupIds;
                $scope.post.Host.Hostgroup = result.data.hosttemplate.HostgroupIds;
                $scope.post.Host.check_period_id = result.data.hosttemplate.Hosttemplate.check_period_id;
                $scope.post.Host.notify_period_id = result.data.hosttemplate.Hosttemplate.notify_period_id;
            });
        };

        $scope.getHostname = function(){
            //gethostnamebyaddr
            console.log($scope.address);
            if(!$scope.address || $scope.discovered){
                return;
            }
            $http.get('/hosts/gethostnamebyaddr/' + $scope.address + '.json', {
                params: {
                    'angular': true
                }
            }).then(function(result){

                console.log(result.data);
                $scope.post.Host.name = result.data.fqdn;
                $scope.discovered = true;
            });
        };

        $scope.getHostip = function(){
            //gethostipbyname
            console.log($scope.hostname);
            if(!$scope.hostname || $scope.discovered){
                return;
            }
            $http.get('/hosts/gethostipbyname/' + $scope.hostname + '.json', {
                params: {
                    'angular': true
                }
            }).then(function(result){
                console.log(result.data);
                $scope.post.Host.address = result.data.hostaddress;
                $scope.discovered = true;
            });
        };


        $scope.submit = function(){
            console.log($scope.post);
            //debugger;

            $http.post("/hosts/addwizard.json?angular=true",
                $scope.post
            ).then(function(result){
                console.log('Data saved successfully');
                console.log(result);
                window.location.href = '/hosts/addwizardoptional/';
            }, function errorCallback(result){
                console.info('save failed');
                //console.log(result);
               // debugger;
                /*if(result.data.hasOwnProperty('error')){
                    $scope.errors = result.data.error;
                }*/
            });

        };


        $scope.$watch('selectedContainer', function(){
            if($scope.init){
                return;
            }
            //$scope.post.Host.container_id = $scope.post.Container.container_id;
                $scope.loadData('');
        }, true);

        $scope.$watch('selectedHosttemplate', function(){
            $scope.loadHosttemplateData();
        }, true);

        $scope.$watch('post.Host.name', function(){
            console.log($scope.post.Host.name);
            $scope.hostname = $scope.post.Host.name;
            $scope.getHostip();
            $scope.discovered = false;

        }, true);

        $scope.$watch('post.Host.address', function(){
            console.log($scope.post.Host.address);
            $scope.address = $scope.post.Host.address;
            $scope.getHostname();
            $scope.discovered = false;

        }, true);

        $scope.load();

    });