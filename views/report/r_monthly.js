var mst_url='views/report/data/r_data.php?op=ProductMonthly';
var dtl_url='views/report/data/r_data.php?op=Dtl&mst_table=purchase_in&id=';
var caption='产品变动列表  ';
var dtl_caption='产品明细 ';
jQuery(function($) {
	setTitle();	
	var grid_selector = "#grid-table";
	var pager_selector = "#grid-pager";

	loadProducts($('#product'));
	$(".chosen-select").bind("chosen:activate", function () {
		alert($("#product").val());
	}); 
	$('.chosen-select').chosen({
		no_results_text: "找不到对应选项!",

	});

	$("#btn_search").click(function(){
		reLoad();
	});
	
	jQuery(grid_selector).jqGrid({
		datatype: "json",
		height: 400,
		colNames:['类型','时间','操作人员','仓库','库位','数量','单位'],
		colModel:[
			{name:'type',index:'type', width:50},	
			{name:'createday',index:'createday', width:90},					
			{name:'user_name',index:'user_name', width:40}, 
			{name:'loc_name',index:'loc_name',width:50},
			{name:'bin',index:'bin', width:90},
			{name:'qty',index:'qty',width:50},
			{name:'units',index:'units',width:50},
		], 
		altRows: true,		
        /*onSelectRow:function(id){      
			if(id!=null){
    			jQuery('#list_d').jqGrid('setGridParam',{url:dtl_url+id});
    			jQuery("#list_d").jqGrid('setCaption',dtl_caption)
    			.trigger('reloadGrid');	
    		}
        },*/
		caption: caption,
		autowidth: true,
	});
	//loadDetail();	
});

function reLoad(){
	var month=$('#month').val();
	var product_id=$('#product').val();
	if(month!=""){
		jQuery('#grid-table').jqGrid('setGridParam',{url:mst_url
			+"&month="+month+"&product_id="+product_id})
		.trigger('reloadGrid');
	}
	else{alert('请输入月份！')}
}

function loadDetail(id){
	jQuery("#list_d").jqGrid({
		url:dtl_url+id,
		datatype: "json",
		height: 350,
		colNames:['代码','产品','规格', '数量','库位','库存数量'],
		colModel:[
			{name:'product_id',index:'product_id', width:40},
			{name:'product_name',index:'product_name', width:110},
			{name:'gg',index:'gg', width:90},
			{name:'qty',index:'qty', width:30},
			{name:'bin',index:'bin', width:30},
			{name:'stock_qty',index:'stock_qty', width:30},
		], 
		caption:dtl_caption,	
		autowidth: true,		
	});
}