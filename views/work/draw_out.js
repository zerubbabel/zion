var go_url="#/";
var select_url="index.php#/views/work/work_draw_list";
$(document).ready(function(){
	setTitle();	
	loadSelect($('#loc'),'locations');
	loadSelect($('#workcenter'),'workcenters');
	//验证,submit
	 $("#frm").validate({	 	
        submitHandler:function(form){    
        	saveDrawOut();
        }    
    });
	if(select_obj['work_draw_id']){
		loadMst(select_obj['work_draw_id']);		
		loadDtl(select_obj['work_draw_id']);
		toTabOut();
	}else{
		toTabSelect();	
	}
	
	$("#btn_select").click(function(){
		window.location.href=select_url;
	});
	$("#btn_reselect").click(function(){
		window.location.href=select_url;
	});
	
})
function saveDrawOut(){
	//选择仓库
	var loc_id=$('#loc').val();
	if (loc_id==0){
		var result={'status':false,'msg':'请选择领料仓库'};
		showMsg(result);
		return false;
	}
	var dtl_data={};
	var trs=$("#tbl_dtl tr");
	for (var i=1;i<trs.length;i++){
		var bin=$('#'+trs[i].id+'_bin').val();

		var bin_id=getBinId(loc_id,bin);
		if (bin_id==0){
			var result={'status':false,'msg':'请检查！库位'+bin+'不存在！'};
			showMsg(result);
			return false;
		}
		var product_id=trs[i].id;
		var bin_qty=getProductBinQty(bin_id,product_id);	
		var qty=parseInt($('#'+trs[i].id+'_out_qty').val());
		//验证库位数量是否够大
		if (qty>bin_qty){
			var td=$(trs[i]).find('td');
			var error_product_id=td[0].title;
			var error_product_name=td[1].title;
			var result={'status':false,
				'msg':'产品'+error_product_id+':'+error_product_name+'库位库存数量不足，无法出库！'};
			showMsg(result);
			return false;
		}
		if(qty>0){
			dtl_data[i-1]={};		
			dtl_data[i-1]['product_id']=product_id;			
			dtl_data[i-1]['qty']=qty;	
			dtl_data[i-1]['bin_id']=bin_id;
		}	
	}

	var para={'method':'insertDrawOutOrder'};
	var mst_data={'work_draw_mst_id':select_obj['work_draw_id'],'loc_id':$('#loc').val()};
	para['mst_data']=mst_data;
	
	para['dtl_data']=dtl_data;
	var result=exeJson(para);	
	showMsg(result);
	if(result['status']){
		select_obj['work_draw_id']=null;
		window.location.href=go_url;
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
	var para={'method':'getWorkDrawMst','id':id};
	mst_data=exeJson(para);
	$("#workcenter").text("领料车间:"+mst_data[0].workcenter_name);
}

function loadDtl(id){
	var para={'method':'getWorkDrawDtlById','id':id};
	dtl_data=exeJson(para);	
	
	var para={'method':'getDrawOutAllByWorkDrawId','id':id};
	var out_data=exeJson(para);
	
	for (var i =0; i<dtl_data.length; i++) {
		var product_id=dtl_data[i]['id'];
		var qty=parseInt(dtl_data[i]['qty']);
		dtl_data[i]['left_qty']=qty;
		for(var j=0;j<out_data.length;j++){
			var id=out_data[j]['id'];
			var out_qty=parseInt(out_data[j]['qty']);
			if (product_id==id){
				dtl_data[i]['left_qty']-=out_qty;
				break;
			}
		}
	}

	$("#tbl_dtl").jqGrid({
		data: dtl_data,
		datatype: "local",
		height: 300,
		colNames:['代码','产品','规格', '订单数量','剩余数量','出库数量','库位'],
		colModel:[
			{name:'product_id',index:'product_id', width:50},
			{name:'product_name',index:'product_name', width:90},
			{name:'gg',index:'gg', width:90},
			{name:'qty',index:'qty', width:40, sortable:true,editable: false},
			{name:'left_qty',index:'left_qty', width:40, sortable:true,editable: false},
			{name:'out_qty',index:'out_qty', width:40, sortable:true,editable: true},
			{name:'bin',index:'bin', width:40, editable: true},
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
		var v_class={required:true,digits:true,range:[0,parseInt(this.left_qty)]};
		addValidate(input_id,v_class);	
	});	
}

