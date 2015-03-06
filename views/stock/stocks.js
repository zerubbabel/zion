jQuery(function($) {
	setTitle();
	//仓库
	loadLoc($('#loc'));
	
	loadDetail($("#loc").val());
	//update validate
	$('#loc').change(function(){
		var loc_id=$('#loc').val();
		jQuery('#tbl_dtl').jqGrid('setGridParam',{url:"views/stock/get_stocks.php?loc_id="+loc_id,page:1})
		.trigger('reloadGrid');	

	});	
	
	
	//产品过滤
	$('#product_filter').keyup(function(){
		doFilter(this.value);
	})

	//工具栏
	$("#toolbar").hide();
	
});

function loadDetail(loc_id){	
	var pager_selector='#pager';
	jQuery("#tbl_dtl").jqGrid({
		url:'views/stock/get_stocks.php?loc_id='+loc_id,
		datatype: "json",
		height: 200,
		colNames:['产品', '数量','最小库存'],
		colModel:[					
			{name:'name',index:'name', width:90, sortable:true,editable: false},
			{name:'qty',index:'qty', width:90, sortable:true,editable: false},
			{name:'min_stock',index:'min_stock', width:90, sortable:true,editable: false},
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
function loadModalProducts(){
	jQuery("#modal_tbl_products").jqGrid({
		url:'ajax/get_products.php',
		datatype: "json",
		colNames:['产品代码', '产品名称'],
		colModel:[					
			{name:'id',index:'id'},
			{name:'name',index:'name'},			
		], 
		autowidth: true,	
		onSelectRow: function(id){			
			if(id && id!==lastsel){				
				//产品添加到明细表中并且该行进入edit模式
				var flag=false;//产品是否已存在
				var datarow=$('#modal_tbl_products').getRowData(id);	
				for(var i=0;i<products.length;i++){
					if (id==products[i]['id']){
						flag=true;
						return false;
					}
				}					
				if (!flag){					
					products.push(datarow);					
					var newid=datarow['id'];					
					var su=$('#tbl_dtl').addRowData(newid, datarow, "last");						
					if (su){			
						$('#tbl_dtl').jqGrid('editRow',newid);
						var input_id=id+"_qty";
						var ele=$("#"+input_id);
						var width=ele.width();
						var td_width=ele.parent().width();
						ele.width(Math.round(td_width/2));
						var loc_id=$('#loc').val();						
						var para={'method':'getStockById','loc_id':loc_id,'product_id':id};
						var result=exeJson(para);
						var stock_qty=result['qty']==null?0:parseInt(result['qty']);
						var v_class={required:true,digits:true,range:[0,parseInt(stock_qty)]};
						addValidate(input_id,v_class);			
					}
				}				
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

