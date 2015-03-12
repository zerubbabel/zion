var caption='入库产品明细  ';
var go_url="index.php#/views/outsource/os_in_list";
var data_url='views/outsource/data/os_stocks_data.php?os_unit=';
$(document).ready(function(){
	setTitle();	
	loadSelect($('#loc'),'locations');
	loadSelect($('#os_unit'),'os_units');
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
		colNames:['','产品', '加工总数','入库数量'],
		colModel:[
			{name:'act',width:40},
			{name:'product_name',index:'product_name', width:90, sortable:true,editable: false},
			{name:'qty',index:'qty', width:90, sortable:true,editable: false},
			{name:'in_qty',index:'in_qty', width:90, sortable:true,editable: true},
		], 
		caption: caption+"<i class='icon-plus-sign red actionIcon pointer tooltip-warning'"+
			" data-rel='tooltip' title='选择入库物品' data-placement='right' onclick=\"addProduct();\" ></i>",
		autowidth: true,
	});	
	$('[data-rel=tooltip]').tooltip();
}

function addProduct(){
	//var para={'method':'getOsStocks','os_unit':$("#os_unit").val()};
	//var data=exeJson(para);
	$('#modal_title').text('选择入库物品');		
	$('#modal_filter').keyup(function(){
		doFilter('modal_grid',this.value);
	});	
	$('#modal').modal({show:true});
	loadModalGrid('tbl_dtl','_in_qty');
	jQuery('#modal_grid').jqGrid('setGridParam',{url:data_url+$('#os_unit').val(),page:1})
	.trigger('reloadGrid');	
}

function loadModalGrid(dst_grid,input){
	jQuery("#modal_grid").jqGrid({
		url:data_url,
		datatype: "json",
		colNames:['产品名称','数量'],
		colModel:[					
			{name:'product_name',index:'product_name'},			
			{name:'qty',index:'qty'},	
		], 
		height:300,
		rowNum:10,
		rowList:[10,20,30],
		autowidth: true,	
		onSelectRow: function(id){		
			if(id){
				var flag=false;//产品是否已存在
				var trs=$('#'+dst_grid+' tr');	
				for(var i=1;i<trs.length;i++){
					if (id==trs[i].id){
						flag=true;
						break;
					}
				}									
				if (!flag){						
					var newid=id;
					var datarow=$('#modal_grid').getRowData(id);	
					var su=$('#'+dst_grid).addRowData(newid, datarow, "last");								
					if (su){
						$('#'+dst_grid).jqGrid('editRow',newid);
						del = "<i class='icon-trash orange pointer actionIcon ' onclick=\"delRow('"+dst_grid+"',"+newid+");\" ></i>"; 				
						jQuery('#'+dst_grid).jqGrid('setRowData',newid,{act:del});
						var input_id=id+input;
						var ele=$("#"+input_id);
						ele.attr('name',input_id);
						var width=ele.width();
						var td_width=ele.parent().width();
						ele.width(Math.round(td_width/2));						
						var v_class={required:true,digits:true,range:[0,datarow['qty']]};
						addValidate(input_id,v_class);	
					}
				}					
			}
		},	
	});
}