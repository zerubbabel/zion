var dtl_url='views/outsource/data/os_in_data.php?id=';
var go_url="index.php#/views/outsource/os_in_test";
var caption='外协入库单  ';
jQuery(function($) {
	setTitle();
	
	var grid_selector = "#grid-table";
	var pager_selector = "#grid-pager";
	var para={'method':'getOsInMst'};
	var grid_data=exeJson(para);
	
	jQuery(grid_selector).jqGrid({
		data: grid_data,
		datatype: "local",
		height: 400,
		colNames:['','加工单位', '入库日期','入库仓库','操作人员'],
		colModel:[
			{name:'act',width:50},
			{name:'os_unit_name',index:'o_unit_name', width:90,editable: false},	
			{name:'createday',index:'crreateday',width:90, editable:true},			
			{name:'loc_name',index:'loc_name',width:90, editable:false},
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
        			jQuery("#list_d").jqGrid('setCaption',caption+id)
        			.trigger('reloadGrid');
        		}
        	}
    		else{
    			
    			jQuery('#list_d').jqGrid('setGridParam',{url:dtl_url+id,page:1});
    			jQuery("#list_d").jqGrid('setCaption',caption+id)
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
		gridComplete: function(){
			
			var ids = jQuery(grid_selector).jqGrid('getDataIDs');
			for(var i=0;i < ids.length;i++){
				var id = ids[i];
				test = "<i class='icon-eye-open orange pointer tooltip-warning actionIcon'"+ 
					"data-rel='tooltip' data-placement='right'  title='检验' onclick=\"goOsTest("+id+");\" ></i>"; 				
				jQuery(grid_selector).jqGrid('setRowData',id,{act:test});
				$('[data-rel=tooltip]').tooltip();
			}
		},
		caption: caption,
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
		caption:caption+'明细',	
		autowidth: true,		
	});
}

function goOsTest(id){
	select_obj['os_in_id']=id;
	window.location.href=go_url;	
}
