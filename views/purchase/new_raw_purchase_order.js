var products=[];
var lastsel;
var go_url="index.php#/views/purchase/purchase_order_list";
var products_data;
jQuery(function($) {
	setTitle();
	//供应商
	loadSelect($('#supplier'),'suppliers');

	//明细
	loadDetail();
	
	//验证
	$("#frm").validate({
		rules:{

		},
		submitHandler:function(form){	
			var trs=$("#grid_dtl tr");
			if (trs.length>1){				
				/*var mst_id=newPurchaseOrderMst();	
				if(mst_id>0){			
					newPurchaseOrderDtl(mst_id);
				}*/
				savePurchaseOrder();
			}
			else{
				var result={'status':false,'msg':'请选择订单产品！'};
				showMsg(result);
			}
			return false;
		}
	})
	//新增产品
	var para={'method':'getProducts'};
	products_data=exeJson(para);
	$('#add_btn').click(function(){
		openModalProducts(products_data,'#grid_dtl','_qty');
		return false;
	});

});


function savePurchaseOrder(){
	//选择供应商
	var supplier_id=$('#supplier').val();
	if (supplier_id==0){
		var result={'status':false,'msg':'请选择供应商'};
		showMsg(result);
		return false;
	}
	var para={'method':'insertPurchaseOrder'};
	var mst_data={'supplier_id':$('#supplier').val(),'status':3};
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
		//跳转到列表
		window.location.href=go_url;
	}
}
/*
function newPurchaseOrderMst(){
	var cust_id=$('#cust').val();
	var datas=[];
	datas.push(cust_id);
	datas.push(importance);
	datas.push(deliveryday);
	datas.push(order_no);
	var cols=['cust_id','importance','deliveryday','order_no'];
	var table='sale_order_mst';	
	return exeSql('insertMst',table,cols,datas);
}

function newPurchaseOrderDtl(mst_id){
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
*/
function loadDetail(){
	jQuery("#grid_dtl").jqGrid({
		data: products,
		datatype: "local",
		height: 300,
		colNames:[' ','代码','名称','规格', '数量','id'],
		colModel:[
			{name:'myac',index:'', fixed:true, sortable:false, resize:false,
				formatter:'actions', 
				formatoptions:{ 
					keys:true,		
					editbutton:false,	
					delOptions:{onclickSubmit:delProduct},	
				}
			},						
			{name:'product_id',index:'product_id', width:60},
			{name:'name',index:'name', width:110},
			{name:'gg',index:'gg', width:110},
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
