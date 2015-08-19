var caption='入库产品明细  ';
var go_url="index.php#/views/outsource/os_in_list";
var to_loc=7;//默认自动进入待检验仓库id=7
var os_products_data;
$(document).ready(function(){
	setTitle();	
	loadSelect($('#loc'),'locations');
	loadSelect($('#os_unit'),'os_units');
	$('.chosen-select').chosen({
		no_results_text: "找不到对应选项!",
	});
	loadDtl();
	$('#os_unit').change(function(){
		$("#tbl_dtl").clearGridData();				
	})

	//验证,submit
	 $("#frm").validate({	 	
        submitHandler:function(form){    
        	saveOsIn();
        }    
    });	

	//设置默认仓库 暂时	
	$("#loc").val(to_loc);
	$("#loc").attr('disabled',true); 
})
function saveOsIn(){

	var para={'method':'insertOsInOrder'};
	var mst_data={'loc_id':$('#loc').val(),'os_unit':$("#os_unit").val()};
	para['mst_data']=mst_data;
	var dtl_data={};
	var trs=$("#tbl_dtl tr");
	for (var i=1;i<trs.length;i++){
		var qty=parseInt($('#'+trs[i].id+'_in_qty').val());
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
		colNames:['','代码','名称','规格', '加工总数','入库数量','库位'],
		colModel:[
			{name:'act',width:40},
			{name:'product_id',index:'product_id', width:60},
			{name:'name',index:'name', width:110},
			{name:'gg',index:'gg', width:110},
			{name:'qty',index:'qty', width:50, sortable:true,editable: false},
			{name:'in_qty',index:'in_qty', width:50, sortable:true,editable: true},
			{name:'bin',index:'bin', width:60,editable:true},
		], 
		caption: caption+"<i class='icon-plus-sign red actionIcon pointer tooltip-warning'"+
			" data-rel='tooltip' title='选择入库物品' data-placement='right' onclick=\"addProduct();\" ></i>",
		autowidth: true,
	});	
	$('[data-rel=tooltip]').tooltip();
}
function addProduct(){
	var para={'method':'getOsStocks','os_unit':$("#os_unit").val()};
	os_products_data=exeJson(para);
	openModalOsProducts(os_products_data,'#tbl_dtl','_in_qty');
	return false;
}	