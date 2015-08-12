jQuery(function($) {
	setTitle();
	$("#btn_search").click(function(){
		reLoad();
	});
});

function reLoad(){
	var date_start=$('#date_start').val();
	var date_end=$('#date_end').val();
	if(date_start!=""&&date_end!=""){
		jQuery('#tbl_dtl').jqGrid('setGridParam',{url:"views/report/data/get_report.php?report_type='work_in'"
			+"&date_start="+date_start+"&date_end="+date_end,page:1})
		.trigger('reloadGrid');
	}
	else{alert('请输入开始时间，结束时间！')}
}

function loadDetail(report_type){	
	var pager_selector='#pager';
	jQuery("#tbl_dtl").jqGrid({
		//url:'views/report/data/get_report.php?report_type='+report_type,
		datatype: "json",
		height: 200,
		colNames:['产品代码','产品名称', '数量','最小库存','库位',''],
		colModel:[					
			{name:'product_id',index:'product_id', width:60, sortable:true,editable: false},
			{name:'name',index:'name', width:90, sortable:true,editable: false},
			{name:'qty',index:'qty', width:60, sortable:false,editable: false},
			{name:'min_stock',index:'min_stock', width:60, sortable:false,editable: false},
			{name:'bin',index:'bin', width:90, sortable:false,editable: true,edittype:'select',editoptions:{value:getBins($('#loc').val())}},
			{name:'myac',index:'', width:80, fixed:true, sortable:false, resize:false,
				formatter:'actions', 
				formatoptions:{ 
					keys:true,					
					delbutton:false,
				}
			}, 
		], 
		//caption:'产品:',
		rowNum:100,
		rowList:[10,20,30],
		pager : pager_selector,
		altRows: true,	
		height: 400,	
		autowidth: true,
		editurl:edit_url,
		loadComplete : function() {			
			var table = this;
			setTimeout(function(){
				updatePagerIcons(table);
				enableTooltips(table);
			}, 0);
		},	
	});

}

