var mst_data;
var dtl_data;
var go_url="index.php#/views/purchase/purchase_in_list";
var caption="采购入库明细：";
$(document).ready(function(){
	setTitle();	
	loadSelect($('#loc'),'locations');
	
	loadSelect($('#supplier'),'suppliers');

	$('.chosen-select').chosen({
		no_results_text: "找不到对应选项!",
		
	});
	
	//验证,submit
	 $("#frm").validate({	 	
        submitHandler:function(form){    
        	var trs=$("#tbl_dtl tr");
			if (trs.length>1){				
				savePurchaseIn();
			}
			else{
				var result={'status':false,'msg':'请选择待入库的产品！'};
				showMsg(result);
			}
			return false; 
        	
        }    
    });	
	loadDtl();
	
})
function savePurchaseIn(){
	//选择仓库
	var supplier_id=$('#supplier').val();
	if (supplier_id==0){
		var result={'status':false,'msg':'请选择供应商'};
		showMsg(result);
		return false;
	}
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
		var qty=$('#'+trs[i].id+'_qty').val();
		dtl_data[i-1]['qty']=qty;		
	}
	var para={'method':'insertPurchaseInOrder'};
	var mst_data={'purchase_order_mst_id':null,'loc_id':loc_id,
		'supplier_id':supplier_id};
	para['mst_data']=mst_data;
	
	para['dtl_data']=dtl_data;
	var result=exeJson(para);
	showMsg(result);
	if(result['status']){
		window.location.href=go_url;
	}
}
function loadDtl(id){

	$("#tbl_dtl").jqGrid({
		datatype: "local",
		height: 300,
		colNames:['','代码', '产品', '规格', '数量','库位'],
		colModel:[
			{name:'act',index:'act',width:40},
			{name:'product_id',index:'product_id', width:40},
			{name:'name',index:'name', width:90},
			{name:'gg',index:'gg', width:90},
			{name:'qty',index:'qty', width:70, editable: true},
			{name:'bin',index:'bin', width:70,editable: true},
		], 
		caption: caption+"<i class='icon-plus-sign red actionIcon pointer tooltip-warning'"+
			" data-rel='tooltip' title='选择入库物品' data-placement='right' onclick=\"addProduct('#tbl_dtl','_qty');\" ></i>",
		autowidth: true,
		gridComplete:function(){
			$('[data-rel=tooltip]').tooltip();
			var ids = jQuery('#tbl_dtl').jqGrid('getDataIDs');
			for(var i=0;i < ids.length;i++){
				var cl = ids[i];
				del = "<i class='icon-trash red pointer actionIcon ' onclick=\"delRow('#tbl_dtl',"+cl+");\" ></i>"; 				
				jQuery('#tbl_dtl').jqGrid('setRowData',ids[i],{act:del});
			}
		},
	});	
}

