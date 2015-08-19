var dtl_url='views/report/data/r_work_in_data.php?id=';
var caption='生产入库单列表  ';
jQuery(function($) {
	setTitle();
	
	var grid_selector = "#grid-table";
	var pager_selector = "#grid-pager";
	
	$("#btn_search").click(function(){
		reLoad();
	});

	var para={'method':'getWorkInMst',
		'date_start':$('#date_start').val(),
		'date_end':$('#date_end').val()};
	var grid_data=exeJson(para);
	
	jQuery(grid_selector).jqGrid({
		//data: grid_data,
		url:'',
		datatype: "json",
		height: 400,
		colNames:['车间','入库仓库','操作人员','入库时间'],
		colModel:[
			//{name:'act',index:'', width:50, fixed:true, sortable:false, resize:false,},	
			{name:'workcenter_name',index:'workcenter_name', width:50,editable: false},			
			{name:'loc_name',index:'loc_name',width:50, editable:false},
			{name:'user_name',index:'user_name', width:40, editable: false}, 
			{name:'createday',index:'createday', width:90, editable: false},
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
			/*var ids = jQuery(grid_selector).jqGrid('getDataIDs');
			for(var i=0;i < ids.length;i++){
				var id = ids[i];
				draw = "<i class='icon-upload orange pointer tooltip-warning actionIcon'"+ 
					"data-rel='tooltip' data-placement='right'  title='领料' onclick=\"goWorkOut("+id+");\" ></i>"; 				
				jQuery(grid_selector).jqGrid('setRowData',id,{act:draw});
				$('[data-rel=tooltip]').tooltip();
			}*/
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
		jQuery('#grid-table').jqGrid('setGridParam',{url:"views/report/data/get_report.php?report_type=work_in"
			+"&date_start="+date_start+"&date_end="+date_end,page:1})
		.trigger('reloadGrid');
	}
	else{alert('请输入开始时间，结束时间！')}
}

function loadDetail(id){
	jQuery("#list_d").jqGrid({
		url:dtl_url+id,
		datatype: "json",
		height: 350,
		colNames:['代码','产品','规格', '数量'],
		colModel:[
			{name:'product_id',index:'product_id', width:40},
			{name:'product_name',index:'product_name', width:110, sortable:true,editable: false},
			{name:'gg',index:'gg', width:90},
			{name:'qty',index:'qty', width:30, sortable:true,editable: false}
		], 

		viewrecords : true,
		rowNum:10,
		rowList:[10,20,30],
		pager : 'pager_d',
		sortname:'item',
		viewrecords:true,
		sortorder:'asc',
		caption:'产品明细',	
		autowidth: true,		
	});
}