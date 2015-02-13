function auth($q, $location) {
    var result;
    $.ajax({
        url: "access_auth.php",
        async:false,
        data:{'location':$location.path()},
        success: function(data){
        result= jQuery.parseJSON(data);
        }
    });
    if (result&&result.status){
        }
    else{
        $location.path('/');
        $location.replace();  
        return $q.reject();
    }
}

var indexApp=angular.module('indexApp', ['ngRoute'])
  .config(function($routeProvider) {

    $routeProvider.when('/page1', {
      templateUrl: 'views/page1.html',
      //controller: 'pagr1Ctrl'
    })
    .when('/page2', {
      templateUrl: 'views/page2.html',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/sale/sale_order', {
      templateUrl: 'views/sale/sale_order.html',
      resolve: {
        async: ['$q', '$location', auth]
      }
    });

    $routeProvider.otherwise({
      redirectTo: '/'
    });
  });
