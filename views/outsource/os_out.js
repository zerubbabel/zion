var products=[];
var lastsel;
jQuery(function($) {
	setTitle();
	//外协单位
	loadSelect($('#os_unit'),'os_units');
	loadSelect($('#loc'),'locations');
	//update validate
	$('#loc').change(function(){
		var loc_id=$('#loc').val();
		var grid_id='grid_dtl';
		var trs=$("#"+grid_id+" tr");
		for(var i=1;i<trs.length;i++){
			var id=trs[i].id;
			var input_id=id+"_qty";
			var para={'method':'getStockById','loc_id':loc_id,'product_id':id};
			var result=exeJson(para);
			var stock_qty=result['qty']==null?0:parseInt(result['qty']);
			var v_class={required:true,digits:true,range:[0,parseInt(stock_qty)]};
			addValidate(input_id,v_class);		
		}
	});
	
	//明细
	loadDetail();
	
	//验证
	$("#frm").validate({
		submitHandler:function(form){			
			if ($('#grid_dtl tr').length>1){
        		saveOsOutOrder();	
        	}
        	else{
        		var result={'status':false,'msg':'请先添加需要外协加工的物品！'};
        		showMsg(result);
        	}
		}
	})

	//新增产品
	$('#add_btn').click(function(){
		$('#modal_products').modal({show:true});
		loadModalProducts();
		return false;
	});

	//产品过滤
	$('#product_filter').keyup(function(){
		doFilter(this.value);
	})
});

function saveOsOutOrder(){
	var para={'method':'insertOsOutOrder'};
	var mst_data={'os_unit':$('#os_unit').val(),'loc_id':$('#loc').val()};
	para['mst_data']=mst_data;
	var dtl_data={};
	var trs=$("#grid_dtl tr");
	for (var i=1;i<trs.length;i++){
		dtl_data[i-1]={};		
		dtl_data[i-1]['product_id']=trs[i].id;
		var qty=$('#'+trs[i].id+'_qty').val();
		dtl_data[i-1]['qty']=qty;
	}
	para['dtl_data']=dtl_data;
	var result=exeJson(para);
	showMsg(result);
	if(result['status']){
		//跳转到外协出库单列表
		window.location.href="index.php#/views/outsource/os_out_list";
	}
}

function loadDetail(){
	jQuery("#grid_dtl").jqGrid({
		data: products,
		datatype: "local",
		height: 200,
		colNames:[' ','产品', '数量','id'],
		colModel:[
			{name:'myac',index:'', fixed:true, sortable:false, resize:false,
				formatter:'actions', 
				formatoptions:{ 
					keys:true,		
					editbutton:false,	
					delOptions:{onclickSubmit:delProduct},	
				}
			},						
			{name:'name',index:'name', width:90, sortable:true,editable: false},
			{name:'qty',index:'qty', width:90, sortable:true,editable: true,
				editrules:{required:true,number:true}
			},
			{name:'id',index:'id', width:90,editable: false,hidden:true},
		], 
		caption:'产品明细:',	
		editurl: 'empty.php',//"views/sale/save2.php",
		autowidth: true,		
	});
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
				$.each(products,function(key,value){
					if(id==this.id){
						flag=true;
						return false;
					}
				})				
				if (!flag){					
					products.push(datarow);							
					var newid=id;
					var su=$('#grid_dtl').addRowData(newid, datarow, "last");						
					if (su){
						$('#grid_dtl').jqGrid('editRow',newid);
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

function delProduct(e){
	var delrow=$('#grid_dtl').jqGrid('getGridParam','selrow');
	var i=0;
	$.each(products,function(key,value){		
		if(delrow==this.id){
			products.splice(i,1);
			return false;
		}
		i++;
	})
}
