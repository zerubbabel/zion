var mst_data;
var dtl_data;
var go_url="#/";
var os_unit;
var caption='外协出库明细：';
$(document).ready(function(){
	setTitle();	
	loadSelect($('#loc'),'locations');
	loadSelect($('#os_unit'),'os_units');
	loadDtl();
	//验证,submit
	 $("#frm").validate({	 	
        submitHandler:function(form){            	
        	var trs=$("#tbl_dtl tr");
			if (trs.length>1){				
				saveOsOut();
			}
			else{
				var result={'status':false,'msg':'请选择待入库的产品！'};
				showMsg(result);
			}
			return false;  
        }    
    });	
	
	
})
function saveOsOut(){
	//选择仓库
	var loc_id=$('#loc').val();
	if (loc_id==0){
		var result={'status':false,'msg':'请选择出库仓库'};
		showMsg(result);
		return false;
	}
	var os_unit=$('#os_unit').val();
	if (os_unit==0){
		var result={'status':false,'msg':'请选择外协单位'};
		showMsg(result);
		return false;
	}

	var para={'method':'insertOsOutOrder'};
	var mst_data={'os_order_mst_id':null,
		'loc_id':$('#loc').val(),'os_unit':os_unit};
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
		var bin_qty=getProductBinQty(bin_id,product_id);	
		var qty=parseInt($('#'+trs[i].id+'_qty').val());
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
			dtl_data[i-1]['product_id']=trs[i].id;
			dtl_data[i-1]['qty']=qty;	
			dtl_data[i-1]['bin_id']=bin_id;
		}	
	}
	para['dtl_data']=dtl_data;
	var result=exeJson(para);
	
	showMsg(result);
	if(result['status']){
		//跳转到列表
		//window.location.href=go_url;
	}
}


function loadDtl(id){

	$("#tbl_dtl").jqGrid({
		datatype: "local",
		height: 300,
		colNames:['','代码', '名称', '规格', '数量','库位'],
		colModel:[
			{name:'act',index:'act',width:60},
			{name:'product_id',index:'product_id', width:70},
			{name:'name',index:'name', width:110},
			{name:'gg',index:'gg', width:110},
			{name:'qty',index:'qty', width:60, sortable:true,editable: true},			
			{name:'bin',index:'bin', width:60, editable: true},
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

