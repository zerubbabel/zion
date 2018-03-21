var mst_data;
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
	//var para={'method':'insertSaleOutOrder'};
	var para={'method':'insertCustomerOrderOut'};
	var mst_data={'cust_id':$('#cust').val()};
	para['mst_data']=mst_data;
	var dtl_data={};
	var trs=$("#tbl_dtl tr");
	var k=0;
	for (var i=1;i<trs.length;i++){
		//var product_id=trs[i].id;		
		var out=parseInt($('#'+trs[i].id+'_out').val());	
		if (isNaN(out)) {out=0;}	
		var qty=parseInt($("#tbl_dtl").getCell(trs[i].id,'qty'));
		if (qty<out){			
			var result={'status':false,'msg':'出库数量不能大于订单剩余数量!'};
			showMsg(result);
			return false;
		}
		if(out>0){

			dtl_data[k]={};		
			dtl_data[k]['product_id']=parseInt($("#tbl_dtl").getCell(trs[i].id,'p_id'));//trs[i].id;			
			dtl_data[k]['out']=out;
			dtl_data[k]['dtl_id']=parseInt($("#tbl_dtl").getCell(trs[i].id,'dtl_id'));			
			dtl_data[k]['mst_id']=parseInt($("#tbl_dtl").getCell(trs[i].id,'mst_id'));
			k++;
		}				
	}
	para['dtl_data']=dtl_data;
	var result=exeJson(para);
	showMsg(result);
	if(result['status']){		
		//window.location.href=go_url;
	}
}

function loadSaleDtl(){
	$("#tbl_dtl").jqGrid({
		datatype: "json",		
		height: 300,
		colNames:['','代码','产品','规格', '装箱', '备注','剩余数量', '出库数量','dtl_id','mst_id','id'],
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
			{name:'dtl_id',index:'dtl_id',editable: false,hidden:true},	
			{name:'mst_id',index:'mst_id',editable: false,hidden:true},	
			{name:'p_id',index:'p_id',editable: false,hidden:true},	
		], 
		//caption: caption+"<i class='icon-plus-sign red actionIcon pointer tooltip-warning'"+
		//	" data-rel='tooltip' title='选择出库物品' data-placement='right' onclick=\"addProduct('#tbl_dtl','_qty');\" ></i>",
		autowidth: true,
		gridComplete:function(){
			//$('[data-rel=tooltip]').tooltip();
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