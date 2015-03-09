var mst_data;
var dtl_data;
$(document).ready(function(){

	setTitle();
	
	loadSelect($('#supplier'),'suppliers');
	//验证,submit
	 $("#frm").validate({	 	
        submitHandler:function(form){    
        	saveSaleOut();
        }    
    });
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
		dtl_data[i-1]={};		
		dtl_data[i-1]['product_id']=trs[i].id;
		var qty=$('#'+trs[i].id+'_out_qty').val();
		dtl_data[i-1]['qty']=qty;		
	}
	para['dtl_data']=dtl_data;
	var result=exeJson(para);
	showMsg(result);
	if(result['status']){
		//跳转到出库单列表
		window.location.href="index.php#/views/sale/sale_out_list";
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
	
	var real_data=calRealData(dtl_data,out_data);//

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
		$('#tbl_dtl').jqGrid('editRow',this.id);
		var id=this.id;
		var input_id=id+"_out_qty";
		var ele=$("#"+input_id);
		var width=ele.width();
		var td_width=ele.parent().width();
		ele.width(Math.round(td_width/2));
		var loc_id=$('#loc').val();					
		var v_class={required:true,digits:true,range:[0,parseInt(this.qty)]};
		addValidate(input_id,v_class);	
	});	
}

