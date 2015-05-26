//生产入库是否跟踪生产领料？
var caption='入库产品明细  ';
var go_url="#/";
var products_data;
$(document).ready(function(){
	setTitle();	
	loadSelect($('#loc'),'locations');
	loadSelect($('#workcenter'),'workcenters');
	loadDtl();

	//验证,submit
	 $("#frm").validate({	 	
        submitHandler:function(form){    
        	var trs=$("#tbl_dtl tr");
			if (trs.length>1){				
				saveWorkIn();
			}
			else{
				var result={'status':false,'msg':'请选择待入库的产品！'};
				showMsg(result);
			}
			return false; 

        	
        }    
    });	
})
function saveWorkIn(){
	var para={'method':'insertWorkInOrder'};
	var mst_data={'loc_id':$('#loc').val(),'workcenter_id':$("#workcenter").val()};
	para['mst_data']=mst_data;
	var dtl_data={};
	var trs=$("#tbl_dtl tr");
	for (var i=1;i<trs.length;i++){
		var qty=parseInt($('#'+trs[i].id+'_qty').val());
		if (qty>0){	//去掉无用记录
			dtl_data[i-1]={};		
			dtl_data[i-1]['product_id']=trs[i].id;			
			dtl_data[i-1]['qty']=qty;
		}		
	}
	para['dtl_data']=dtl_data;
	var result=exeJson(para);
	showMsg(result);
	if(result['status']){
		//跳转到列表
		window.location.href=go_url;
	}
}


function loadDtl(){
	var dtl_data=[];
	$("#tbl_dtl").jqGrid({
		data: dtl_data,
		datatype: "local",
		height: 300,
		colNames:['','产品','入库数量'],
		colModel:[
			{name:'act',width:40},
			{name:'name',index:'name', width:90, sortable:true,editable: false},
			{name:'qty',index:'qty', width:90, sortable:true,editable: true},
		], 
		caption: caption+"<i class='icon-plus-sign red actionIcon pointer tooltip-warning'"+
			" data-rel='tooltip' title='选择入库物品' data-placement='right' onclick=\"addProduct();\" ></i>",
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

function addProduct(){
	var para={'method':'getProducts'};
	products_data=exeJson(para);
	//var title='选择产品';
	var dst_grid='#tbl_dtl';
	var input='_qty';
	openModalProducts(products_data,dst_grid,input);
	//loadModal(title,data,dst_grid,input)
}
