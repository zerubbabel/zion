var go_url="index.php#/views/work/work_draw_manage";
var products_data;
$(document).ready(function(){
	setTitle();

	loadSelect($('#workcenter'),'workcenters');

	//验证,submit
	 $("#frm").validate({	 	
        submitHandler:function(form){   
        	var trs=$("#subpart_dtl tr");
			if (trs.length>1){				
				saveWorkDraw();
			}
			else{
				var result={'status':false,'msg':'请选择待领取的产品！'};
				showMsg(result);
			}
			return false;        	
        }    
    });
	loadSubpart();
	
})
function saveWorkDraw(){
	var para={'method':'insertWorkDraw'};
	var mst_data={'workcenter_id':$('#workcenter').val()};
	para['mst_data']=mst_data;
	var dtl_data={};
	var trs=$("#subpart_dtl tr");
	for (var i=1;i<trs.length;i++){
		var qty=$('#'+trs[i].id+'_qty').val();
		if (qty>0){
			dtl_data[i-1]={};		
			dtl_data[i-1]['product_id']=trs[i].id;			
			dtl_data[i-1]['qty']=qty;
		}		
	}
	para['dtl_data']=dtl_data;
	
	var result=exeJson(para);
	showMsg(result);
	if(result['status']){
		window.location.href=go_url;
	}
}


function loadSubpart(){
	var data;
	$("#subpart_dtl").jqGrid({
		data: data,
		datatype: "local",
		height: 300,
		colNames:['','产品', '数量'],
		colModel:[
			{name:'act',index:'',width:30},
			{name:'name',index:'name', width:90, sortable:true,editable: false},			
			{name:'qty',index:'qty', width:90, sortable:true,editable: true},
		], 
		caption: "领料产品明细  "+"<i class='icon-plus-sign red actionIcon pointer tooltip-warning' data-rel='tooltip' title='添加产品'"+
					" data-placement='right' onclick=\"addPart();\" ></i>",
		autowidth: true,
		gridComplete: function(){
			$('[data-rel=tooltip]').tooltip();
			var ids = jQuery('#subpart_dtl').jqGrid('getDataIDs');
			for(var i=0;i < ids.length;i++){
				var cl = ids[i];
				del = "<i class='icon-trash orange pointer actionIcon ' onclick=\"delRow('#subpart_dtl',"+cl+");\" ></i>"; 				
				jQuery('#subpart_dtl').jqGrid('setRowData',ids[i],{act:del});
				//enter edit
				$('#subpart_dtl').jqGrid('editRow',cl);
				var ele=$("#"+cl+"_qty");
				var width=ele.width();
				var td_width=ele.parent().width();
				ele.width(Math.round(td_width/2));
				var input_id=cl+"_qty";								
				var v_class={required:true,digits:true,min:0};
				addValidate(input_id,v_class);
			}
		},
	});		
}

function addPart(){
	var para={'method':'getProducts'};
	products_data=exeJson(para);
	openModalProducts(products_data,'#subpart_dtl','_qty');
	//loadModal('选择领料物品',data,'subpart_dtl','_qty');
}



