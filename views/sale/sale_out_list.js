var grid_data=[];
var dtl_data=[];
jQuery(function($) {
	setTitle();
	hideToolbar();
	
	var grid_selector = "#grid-table";
	var pager_selector = "#grid-pager";
	var para={'method':'getSaleOutList'};
	grid_data=exeJson(para);
	
	jQuery(grid_selector).jqGrid({
		data: grid_data,
		datatype: "local",
		height: 400,
		colNames:['出库仓库','出库日期','客户', '操作人员'],
		colModel:[
			//{name:'sale_order_mst_id',index:'sale_order_mst_id',width:90, editable:false},	
			
			{name:'loc_name',index:'loc_name',width:70, editable:false},
			{name:'createday',index:'createday',width:90, editable:false},
			{name:'cust_name',index:'cust_name', width:60,editable: false},		
			{name:'user_name',index:'user_name', width:60, editable: false} 
		], 
		rowNum:10,
		rowList:[10,20,30],
		pager : pager_selector,
        onSelectRow:function(id){            
        	if(id==null){
        		var para={};          		
        		$("#list_d").jqGrid('setGridParam',{url:'ajax/exe_json.php',postData:{'para':para},})
        		.trigger('reloadGrid');
        	}else{        	
    			select_obj['sale_order_id']=id;
    			showToolbar();
    			var para={'method':'getSaleOutDtlById','id':id};
    			
    			dtl_data=getJsonData(para); 
    					    	
    			$("#list_d").jqGrid('setGridParam',{url:'ajax/exe_json.php',postData:{'para':para},})
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

		caption: "销售出库单列表",
		autowidth: true,
	});
	loadDetail();	
});
function loadDetail(para){
	jQuery("#list_d").jqGrid({
		url:'ajax/exe_json.php',
		mtype:'post',
		datatype: "json",
		postData:{'para':para},
		height: 250,
		colNames:['代码', '产品', '规格', '数量'],
		colModel:[
			{name:'product_id',index:'product_id', width:90},
			{name:'product_name',index:'product_name', width:90},
			{name:'gg',index:'gg', width:90},
			{name:'qty',index:'qty', width:90, sortable:true,editable: false}
		], 

		viewrecords : true,
		rowNum:10,
		rowList:[10,20,30],
		pager : 'pager_d',
		sortname:'item',
		viewrecords:true,
		sortorder:'asc',
		caption:'销售出库单明细',	
		autowidth: true,		
	});
}

function showToolbar(){
	if($("#toolbar").children().length==0){
		//addBtnSaleOutBack();
	}	
	$("#toolbar").show();
	
}

function hideToolbar(){
	$("#toolbar").hide();
}
//todo
function addBtnSaleOutBack(){
	var html='<button class="btn btn-success icon-check" id="btn_sale_out_back">生成销售出库退货单</button>';
	$("#toolbar").append(html);
	$("#btn_sale_out_back").click(function(){
		window.location.href="index.php#/views/sale/sale_out_back";
	})
}