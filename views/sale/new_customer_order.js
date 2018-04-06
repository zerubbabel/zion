var products=[];
var lastsel;
var go_url="index.php#/views/sale/customer_orders";
var products_data;
jQuery(function($) {
	setTitle();
	//客户
	loadCust($('#cust'));

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
			var trs=$("#grid_dtl tr");
			if (trs.length>1){				
				var mst_id=newSaleOrderMst();	
				if(mst_id>0){			
					newSaleOrderDtl(mst_id);
					insertCustomerProduct();
				}
			}
			else{
				var result={'status':false,'msg':'请选择订单产品！'};
				showMsg(result);
			}
			return false;
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
function insertCustomerProduct(){
	var cust_id=$('#cust').val();
	

}
function newSaleOrderMst(){
	//选择仓库
	var cust_id=$('#cust').val();
	//var deliveryday=$('#deliveryday').val();
	//var order_no=$('#order_no').val();
	var order_no="";
	var deliveryday="";
	var datas=[];
	datas.push(cust_id);
	datas.push(deliveryday);
	datas.push(order_no);
	var cols=['cust_id','deliveryday','order_no'];
	var table='sale_order_mst';	
	return exeSql('insertMst',table,cols,datas);
}

function newSaleOrderDtl(mst_id){
	var optype='insertDtl';
	var table='sale_order_dtl';
	var cols=['mst_id','product_id','qty','jh','box','memo'];
	var trs=$("#grid_dtl tr");
	for (var i=1;i<trs.length;i++){
		var datas=[mst_id];
		var product_id=trs[i].id;
		var qty=$('#'+product_id+'_qty').val();
		var jh=$('#'+product_id+'_jh').val();
		var box=$('#'+product_id+'_box').val();
		var memo=$('#'+product_id+'_memo').val();
		datas.push(product_id);
		datas.push(qty);
		datas.push(jh);
		datas.push(box);
		datas.push(memo);
		if (!(exeSql(optype,table,cols,datas)>0)){
			return false;
		}
	}
	var result={'status':true,'msg':'操作成功！'};
	showMsg(result);
	window.location.href=go_url;
	return true;
}

function loadDetail(){
	jQuery("#grid_dtl").jqGrid({
		data: products,
		datatype: "local",
		height: 200,
		colNames:[' ','代码','名称','规格', '数量', '交货日期', '装箱', '备注','id'],
		colModel:[
			{name:'myac',index:'', fixed:true, width:50, sortable:false, resize:false,
				formatter:'actions', 
				formatoptions:{ 
					keys:true,		
					editbutton:false,	
					delOptions:{onclickSubmit:delProduct},	
				}
			},						
			{name:'product_id',index:'product_id', width:40,},
			{name:'name',index:'name', width:90,},
			{name:'gg',index:'gg', width:90,},
			{name:'qty',index:'qty', width:60, sortable:true,editable: true,
				editrules:{required:true,number:true}
			},
			{name:'jh',index:'jh', width:70, sortable:true,editable: true,
				editoptions:{
                dataInit:function(e){
                    $(e).datepicker({
                        language:"zh-CN",//语言
                        autoclose: true,//自动关闭
                        todayBtn: "linked",//
                        format: "yyyy-mm-dd"//时间显示格式
                    });
                    $(this).click(function(e){//选中时间后隐藏
                        $(e).parent().datepicker('hide');
                    });
                }
            }
			},
			{name:'box',index:'box', width:60, sortable:true,editable: true,
				editrules:{required:true,number:true}
			},
			{name:'memo',index:'memo', width:140, sortable:true,editable: true,
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
