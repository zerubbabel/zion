var mst_data;
var dtl_data;
$(document).ready(function(){

	setTitle();
	loadLoc($('#loc'));
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
	
})
function saveSaleOut(){
	var para={'method':'insertSaleOutOrder'};
	var mst_data={'sale_order_mst_id':select_obj['sale_order_id'],'loc_id':$('#loc').val()};
	para['mst_data']=mst_data;
	var dtl_data={};
	var trs=$("#tbl_dtl tr");
	for (var i=1;i<trs.length;i++){
		//debugger
		dtl_data[i-1]={};		
		dtl_data[i-1]['product_id']=trs[i].id;
		var qty=$('#'+trs[i].id+'_out_qty').val();
		dtl_data[i-1]['qty']=qty;
		dtl_data[i-1]['sale_order_mst_id']=select_obj['sale_order_id'];
	}
	para['dtl_data']=dtl_data;
	var result=exeJson(para);
	
	/*
	//库存变动待操作,订单销售完成处理
	var mst_id=newSaleOutMst(select_obj['sale_order_id']);	
	if(mst_id>0){			
		newSaleOutDtl(mst_id,select_obj['sale_order_id']);
		//window.location.href="index.php#/views/sale/sale_out_list";
	}
	*/
}
//出库数量验证
function checkQty(){
	var trs=$("#tbl_dtl tr");
	for (var i=1;i<trs.length;i++){
		var ele=$('#'+trs[i].id+'_out_qty')
		var out_qty=ele.val();

		var qty=dtl_data[i-1].qty;
		if (out_qty>qty){
			showError(ele,'出库数量不能大于订单数量！');
			return false;
		}
		else{
			unShowError(ele);
		}
	}
	return true;
}

function newSaleOutMst(sale_order_id){
	var datas=[];
	datas.push(sale_order_id);
	var loc_id=$('#loc').val();
	datas.push(loc_id);
	var cols=['sale_order_mst_id','loc_id'];
	var table='sale_out_mst';	
	return exeSql('insertMst',table,cols,datas);
}

function newSaleOutDtl(mst_id,order_id){
	var optype='insertDtl';
	var table='sale_out_dtl';
	var cols=['mst_id','product_id','qty','sale_order_mst_id'];
	var trs=$("#tbl_dtl tr");
	for (var i=1;i<trs.length;i++){
		var datas=[mst_id];
		var product_id=trs[i].id;
		var qty=$('#'+product_id+'_out_qty').val();
		datas.push(product_id);
		datas.push(qty);
		datas.push(order_id);
		if (!(exeSql(optype,table,cols,datas)>0)){
			return false;
		}
	}
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
	
	var para={'method':'saleOutAllBySaleOrderId','id':id};
	var out_data=getJsonData(para);
	if (out_data.length>0){
		var real_data=dtl_data;//not copy but nick name
		//get real_data
		$.each(real_data,function(i){
			this.qty=parseInt(this.qty)-parseInt(out_data[i].out_qty);
		});
	}
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
	var validate_rule={};
	$.each(dtl_data,function(){
		$('#tbl_dtl').jqGrid('editRow',this.product_id);	
		//验证规则
		var input_id=this.product_id+"_out_qty";
		var ele=$("#"+input_id);
		var width=ele.width();
		ele.width(Math.round(width/2));
		ele.attr('name',input_id);
		var v_class={required:true,digits:true,range:[0,parseInt(this.qty)]};
		validate_rule[input_id]=v_class;
	});
	//验证,submit
	 $("#frm").validate({
	 	rules:validate_rule,
        submitHandler:function(form){
        	saveSaleOut();
        }    
    });
}

