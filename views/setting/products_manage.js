var grid_data=[];
var detail_data=[];
jQuery(function($) {
	setTitle();
	hideToolbar();
	
	//产品过滤
	$('#product_filter').keyup(function(){
		doFilter('grid-table',this.value);
	})

	var grid_selector = "#grid-table";
	var pager_selector = "#grid-pager";
	var para={'method':'getProducts'};
	var grid_data=exeJson(para);
	jQuery(grid_selector).jqGrid({
		data: grid_data,
		datatype: "local",
		height: 400,
		colNames:['操作','产品名称',],
		colModel:[		
			{name:'act',index:'act',width:10}, 	
			{name:'name',index:'name', width:90, editable: false} 
		], 

		viewrecords : true,
		rowNum:10,
		rowList:[10,20,30],
		pager : pager_selector,
		altRows: true,		
		multiselect: false,
        multiboxonly: true,
        onSelectRow:function(id){
        	
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
				var cl = ids[i];
				/*
				be = "<input type='button' value='设置最小库存' class='btn btn-success'"+
					 "onclick=\"setMin('"+cl+"');\" />";*/
				se = "<i class='icon-bell-alt orange pointer tooltip-warning' data-rel='tooltip' title='设置最小库存'"+
					" data-placement='right' onclick=\"setMin('"+cl+"');\" ></i>"; 
				
				jQuery(grid_selector).jqGrid('setRowData',ids[i],{act:se});
				$('[data-rel=tooltip]').tooltip();
			}
		},
		caption: "产品列表",
		autowidth: true,
	});
});
function setMin(id){
	var para={'method':'getProductById','id':id};
	var product=exeJson(para);
	$('#modal').modal({show:true});
	$('#modal_title').text('设置最小库存: 产品 '+product['name']);
	$('#modal_body').empty();//清空
	var html="<form id='frm' class='form-inline'><div class='input-group'>"+
		"<input type='text' placeholder='输入最小库存' id='min_stock' name='min_stock'"+
		" class='form-control' /><span class='input-group-btn'>"+
		"<input type='button' class='btn btn-sm' id='btn_edit'  value='修改' />"+
		"<input type='submit' class='btn btn-success btn-sm' id='btn_save'  value='确定' />"+
		"</span></div></form>";		
	$('#modal_body').append(html);	
	$('#min_stock').val(product['min_stock']);
	viewMode();
	$('#btn_edit').click(function(){
		editMode();		
	})
	$('#btn_save').click(function(){
		var para={'method':'updateMinStock','id':id,'min_stock':$('#min_stock').val()};
		var result=exeJson(para);		
		viewMode();
		showMsg(result);
	})
}
function viewMode(){
	$('#btn_edit').show();	
	$('#btn_save').hide();
	$('#min_stock').prop('disabled',true);
}

function editMode(){
	$('#btn_edit').hide();
	$("#btn_save").show();
	$('#min_stock').prop('disabled',false);
}


