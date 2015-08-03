jQuery(function($) {
	setTitle();
	//仓库
	loadLoc($('#loc'));
	
	loadDetail($("#loc").val());

	//update validate
	$('#loc').change(function(){
		/*var loc_id=$('#loc').val();
		jQuery('#tbl_dtl').jqGrid('setGridParam',{url:"views/stock/get_stocks.php?loc_id="+loc_id,page:1})
		.trigger('reloadGrid');	
		*/
	});	
	
	
	//产品过滤
	/*$('#product_filter').keyup(function(){
		doFilter(this.value);
	})*/

	$("#btn_search").click(function(){
		var loc_id=$('#loc').val();
		var product=$('#product').val();
		var bin=$('#bin').val();
		jQuery('#tbl_dtl').jqGrid('setGridParam',{url:"views/stock/get_stocks.php?loc_id="+loc_id
			+"&product_name="+product+"&bin="+bin,page:1})
		.trigger('reloadGrid');

	});
	
});

function loadDetail(loc_id){	
	var pager_selector='#pager';
	jQuery("#tbl_dtl").jqGrid({
		url:'views/stock/get_stocks.php?loc_id='+loc_id,
		datatype: "json",
		height: 200,
		colNames:['产品', '数量','最小库存','库位'],
		colModel:[					
			{name:'name',index:'name', width:90, sortable:true,editable: false},
			{name:'qty',index:'qty', width:90, sortable:false,editable: false},
			{name:'min_stock',index:'min_stock', width:90, sortable:false,editable: false},
			{name:'bin',index:'bin', width:90, sortable:false,editable: false},
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
			colorRow($(table));
			setTimeout(function(){
				updatePagerIcons(table);
				enableTooltips(table);
			}, 0);
		},	
	});

}
function colorRow(table){
	var trs=table.find('tr');
	for (var i=1;i<trs.length;i++){
		var ele=$(trs[i]).find('td');
		var qty=parseInt(ele[1].title);
		var min_stock=parseInt(ele[2].title);
		if (qty<min_stock){
			$(trs[i]).addClass('danger');
		}
	}
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

