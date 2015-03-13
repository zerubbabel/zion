var products=[];
var lastsel;
var go_url="index.php#/views/sale/sale_order_manage";
jQuery(function($) {
	setTitle();
	//客户
	loadCust($('#cust'));
	loadSelect($('#importance'),'importance');

	$( "#deliveryday" ).datepicker({
		format: 'yyyy-mm-dd',
		language: 'zh-CN',
		todayHighlight: true,
	});

	//明细
	loadDetail();
	
	//验证
	$("#frm").validate({
		rules:{
			'deliveryday':{required:true,}
		},
		submitHandler:function(form){	
			var trs=$("#grid_dtl tr");
			if (trs.length>1){				
				var mst_id=newSaleOrderMst();	
				if(mst_id>0){			
					newSaleOrderDtl(mst_id);
				}
			}
			else{
				var result={'status':false,'msg':'请选择订单产品！'};
				showMsg(result);
			}
			return false;
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
		doFilter('modal_tbl_products',this.value);
	})

});

function newSaleOrderMst(){
	var cust_id=$('#cust').val();
	var importance=$('#importance').val();
	var deliveryday=$('#deliveryday').val();
	var order_no=$('#order_no').val();
	var datas=[];
	datas.push(cust_id);
	datas.push(importance);
	datas.push(deliveryday);
	datas.push(order_no);
	var cols=['cust_id','importance','deliveryday','order_no'];
	var table='sale_order_mst';	
	return exeSql('insertMst',table,cols,datas);
}

function newSaleOrderDtl(mst_id){
	var optype='insertDtl';
	var table='sale_order_dtl';
	var cols=['mst_id','product_id','qty'];
	var trs=$("#grid_dtl tr");
	for (var i=1;i<trs.length;i++){
		var datas=[mst_id];
		var product_id=trs[i].id;
		var qty=$('#'+product_id+'_qty').val();
		datas.push(product_id);
		datas.push(qty);
		if (!(exeSql(optype,table,cols,datas)>0)){
			return false;
		}
	}
	var result={'status':true,'msg':'操作成功！'};
	showMsg(result);
	window.location.href=go_url;
	return true;
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
		height: 300,
		rowNum:10,
		//rowList:[10,20,30],
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
						var v_class={required:true,digits:true};
						addValidate(input_id,v_class);	
					}
				}				
			}
		},
		autowidth: true,	
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
