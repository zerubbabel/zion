var grid_data=[];
var detail_data=[];
var dtl_url='views/purchase/data/purchase_order_data.php?id=';
jQuery(function($) {
	setTitle();
	
	var grid_selector = "#grid-table";
	var pager_selector = "#grid-pager";
	var para={'method':'getAllPurchaseOrderMst'};
	var grid_data=exeJson(para);
	
	jQuery(grid_selector).jqGrid({
		data: grid_data,
		datatype: "local",
		height: 400,
		colNames:['','供应商', '交货日期','状态','操作人员'],
		colModel:[
			{name:'myac',index:'', width:80, fixed:true, sortable:false, resize:false,
				formatter:'actions', 
				formatoptions:{ 
					keys:true,
					delbutton:false,
				}
			},	
			{name:'supplier_name',index:'supplier_name', width:90,editable: false},	
			{name:'deliveryday',index:'deliveryday',width:90, editable:true},			
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
        			jQuery('#list_d').jqGrid('setGridParam',{url:dtl_url+id,page:1});
        			jQuery("#list_d").jqGrid('setCaption','采购订单明细:'+id)
        			.trigger('reloadGrid');
        		}
        	}
    		else{
    			jQuery('#list_d').jqGrid('setGridParam',{url:dtl_url+id,page:1});
    			jQuery("#list_d").jqGrid('setCaption','采购订单明细:'+id)
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
		editurl:'views/purchase/data/purchase_order_edit.php',
		caption: "采购订单列表",
		autowidth: true,
	});
	loadDetail();	
});
function loadDetail(id){
	jQuery("#list_d").jqGrid({
		url:dtl_url+id,
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
		caption:'采购订单明细',	
		autowidth: true,		
	});
}
