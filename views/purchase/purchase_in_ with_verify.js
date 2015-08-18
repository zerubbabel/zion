var mst_data;
var dtl_data;
$(document).ready(function(){
	setTitle();	
	loadSelect($('#loc'),'locations');
	//验证,submit
	 $("#frm").validate({	 	
        submitHandler:function(form){    
        	savePurchaseIn();
        }    
    });
	if(select_obj['purchase_order_id']){
		loadMst(select_obj['purchase_order_id']);		
		loadDtl(select_obj['purchase_order_id']);
		toTabOut();
	}else{
		toTabSelect();	
	}
	
	$("#btn_select").click(function(){
		window.location.href="index.php#/views/purchase/purchase_order_list";
	});
	$("#btn_reselect").click(function(){
		window.location.href="index.php#/views/purchase/purchase_order_list";
	});
	
})
function savePurchaseIn(){
	//选择仓库
	var loc_id=$('#loc').val();
	if (loc_id==0){
		var result={'status':false,'msg':'请选择入库仓库'};
		showMsg(result);
		return false;
	}
	var trs=$("#tbl_dtl tr");	
	//库位检查
	var dtl_data={};	
	for (var i=1;i<trs.length;i++){	
		dtl_data[i-1]={};		
		var bin=$('#'+trs[i].id+'_bin').val();
		var bin_id=getBinId(loc_id,bin);
		if (bin_id==0){
			var result={'status':false,'msg':'请检查！库位'+bin+'不存在！'};
			showMsg(result);
			return false;
		}
		dtl_data[i-1]['bin_id']=bin_id;
		dtl_data[i-1]['product_id']=trs[i].id;
		var qty=$('#'+trs[i].id+'_in_qty').val();
		dtl_data[i-1]['qty']=qty;		
	}
	var para={'method':'insertPurchaseInOrder'};
	var mst_data={'purchase_order_mst_id':select_obj['purchase_order_id'],'loc_id':loc_id};
	para['mst_data']=mst_data;
	
	para['dtl_data']=dtl_data;
	var result=exeJson(para);
	showMsg(result);
	if(result['status']){
		//跳转到列表
		select_obj['purchase_order_id']=null;
		window.location.href="index.php#/views/purchase/purchase_in_list";
	}
}

function toTabSelect(){
	$("#tab_select").show();
	$("#tab_out").hide();
}

function toTabOut(){
	$("#tab_select").hide();
	$("#tab_out").show();
}

function loadMst(id){
	var para={'method':'getPurchaseOrderMstById','id':id};
	mst_data=exeJson(para);
	$("#supplier").text("供应商:"+mst_data.supplier_name);
}

function loadDtl(id){
	var para={'method':'getPurchaseOrderDtlById','id':id};
	dtl_data=exeJson(para);	
	
	var para={'method':'getPurchaseInAllByPurchaseOrderId','id':id};
	var in_data=exeJson(para);

	for (var i =0; i<dtl_data.length; i++) {
		var product_id=dtl_data[i]['id'];
		var qty=parseInt(dtl_data[i]['qty']);
		dtl_data[i]['left_qty']=qty;
		for(var j=0;j<in_data.length;j++){
			var id=in_data[j]['id'];
			var in_qty=parseInt(in_data[j]['qty']);
			if (product_id==id){
				dtl_data[i]['left_qty']-=in_qty;
				break;
			}
		}
	}

	$("#tbl_dtl").jqGrid({
		data: dtl_data,
		datatype: "local",
		height: 300,
		colNames:['代码', '产品', '规格', '订单数量','剩余数量','入库数量','入库库位'],
		colModel:[
			{name:'product_id',index:'product_id', width:40},
			{name:'product_name',index:'product_name', width:90},
			{name:'gg',index:'gg', width:90},
			{name:'qty',index:'qty', width:30},
			{name:'left_qty',index:'left_qty', width:30},
			{name:'in_qty',index:'in_qty', width:70, editable: true},
			{name:'bin',index:'bin', width:70,editable: true},
		], 
		caption: "产品明细",
		autowidth: true,
	});	
	//编辑模式
	var validate_rule={};
	$.each(dtl_data,function(){
		$('#tbl_dtl').jqGrid('editRow',this.id);
		var id=this.id;
		var input_id=id+"_in_qty";
		var ele=$("#"+input_id);
		var width=ele.width();
		var td_width=ele.parent().width();
		ele.width(Math.round(td_width/2));					
		var v_class={required:true,digits:true,range:[0,parseInt(this.qty)]};
		addValidate(input_id,v_class);	
		//库位
		addValidate(id+"_bin",{required:true});
	});	
}

