﻿var grid_data=[];
var detail_data=[];
jQuery(function($) {
	setTitle();
	hideToolbar();
	
	var grid_selector = "#grid-table";
	var pager_selector = "#grid-pager";
	/*$.ajax({
        url: "ajax/get_data.php",
        async:false,
        success: function(data){
        	grid_data=jQuery.parseJSON(data);
        }
    });*/
	var para={'method':'getPassedSaleOrder'};
	var grid_data=exeJson(para);
	
	jQuery(grid_selector).jqGrid({
		data: grid_data,
		datatype: "local",
		height: 400,
		colNames:['客户', '交货日期','重要性','状态','操作人员'],
		colModel:[	
			{name:'cust_name',index:'cust_name', width:50},	
			{name:'deliveryday',index:'deliveryday',width:90, editable:true},	
			{name:'importance',index:'importance',width:40},		
			{name:'status',index:'status',width:50, editable:true,edittype:'select',editoptions:{value:get_status()}},
			{name:'user_name',index:'user_name', width:40} 
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
		colNames:['代码','产品','规格', '数量'],
		colModel:[
			{name:'product_id',index:'product_id', width:50},
			{name:'product_name',index:'product_name', width:90},
			{name:'gg',index:'gg', width:90},
			{name:'qty',index:'qty', width:90}
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
		addBtnPurchase();
		addBtnWorkDraw();
	}	
	$("#toolbar").show();	
}

function hideToolbar(){
	$("#toolbar").hide();
}
function addBtnSaleOut(){
	var html='<button class="btn btn-info" id="btn_sale_out">生成销售出库</button>';
	$("#toolbar").append(html);
	$("#btn_sale_out").click(function(){
		window.location.href="index.php#/views/sale/sale_out";
	})
}
function addBtnPurchase(){
	var html='<button class="btn btn-success" id="btn_purchase">生成采购订单</button>';
	$("#toolbar").append(html);
	$("#btn_purchase").click(function(){
		window.location.href="index.php#/views/purchase/new_purchase_order";
	})
}
function addBtnWorkDraw(){
	var html='<button class="btn btn-primary" id="btn_work_draw">生产领料</button>';
	$("#toolbar").append(html);
	$("#btn_work_draw").click(function(){
		window.location.href="index.php#/views/work/new_work_draw";
	})
}