var grid_data=[];
var detail_data=[];
jQuery(function($) {
	setTitle();	
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
		colNames:['客户', '订单日期','操作人员'],
		colModel:[
			/*{name:'myac',index:'', width:40, fixed:true, sortable:false, resize:false,
				formatter:'actions', 
				formatoptions:{ 
					//keys:true,
					delbutton:false,
				}
			},	*/
			{name:'cust_name',index:'cust_name', width:50,editable: false},	
			{name:'createday',index:'createday',width:60, editable:true},	
			//{name:'importance',index:'importance',width:40, editable:false},		
			//{name:'status',index:'status',width:50, editable:true,edittype:'select',editoptions:{value:get_status()}},
			{name:'user_name',index:'user_name', width:50, editable: false} 
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
        			jQuery("#list_d").jqGrid('setCaption','订单明细:'+id)
        			.trigger('reloadGrid');
        		}
        	}
    		else{
    			//select_obj['sale_order_id']=id;
    			//showToolbar();
    			jQuery('#list_d').jqGrid('setGridParam',{url:"views/sale/sale_order_data.php?q=dtl&id="+id,page:1});
    			jQuery("#list_d").jqGrid('setCaption','订单明细:'+id)
    			.trigger('reloadGrid');	
    		}
        },
        /*loadComplete : function() {
			var table = this;
			setTimeout(function(){
				updatePagerIcons(table);
				enableTooltips(table);
			}, 0);
		},*/
		//editurl:'views/sale/sale_order_edit.php',
		caption: "订单列表",
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
			{name:'product_id',index:'product_id', width:50,},
			{name:'product_name',index:'product_name', width:90,},
			{name:'gg',index:'gg', width:90,},
			{name:'qty',index:'qty', width:40,}
		], 

		viewrecords : true,
		rowNum:10,
		rowList:[10,20,30],
		pager : 'pager_d',
		sortname:'item',
		viewrecords:true,
		sortorder:'asc',
		caption:'订单明细',	
		autowidth: true,		
	});
}