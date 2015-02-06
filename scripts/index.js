
angular.module('indexApp', ['ngRoute'])
  .config(function($routeProvider) {

    $routeProvider.when('/', {
      templateUrl: 'views/page1.html',
      //controller: 'pagr1Ctrl'
    })
    .when('/page2', {
      templateUrl: 'views/page2.html'
    });
    $routeProvider.otherwise({
      redirectTo: '/'
    });
  });
