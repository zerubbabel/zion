﻿var mst_data;
var dtl_data;
var caption='出库产品明细  ';
var go_url="#/";
$(document).ready(function(){

	setTitle();
	//loadSelect($('#loc'),'locations');
	loadCust($('#cust'));
	$('.chosen-select').chosen({
		no_results_text: "找不到对应选项!",
	});
	
	$('.chosen-select').change(function(e){
		var cust_id=$(this).val();
		loadCustProduct(cust_id);
		
	});
	loadSaleDtl();
	//验证,submit
	 $("#frm").validate({	 	
        submitHandler:function(form){  
		    var trs=$("#tbl_dtl tr");
				if (trs.length>1){				
					saveSaleOut();
				}
				else{
					var result={'status':false,'msg':'请选择待出库的产品！'};
					showMsg(result);
				}
				return false;   
        	
        }    
    });		
})

function loadCustProduct(cust_id){
	jQuery("#tbl_dtl").jqGrid("clearGridData");
	jQuery('#tbl_dtl').jqGrid('setGridParam',{url:"views/sale/sale_order_data.php?q=custProduct&cust_id="+cust_id,page:1});    		
	jQuery('#tbl_dtl').trigger('reloadGrid');	
}
function saveSaleOut(){
	//选择仓库
	var cust_id=$('#cust').val();
	if (cust_id==0){
		var result={'status':false,'msg':'请选择客户'};
		showMsg(result);
		return false;
	}
	var para={'method':'insertSaleOutOrder'};
	var mst_data={'sale_order_mst_id':null,'loc_id':$('#loc').val(),'cust_id':$('#cust').val()};
	para['mst_data']=mst_data;
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
		var bin_qty=parseInt(getProductBinQty(bin_id,product_id));
		var qty=parseInt($('#'+trs[i].id+'_qty').val());
		
		if (qty>bin_qty){
			var td=$(trs[i]).find('td');
			var product_id=td[0].title;
			var product_name=td[1].title;
			var result={'status':false,
				'msg':'产品'+product_id+':'+product_name+'库位库存数量不足，无法出库！'};
			showMsg(result);
			return false;
		}
		if(qty>0){
			dtl_data[i-1]={};		
			dtl_data[i-1]['product_id']=trs[i].id;			
			dtl_data[i-1]['qty']=qty;
			dtl_data[i-1]['bin_id']=bin_id;
		}
				
	}
	para['dtl_data']=dtl_data;
	var result=exeJson(para);
	showMsg(result);
	if(result['status']){
		//跳转到出库单列表
		//select_obj['sale_order_id']=null;
		window.location.href=go_url;
	}
}

function loadSaleDtl(){
	$("#tbl_dtl").jqGrid({
		//url:"views/sale/sale_order_data.php?q=custProduct&cust_id="+cust_id,
		datatype: "json",
		//datatype: "local",
		height: 300,
		colNames:['','代码','产品','规格', '装箱', '备注','剩余数量', '出库数量'],
		colModel:[
			{name:'act',width:40},
			{name:'product_id',index:'product_id', width:50},
			{name:'name',index:'name', width:110},
			{name:'gg',index:'gg', width:110},
			{name:'box',index:'box', width:110},
			{name:'memo',index:'memo', width:110},
			{name:'qty',index:'qty', width:60},
			{name:'out',index:'out', width:60,editable: true,
				editrules:{required:true,number:true}},
			
		], 
		caption: caption+"<i class='icon-plus-sign red actionIcon pointer tooltip-warning'"+
			" data-rel='tooltip' title='选择出库物品' data-placement='right' onclick=\"addProduct('#tbl_dtl','_qty');\" ></i>",
		autowidth: true,
		editurl: 'empty.php',
		gridComplete:function(){
			$('[data-rel=tooltip]').tooltip();
			var ids = jQuery('#tbl_dtl').jqGrid('getDataIDs');
			for(var i=0;i < ids.length;i++){
				var cl = ids[i];
				del = "<i class='icon-trash red pointer actionIcon ' onclick=\"delRow('#tbl_dtl',"+cl+");\" ></i>"; 				
				jQuery('#tbl_dtl').jqGrid('setRowData',ids[i],{act:del});
				jQuery('#tbl_dtl').jqGrid('editRow',ids[i]);
			}
		},
	});	
	
}


