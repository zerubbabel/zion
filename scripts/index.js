
angular.module('indexApp', ['ngRoute'])
  .config(function($routeProvider) {

    $routeProvider.when('/page1', {
      templateUrl: 'views/page1.html',
      //controller: 'pagr1Ctrl'
    })
    .when('/page2', {
      templateUrl: 'views/page2.html',
      resolve: {
        auth: ['$q', '$location', 
        function($q, $location) {
          
          $.post('ajax/auth.php', function(data) {
            var result=data;
             if (result&&result.status){
              alert(result);
            }else{
              //$location.path('/');
              //$location.replace();  
              return $q.reject();
            }
          });
        }]
      }
    });
    $routeProvider.otherwise({
      redirectTo: '/'
    });
  });
