jQuery(function($) {
	setTitle();
	
	
	loadDetail($("#loc").val());
	
	//产品过滤
	$('#product_filter').keyup(function(){
		doFilter(this.value);
	})

	//工具栏
	$("#toolbar").hide();
	
});
/*
function loadDetail(loc_id){	
	var pager_selector='#pager';
	jQuery("#tbl_dtl").jqGrid({
		url:'views/stock/get_stocks.php?loc_id='+loc_id,
		datatype: "json",
		height: 200,
		colNames:['产品', '数量'],
		colModel:[					
			{name:'name',index:'name', width:90, sortable:true,editable: false},
			{name:'qty',index:'qty', width:90, sortable:true,editable: false}
		], 
		caption:'产品:',
		rowNum:10,
		rowList:[10,20,30],
		pager : pager_selector,
		altRows: true,	
		height: 400,	
		autowidth: true,
		loadComplete : function() {
			var table = this;
			setTimeout(function(){
				updatePagerIcons(table);
				enableTooltips(table);
			}, 0);
		},	
	});
}
*/

function loadDetail(){	
	var pager_selector='#pager';
	var para={'method':'getProducts'};
	var products=exeJson(para);
	jQuery("#tbl_dtl").jqGrid({
		data:products,
		datatype: "local",
		height: 200,
		colNames:['产品'],
		colModel:[					
			{name:'name',index:'name', width:90, sortable:true,editable: false},
		], 
		caption:'产品列表:',
		rowNum:10,
		rowList:[10,20,30],
		pager : pager_selector,
		altRows: false,	
		height: 400,	
		autowidth: true,
		loadComplete : function() {
			var table = this;
			setTimeout(function(){
				updatePagerIcons(table);
				enableTooltips(table);
			}, 0);
		},	
		onSelectRow:function(id){
			//alert(id);
			var toolbar=$("#toolbar");
			toolbar.show();
			if($("#btn_set_min").length==0){
				var btnHtml='<button class="btn btn-success icon-check" id="btn_set_min">设置最小库存</button>';
				toolbar.append(btnHtml);
				$("#btn_set_min").click(function(){
					//alert(id);
				})
			}
		},	
	});
}
function doFilter(str){
	var rows=$('#modal_tbl_products').jqGrid('getRowData');
	var trs=$('#modal_tbl_products').find('tr');
	$(rows).each(function(i,v){
		$(trs[i+1]).hide();
		$.each(v, function(key, value) { 
			var pos=value.indexOf(str);
		  	if (value.indexOf(str)>=0){
				$(trs[i+1]).show();
				return false;
			}
		});
	});
}

