var grid_data=[];
var detail_data=[];
jQuery(function($) {
	setTitle();
	hideToolbar();
	
	var grid_selector = "#grid-table";
	var pager_selector = "#grid-pager";
	$.ajax({
        url: "ajax/get_data.php",
        async:false,
        success: function(data){
        	grid_data=jQuery.parseJSON(data);
        }
    });
	
	jQuery(grid_selector).jqGrid({
		data: grid_data,
		datatype: "local",
		height: 400,
		colNames:['','订单日期','客户', '交货日期','重要性','状态','操作人员'],
		colModel:[
			{name:'myac',index:'', width:80, fixed:true, sortable:false, resize:false,
				formatter:'actions', 
				formatoptions:{ 
					keys:true,
					delbutton:false,
				}
			},
			{name:'createday',index:'createday',width:90, editable:false},	
			{name:'cust_name',index:'cust_name', width:90,editable: false},	
			{name:'deliveryday',index:'deliveryday',width:90, editable:true},	
			{name:'importance',index:'importance',width:90, editable:false},		
			{name:'status',index:'status',width:90, editable:true,edittype:'select',editoptions:{value:get_status()}},
			{name:'user_name',index:'user_name', width:90, editable: false} 
		], 

		viewrecords : true,
		rowNum:10,
		rowList:[10,20,30],
		pager : pager_selector,
		altRows: true,		
		multiselect: false,
        multiboxonly: true,
        onSelectRow:function(id){
        	if(id==null){
        		id=0;
        		if(jQuery("#list_d").jqGrid('getGridParam','record')>0){
        			jQuery('#list_d').jqGrid('setGridParam',{url:"views/sale/sale_order_data.php?q=dtl&id="+id,page:1});
        			jQuery("#list_d").jqGrid('setCaption','销售订单明细:'+id)
        			.trigger('reloadGrid');
        		}
        	}
    		else{
    			select_obj['sale_order_id']=id;
    			showToolbar();
    			jQuery('#list_d').jqGrid('setGridParam',{url:"views/sale/sale_order_data.php?q=dtl&id="+id,page:1});
    			jQuery("#list_d").jqGrid('setCaption','销售订单明细:'+id)
    			.trigger('reloadGrid');	
    		}
        },
        loadComplete : function() {
			var table = this;
			setTimeout(function(){
				updatePagerIcons(table);
				enableTooltips(table);
			}, 0);
		},
		editurl:'views/sale/sale_order_edit.php',
		caption: "销售订单列表",
		autowidth: true,
	});
	loadDetail();	
});
function loadDetail(id){
	jQuery("#list_d").jqGrid({
		url:'views/sale/sale_order_data.php?q=del&id='+id,
		datatype: "json",
		height: 350,
		colNames:['产品', '数量'],
		colModel:[
			{name:'product_name',index:'product_name', width:90, sortable:true,editable: false},
			{name:'qty',index:'qty', width:90, sortable:true,editable: false}
		], 

		viewrecords : true,
		rowNum:10,
		rowList:[10,20,30],
		pager : 'pager_d',
		sortname:'item',
		viewrecords:true,
		sortorder:'asc',
		caption:'销售订单明细',	
		autowidth: true,		
	});
}

function showToolbar(){
	if($("#toolbar").children().length==0){
		addBtnSaleOut();
	}	
	$("#toolbar").show();	
}

function hideToolbar(){
	$("#toolbar").hide();
}
function addBtnSaleOut(){
	var html='<button class="btn btn-success icon-check" id="btn_sale_out">生成销售出库</button>';
	$("#toolbar").append(html);
	$("#btn_sale_out").click(function(){
		window.location.href="index.php#/views/sale/sale_out";
	})
}