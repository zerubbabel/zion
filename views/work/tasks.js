﻿var mst_url='views/work/data/r_data.php?op=workTask';
var grid_data=[];
var detail_data=[];
var days=7;
jQuery(function($) {
	setTitle();	
	var grid_selector = "#grid-table";
	var pager_selector = "#grid-pager";

	loadCust($('#cust'));
	$('.chosen-select').chosen({
		no_results_text: "找不到对应选项!",
	});
	
	$('.chosen-select').change(function(e){
		var cust_id=$(this).val();
		//alert(cust_id);
		//loadCustProduct(cust_id);
		jQuery(grid_selector).jqGrid('setGridParam',{url:mst_url
			+"&cust_id="+cust_id})
		.trigger('reloadGrid');

		/*
		$.ajax({
	        url: "ajax/exe_json.php",
	        async:false,
	        type:'post',
			data:{'para':{'method':'workTask','cust_id':cust_id}},
	        success: function(data){
	        	grid_data=jQuery.parseJSON(data);
	        }
	    });

	    */
	});	

	jQuery(grid_selector).jqGrid({
		//data: grid_data,
		//datatype: "local",
		url:mst_url,		
		datatype: "json",
		height: 400,
		colNames:['产品代码', '产品名称','规格','数量','装箱','备注','下单日期','交货日期'],
		colModel:[
			{name:'product_id',index:'product_id'},	
			{name:'product_name',index:'product_name',width:300},
			{name:'gg',index:'gg'},
			{name:'qty',index:'qty'},
			{name:'box',index:'box'},
			{name:'memo',index:'memo'},
			{name:'createday',index:'createday'},
			{name:'jh',index:'jh'}
		], 
		viewrecords : true,
		rowNum:10,
		rowList:[10,20,30],
		pager : pager_selector,
		altRows: true,		
		caption: "待生产产品列表",
		autowidth: true,
		gridComplete:function(){
			highlight(grid_selector,days);
		},
	});
});


function highlight(grid,days){
	var trs=$(grid+" tr");
	for (var i=1;i<trs.length;i++){
		var jh=$(grid).getCell(trs[i].id,'jh');
		if (inRush(days,jh)){
			$(trs[i]).addClass('alert alert-danger');
		}else{
			break;
		}
	}
}

function inRush(days,jh){
	s1 = new Date(jh.replace(/-/g, "/"));
	s2 = new Date();
	var delta = (s1.getTime() - s2.getTime()) / (1000 * 60 * 60 * 24);
	return !(delta>days);
}