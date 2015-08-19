﻿var mst_url='views/report/data/r_data.php?op=PurchaseInMst';
var dtl_url='views/report/data/r_data.php?op=Dtl&mst_table=purchase_in&id=';
var caption='采购入库单列表  ';
var dtl_caption='产品明细 ';
jQuery(function($) {
	setTitle();	
	var grid_selector = "#grid-table";
	var pager_selector = "#grid-pager";
	
	$("#btn_search").click(function(){
		reLoad();
	});
	
	jQuery(grid_selector).jqGrid({
		datatype: "json",
		height: 400,
		colNames:['供应商','仓库','操作人员','时间'],
		colModel:[
			{name:'supplier_name',index:'supplier_name', width:50},			
			{name:'loc_name',index:'loc_name',width:50},
			{name:'user_name',index:'user_name', width:40}, 
			{name:'createday',index:'createday', width:90},
		], 
		altRows: true,		
        onSelectRow:function(id){      
			if(id!=null){
    			jQuery('#list_d').jqGrid('setGridParam',{url:dtl_url+id});
    			jQuery("#list_d").jqGrid('setCaption',dtl_caption)
    			.trigger('reloadGrid');	
    		}
        },
		caption: caption,
		autowidth: true,
	});
	loadDetail();	
});

function reLoad(){
	var date_start=$('#date_start').val();
	var date_end=$('#date_end').val();
	if(date_start!=""&&date_end!=""){
		jQuery('#grid-table').jqGrid('setGridParam',{url:mst_url
			+"&date_start="+date_start+"&date_end="+date_end})
		.trigger('reloadGrid');
	}
	else{alert('请输入开始时间，结束时间！')}
}

function loadDetail(id){
	jQuery("#list_d").jqGrid({
		url:dtl_url+id,
		datatype: "json",
		height: 350,
		colNames:['代码','产品','规格', '数量','库位'],
		colModel:[
			{name:'product_id',index:'product_id', width:40},
			{name:'product_name',index:'product_name', width:110},
			{name:'gg',index:'gg', width:90},
			{name:'qty',index:'qty', width:30},
			{name:'bin',index:'bin', width:30},
		], 
		caption:dtl_caption,	
		autowidth: true,		
	});
}