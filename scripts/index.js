var select_obj={};
$(document).ready(function(){
  setTitle();
})
function setTitle(){
  if (select_obj['title']){
    $('#title').text(select_obj['title']);
  }
}
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
        select_obj['title']=result.page_name;
        }
    else{      
        select_obj['title']='';  
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
    .when('/views/sale/sale_out', {
      templateUrl: 'views/sale/sale_out.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/sale/sale_out_list', {
      templateUrl: 'views/sale/sale_out_list.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/sale/sale_order_maintain', {
      templateUrl: 'views/sale/sale_order_maintain.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/sale/new_sale_order', {
      templateUrl: 'views/sale/new_sale_order.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/work/work_draw', {
      templateUrl: 'views/work/work_draw.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/work/work_draw_list', {
      templateUrl: 'views/work/work_draw_list.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/outsource/new_os_order', {
      templateUrl: 'views/outsource/new_os_order.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/setting/new_password', {
      templateUrl: 'views/setting/new_password.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/stock/stocks', {
      templateUrl: 'views/stock/stocks.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/purchase/new_purchase_order', {
      templateUrl: 'views/purchase/new_purchase_order.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/setting/privilege', {
      templateUrl: 'views/setting/privilege.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/setting/products_manage', {
      templateUrl: 'views/setting/products_manage.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/setting/products_list', {
      templateUrl: 'views/setting/products_list.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    });
    $routeProvider.otherwise({      
      redirectTo: '/'
    });
  });
