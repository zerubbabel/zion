var go_url="index.php#/views/purchase/purchase_order_manage";

$(document).ready(function(){
	setTitle();
	
	loadSelect($('#supplier'),'suppliers');
	$( "#deliveryday" ).datepicker({
		format: 'yyyy-mm-dd',
		language: 'zh-CN',
		todayHighlight: true,
	});

	//验证,submit
	 $("#frm").validate({	 	
	 	rules:{
	 		'deliveryday':{required:true,}
	 	},
        submitHandler:function(form){    
        	savePurchaseOrder();
        }    
    });
	if(select_obj['sale_order_id']){			
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
function savePurchaseOrder(){
	var para={'method':'insertPurchaseOrder'};
	var mst_data={'sale_order_mst_id':select_obj['sale_order_id'],
		'supplier_id':$('#supplier').val(),
		'deliveryday':$('#deliveryday').val()};
	para['mst_data']=mst_data;
	var dtl_data={};
	var trs=$("#subpart_dtl tr");
	for (var i=1;i<trs.length;i++){
		dtl_data[i-1]={};		
		dtl_data[i-1]['product_id']=trs[i].id;
		var qty=$('#'+trs[i].id+'_p_qty').val();
		dtl_data[i-1]['qty']=qty;		
	}
	para['dtl_data']=dtl_data;
	var result=exeJson(para);
	showMsg(result);
	if(result['status']){
		//跳转到列表
		select_obj['sale_order_id']=null;
		window.location.href=go_url;//"index.php#/views/purchase/purchase_order_list";
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
		colNames:['产品', '订单剩余数量'],
		colModel:[
			{name:'product_name',index:'product_name', width:90, sortable:true,editable: false},
			{name:'qty',index:'qty', width:90, sortable:true,editable: false},
		], 
		caption: "销售订单产品明细",
		autowidth: true,
	});	

	var sub_data=getSubdata(real_data);
	loadSubpart(sub_data);
}

function getSubdata(data){
	var ans=[];
	var para={'method':'getSubpart'}
	for(var i=0;i<data.length;i++){
		var id=data[i]['id'];
		var qty=parseInt(dtl_data[i]['qty']);
		para['id']=id;
		var sub_data=exeJson(para);
		for (var j=0;j<sub_data.length;j++){
			var exist=false;
			for(var k=0;k<ans.length;k++){
				if (sub_data[j]['id']==ans[k]['id']){
					exist=true;
					ans[k]['qty']=parseInt(ans[k]['qty'])+parseInt(sub_data[j]['qty'])*qty;
					break;
				}
			}
			if(!exist){
				sub_data[j]['qty']=parseInt(sub_data[j]['qty'])*qty;
				ans.push(sub_data[j]);

			}
		}
	}
	return ans;
}

function loadSubpart(data){
	$("#subpart_dtl").jqGrid({
		data: data,
		datatype: "local",
		height: 300,
		colNames:['','配件', '标准采购数量','采购数量'],
		colModel:[
			{name:'act',index:'',width:30},
			{name:'name',index:'name', width:90, sortable:true,editable: false},
			{name:'qty',index:'qty', width:90, sortable:true,editable: false},
			{name:'p_qty',index:'p_qty', width:90, sortable:true,editable: true},
		], 
		caption: "待采购产品明细  "+"<i class='icon-plus-sign red actionIcon pointer tooltip-warning' data-rel='tooltip' title='添加配件'"+
					" data-placement='right' onclick=\"addPart();\" ></i>",
		autowidth: true,
		gridComplete: function(){
			$('[data-rel=tooltip]').tooltip();
			var ids = jQuery('#subpart_dtl').jqGrid('getDataIDs');
			for(var i=0;i < ids.length;i++){
				var cl = ids[i];
				del = "<i class='icon-trash orange pointer actionIcon ' onclick=\"delRow('subpart_dtl',"+cl+");\" ></i>"; 				
				jQuery('#subpart_dtl').jqGrid('setRowData',ids[i],{act:del});
				//enter edit
				$('#subpart_dtl').jqGrid('editRow',cl);
				var ele=$("#"+cl+"_p_qty");
				var width=ele.width();
				var td_width=ele.parent().width();
				ele.width(Math.round(td_width/2));
				var input_id=cl+"_p_qty";								
				var v_class={required:true,digits:true,min:0};
				addValidate(input_id,v_class);
			}
		},
	});		
}

function addPart(){
	var para={'method':'getProducts'};
	var data=exeJson(para);
	loadModal('选择采购物品',data,'subpart_dtl','_p_qty');
}



