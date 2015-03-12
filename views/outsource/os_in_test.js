var go_url="#/";
var select_url="index.php#/views/outsource/os_in_list";
var from_loc=7;
var to_loc=2;

$(document).ready(function(){
	setTitle();	

	loadSelect($('#loc'),'locations');

	//验证,submit
	 $("#frm").validate({	 	
        submitHandler:function(form){    
        	saveOsTest();
        }    
    });

	if(select_obj['os_in_id']){
		loadMst(select_obj['os_in_id']);		
		loadDtl(select_obj['os_in_id']);
		toTabOut();
	}else{
		toTabSelect();	
	}
	
	$("#btn_select").click(function(){
		window.location.href=select_url;
	});
	$("#btn_reselect").click(function(){
		window.location.href=select_url;
	});
	//设置默认仓库
	$("#loc").val(to_loc);
	$("#loc").attr('disabled',true);
	var os_unit;

})
function saveOsTest(){
	//总数必须正好等于合格+报废+退回+丢失

	var para={'method':'insertOsTest'};
	var mst_data={'os_in_mst_id':select_obj['os_in_id'],'loc_id':$('#loc').val(),'os_unit':os_unit};
	para['mst_data']=mst_data;
	var dtl_data={};
	var trs=$("#tbl_dtl tr");

	for (var i=1;i<trs.length;i++){
		var total_qty=parseInt($($(trs[i]).find('td')[1]).text());
		var good_qty=parseInt($('#'+trs[i].id+'_good_qty').val());
		var bad_qty=parseInt($('#'+trs[i].id+'_bad_qty').val());
		var back_qty=parseInt($('#'+trs[i].id+'_back_qty').val());
		var lost_qty=parseInt($('#'+trs[i].id+'_lost_qty').val());
		var qty=good_qty+back_qty+bad_qty+lost_qty;
		//debugger
		if (total_qty!=qty){
			var result={status:false,msg:'第'+i+'行:合格+报废+退回+丢失必须等于总数!'};
			showMsg(result);
			return false;
		}		
		dtl_data[i-1]={};		
		dtl_data[i-1]['product_id']=trs[i].id;	
		dtl_data[i-1]['qty']=total_qty;			
		dtl_data[i-1]['good_qty']=good_qty;	
		dtl_data[i-1]['bad_qty']=bad_qty;
		dtl_data[i-1]['back_qty']=back_qty;		
		dtl_data[i-1]['lost_qty']=lost_qty;	
	}
	para['dtl_data']=dtl_data;
	var result=exeJson(para);	
	showMsg(result);
	if(result['status']){
		//跳转到列表
		select_obj['os_in_id']=null;
		window.location.href=go_url;
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

function loadMst(id){
	var para={'method':'getOsInMstById','id':id};
	mst_data=exeJson(para);

	$("#os_unit").text("加工单位:"+mst_data[0].os_unit_name);
	//$("#loc").text("仓库:"+mst_data[0].loc_name);
	os_unit=mst_data[0].os_unit;
}

function loadDtl(id){
	var para={'method':'getOsInDtlById','id':id};
	dtl_data=exeJson(para);	
		
	$("#tbl_dtl").jqGrid({
		data: dtl_data,
		datatype: "local",
		height: 300,
		colNames:['产品', '入库总数','合格数','报废数','退回数','丢失数'],
		colModel:[
			{name:'product_name',index:'product_name', width:120, sortable:true,editable: false},
			{name:'qty',index:'qty', width:50, sortable:true,editable: false},
			{name:'good_qty',index:'good_qty', width:90, sortable:true,editable: true},
			{name:'bad_qty',index:'bad_qty', width:90, sortable:true,editable: true},
			{name:'back_qty',index:'back_qty', width:90, sortable:true,editable: true},			
			{name:'lost_qty',index:'lost_qty', width:90, sortable:true,editable: true},
		], 
		caption: "产品明细",
		autowidth: true,
	});	
	//编辑模式
	var validate_rule={};
	$.each(dtl_data,function(){
		$('#tbl_dtl').jqGrid('editRow',this.id);
		var id=this.id;
		var input_id=id+"_good_qty";
					
		var v_class={required:true,digits:true,range:[0,parseInt(this.qty)]};
		addValidate(input_id,v_class);	
		
		var input_id=id+"_bad_qty";					
		var v_class={required:true,digits:true,range:[0,parseInt(this.qty)]};
		addValidate(input_id,v_class);	
		var input_id=id+"_back_qty";					
		var v_class={required:true,digits:true,range:[0,parseInt(this.qty)]};
		addValidate(input_id,v_class);
		var input_id=id+"_lost_qty";					
		var v_class={required:true,digits:true,range:[0,parseInt(this.qty)]};
		addValidate(input_id,v_class);

	});	
}

