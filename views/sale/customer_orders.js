var grid_data=[];
var detail_data=[];
var order_id=0;
jQuery(function($) {
	setTitle();	
	$('#print_btn').click(function(){
		if(order_id===0){
			var result={'status':false,'msg':'请先选择要打印的订单！'}
			showMsg(result);
		}else{
			var printDiv="#div_dtl"
			$(printDiv).jqprint();
		}
	})
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
		colNames:['客户', '订单日期'],
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
			//{name:'user_name',index:'user_name', width:50, editable: false} 
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
        			jQuery('#list_d').jqGrid('setGridParam',{url:"views/sale/sale_order_data.php?q=dtl&id="+id,page:1})
        			//jQuery("#list_d").jqGrid('setCaption','订单明细:'+id)
        			.trigger('reloadGrid');
        		}
        	}
    		else{
    			//select_obj['sale_order_id']=id;
    			//showToolbar();
    			order_id=id;
    			var rowData = $(grid_selector).jqGrid('getRowData',id);
    			var cust_name=rowData.cust_name;    			
    			$('#cust_name').html(cust_name);
    			jQuery('#list_d').jqGrid('setGridParam',{url:"views/sale/sale_order_data.php?q=dtl&id="+id,page:1})
    			//jQuery("#list_d").jqGrid('setCaption','订单明细:'+id)
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
		//editurl:'views/sale/edit.php',
		caption: "订单列表",
		autowidth: true,
	});
	loadDetail();	
});
function loadDetail(id){
	jQuery("#list_d").jqGrid({
		//url:'views/sale/sale_order_data.php?q=del&id='+id,
		datatype: "json",
		height: 350,
		colNames:['产品','规格', '数量','备注'],
		colModel:[
			//{name:'product_id',index:'product_id', width:50,},
			{name:'product_name',index:'product_name'},
			{name:'gg',index:'gg'},
			{name:'qty',index:'qty'},
			{name:'memo',index:'memo'}
		], 

		viewrecords : true,
		rowNum:10,
		rowList:[10,20,30],
		pager : 'pager_d',
		sortname:'item',
		viewrecords:true,
		sortorder:'asc',
		//caption:'订单明细',	
		autowidth: true,		
	});
}
//replace icons with FontAwesome icons like above
	function updatePagerIcons(table) {
		var replacement = 
		{
			'ui-icon-seek-first' : 'icon-double-angle-left bigger-140',
			'ui-icon-seek-prev' : 'icon-angle-left bigger-140',
			'ui-icon-seek-next' : 'icon-angle-right bigger-140',
			'ui-icon-seek-end' : 'icon-double-angle-right bigger-140'
		};
		$('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function(){
			var icon = $(this);
			var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
			
			if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
		})
	}