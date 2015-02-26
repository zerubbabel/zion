var mst_data;
var dtl_data;
$(document).ready(function(){
	setTitle();
	if(select_obj['sale_order_id']){
		loadSaleMst(select_obj['sale_order_id']);		
		loadSaleDtl(select_obj['sale_order_id']);
		toTabOut();
	}else{
		toTabSelect();	
	}
	

	$("#btn_select").click(function(){
		window.location.href="index.php#/views/sale/sale_order";
	});
	$("#btn_reselect").click(function(){
		window.location.href="index.php#/views/sale/sale_order";
	});
	$("#btn_save").click(function(){
		//数量有待验证，另外部分出库的话如何处理数量关系，库存变动
		var mst_id=newSaleOutMst(select_obj['sale_order_id']);	
		if(mst_id>0){			
			newSaleOutDtl(mst_id);
		}
	});
	
})

function newSaleOutMst(sale_order_id){
	var datas=[];
	datas.push(sale_order_id);
	var cols=['sale_order_mst_id'];
	var table='sale_out_mst';	
	return exeSql('insertMst',table,cols,datas);
}

function newSaleOutDtl(mst_id){
	var optype='insertDtl';
	var table='sale_out_dtl';
	var cols=['mst_id','product_id','qty'];
	var trs=$("#tbl_dtl tr");
	for (var i=1;i<trs.length;i++){
		var datas=[mst_id];
		var product_id=trs[i].id;
		var qty=$('#'+product_id+'_out_qty').val();
		datas.push(product_id);
		datas.push(qty);
		if (!(exeSql(optype,table,cols,datas)>0)){
			return false;
		}
	}
	//window.location.href="index.php#/views/sale/sale_order";
	return true;
}

function toTabSelect(){
	$("#tab_select").show();
	$("#tab_out").hide();
}

function toTabOut(){
	$("#tab_select").hide();
	$("#tab_out").show();
}

function loadSaleMst(id){
	var para={'method':'saleMstById','id':id};
	mst_data=getJsonData(para);
	$("#cust").text("客户:"+mst_data.cust_name);
}

function loadSaleDtl(id){
	var para={'method':'saleDtlById','id':id};
	dtl_data=getJsonData(para);	
	/*
	var para={'method':'saleOutDtlBySaleOrderId','id':id};
	var out_data=getJsonData(para);*/

	$("#tbl_dtl").jqGrid({
		data: dtl_data,
		datatype: "local",
		height: 300,
		colNames:['产品', '数量','出库数量'],
		colModel:[
			{name:'product_name',index:'product_name', width:90, sortable:true,editable: false},
			{name:'qty',index:'qty', width:90, sortable:true,editable: false},
			{name:'out_qty',index:'out_qty', width:90, sortable:true,editable: true},
		], 
		caption: "产品明细",
		autowidth: true,
	});	
	//编辑模式
	$.each(dtl_data,function(){
		$('#tbl_dtl').jqGrid('editRow',this.product_id);
	})
}

