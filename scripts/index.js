var select_obj={};
var jqgrid_row_num=10;
var jqgrid_height=350;
/*
var jgGrid_setting={
    datatype: "json",
    height: 350,
    viewrecords : true,
    rowNum:20,
    //rowList:[10,20,30],
    viewrecords:true,
    sortorder:'asc', 
    autowidth: true,
};*/

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
        //$location.path('/');
        $location.path('/views/error');
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
    .when('/views/sale/sale_order_manage', {
      templateUrl: 'views/sale/sale_order_manage.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/sale/customers', {
      templateUrl: 'views/sale/customers.php',
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
    .when('/views/work/new_work_draw', {
      templateUrl: 'views/work/new_work_draw.php',
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
    .when('/views/work/work_draw_manage', {
      templateUrl: 'views/work/work_draw_manage.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/work/draw_out', {
      templateUrl: 'views/work/draw_out.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/work/work_in', {
      templateUrl: 'views/work/work_in.php',
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
    .when('/views/outsource/os_out', {
      templateUrl: 'views/outsource/os_out.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/outsource/os_in', {
      templateUrl: 'views/outsource/os_in.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/outsource/os_order_manage', {
      templateUrl: 'views/outsource/os_order_manage.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/outsource/os_order_list', {
      templateUrl: 'views/outsource/os_order_list.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/outsource/os_in', {
      templateUrl: 'views/outsource/os_in.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/outsource/os_in_list', {
      templateUrl: 'views/outsource/os_in_list.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/outsource/os_in_test', {
      templateUrl: 'views/outsource/os_in_test.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/outsource/os_units', {
      templateUrl: 'views/outsource/os_units.php',
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
    .when('/views/setting/users', {
      templateUrl: 'views/setting/users.php',
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
    .when('/views/purchase/new_raw_purchase_order', {
      templateUrl: 'views/purchase/new_raw_purchase_order.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/purchase/purchase_order_list', {
      templateUrl: 'views/purchase/purchase_order_list.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/purchase/purchase_order_manage', {
      templateUrl: 'views/purchase/purchase_order_manage.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/purchase/purchase_in', {
      templateUrl: 'views/purchase/purchase_in.php',
      resolve: {
        async: ['$q', '$location', auth]
      }
    })
    .when('/views/purchase/suppliers', {
      templateUrl: 'views/purchase/suppliers.php',
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
    .when('/views/setting/bom', {
      templateUrl: 'views/setting/bom.php',
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
    })
    .when('/views/error', {
      templateUrl: 'views/error.php',
    })
    .when('/', {
      templateUrl: 'views/index.php',
    });
    $routeProvider.otherwise({      
      redirectTo: '/'
    });
  });
