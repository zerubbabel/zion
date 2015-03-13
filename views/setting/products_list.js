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
		colNames:['产品名称',],
		colModel:[			
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

		caption: "产品列表",
		autowidth: true,
	});
});

function showToolbar(){
	if($("#toolbar").children().length==0){
		addBtnSetMin('btn_set_min');
	}	
	$("#toolbar").show();	
}

function hideToolbar(){
	$("#toolbar").hide();
}
function addBtnSetMin(id){
	var html='<button class="btn btn-success" id="'+id+'">设置最小库存</button>';
	$("#toolbar").append(html);
	$("#"+id).click(function(){
		//window.location.href="index.php#/views/sale/sale_out";
	})
}

//test
function loadProducts(data_url){
	var grid_selector='#list_d';
	$(grid_selector).jqGrid({
		url:data_url,
		datatype: "json",
		height: 350,
		colNames:['产品'],
		colModel:[
			{name:'product_name',index:'product_name', width:90, sortable:true,editable: false},
			
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
	})
}

