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

    $routeProvider
    .when('/views/sale/sale_order', {
      templateUrl: 'views/sale/sale_order.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/sale/new_sale_order', {
      templateUrl: 'views/sale/new_sale_order.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    });
    $routeProvider.otherwise({
      redirectTo: '/'
    });
  });
