var products=[];
var lastsel;
var go_url="index.php#/views/outsource/os_order_manage";
var products_data;
jQuery(function($) {
	setTitle();
	//外协单位
	loadSelect($('#os_unit'),'os_units');
	$( "#deliveryday" ).datepicker({
		format: 'yyyy-mm-dd',
		language: 'zh-CN',
		todayHighlight: true,
	});
	//明细
	loadDetail();
	
	//验证
	$("#frm").validate({
		rules:{
			'deliveryday':{required:true,}
		},
		submitHandler:function(form){			
			if ($('#grid_dtl tr').length>1){
        		saveOsOrder();	
        	}
        	else{
        		var result={'status':false,'msg':'请先添加需要外协加工的物品！'};
        		showMsg(result);
        	}
		}
	})
	//新增产品
	var para={'method':'getProducts'};
	products_data=exeJson(para);
	$('#add_btn').click(function(){
		openModalProducts(products_data,'#grid_dtl','_qty');
		return false;
	});
});

function saveOsOrder(){
	var para={'method':'insertOsOrder'};
	var mst_data={'os_unit':$('#os_unit').val(),'deliveryday':$("#deliveryday").val()};
	para['mst_data']=mst_data;
	var dtl_data={};
	var trs=$("#grid_dtl tr");
	for (var i=1;i<trs.length;i++){
		dtl_data[i-1]={};		
		dtl_data[i-1]['product_id']=trs[i].id;
		var qty=$('#'+trs[i].id+'_qty').val();
		dtl_data[i-1]['qty']=qty;
	}
	para['dtl_data']=dtl_data;
	var result=exeJson(para);
	showMsg(result);
	if(result['status']){
		//跳转到外协申请单列表
		window.location.href=go_url;
	}
}

function loadDetail(){
	jQuery("#grid_dtl").jqGrid({
		data: products,
		datatype: "local",
		height: 200,
		colNames:[' ','产品', '数量','id'],
		colModel:[
			{name:'myac',index:'', fixed:true, sortable:false, resize:false,
				formatter:'actions', 
				formatoptions:{ 
					keys:true,		
					editbutton:false,	
					delOptions:{onclickSubmit:delProduct},	
				}
			},						
			{name:'name',index:'name', width:90, sortable:true,editable: false},
			{name:'qty',index:'qty', width:90, sortable:true,editable: true,
				editrules:{required:true,number:true}
			},
			{name:'id',index:'id', width:90,editable: false,hidden:true},
		], 
		caption:'产品明细:',	
		editurl: 'empty.php',//"views/sale/save2.php",
		autowidth: true,		
	});
}

function delProduct(e){
	var delrow=$('#grid_dtl').jqGrid('getGridParam','selrow');
	var i=0;
	$.each(products,function(key,value){		
		if(delrow==this.id){
			products.splice(i,1);
			return false;
		}
		i++;
	})
}
