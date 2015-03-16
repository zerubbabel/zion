var lastsel;
var edit_url="views/setting/data/products_edit.php";
//var products=[];
var product_id;
jQuery(function($) {
	setTitle();
	toProduct();
	//产品过滤
	$('#product_filter').keyup(function(){
		doFilter('grid-table',this.value);
	})
	$("#btn_back").click(function(){
		toProduct();
		return false;
	})
	//新增产品
	$('#add_btn').click(function(){
		$('#modal_products').modal({show:true});
		loadModalProducts();
		return false;
	});

	//产品过滤
	$('#modal_product_filter').keyup(function(){
		doFilter('modal_tbl_products',this.value);
	})

	loadSubgrid(0);
	loadRightSubgrid()

	//验证
	$("#sub_frm").validate({
		submitHandler:function(form){			
			if ($('#grid_subpart tr').length>1){
        		saveBom();	
        	}
        	else{
        		var result={'status':false,'msg':'请先添加子件！'};
        		showMsg(result);
        	}
		}
	})


	var grid_selector = "#grid-table";
	var pager_selector = "#grid-pager";
	var para={'method':'getProducts'};
	var grid_data=exeJson(para);
	jQuery(grid_selector).jqGrid({
		data: grid_data,
		datatype: "local",
		height: 400,
		colNames:['','操作','产品名称',],
		colModel:[	
			{name:'myaction',index:'',width:20,
				formatter:'actions', 
				formatoptions:{ 
					keys:true,	
					delbutton:false,
				}},	
			{name:'act',index:'act',width:15}, 	
			{name:'name',index:'name', width:90, editable: true} 
		], 

		viewrecords : true,
		rowNum:10,
		rowList:[10,20,30],
		pager : pager_selector,
		altRows: true,		
		multiselect: false,
        multiboxonly: true,
        onSelectRow:function(id){        	
        	jQuery('#right_subpart').jqGrid('setGridParam',{url:"views/setting/bom_data.php?id="+id,page:1})
			.trigger('reloadGrid');	
        },
        loadComplete : function() {
			var table = this;
			setTimeout(function(){
				updatePagerIcons(table);
				enableTooltips(table);
			}, 0);
		},
		gridComplete: function(){
			var ids = jQuery(grid_selector).jqGrid('getDataIDs');
			for(var i=0;i < ids.length;i++){
				var cl = ids[i];
				min = "<i class='icon-bell-alt actionIcon orange pointer tooltip-warning' data-rel='tooltip' title='设置最小库存'"+
					" data-placement='right' onclick=\"setMin('"+cl+"');\" ></i>"; 
				bom = "<i class='icon-cogs actionIcon  pointer tooltip-warning' data-rel='tooltip' title='设置物料清单'"+
					" data-placement='right' onclick=\"setBom('"+cl+"');\" ></i>";
				jQuery(grid_selector).jqGrid('setRowData',ids[i],{act:min+bom});
				$('[data-rel=tooltip]').tooltip();
			}
		},
		caption: "产品列表",
		autowidth: true,
		editurl:edit_url,
	});
	
	jQuery(grid_selector).jqGrid('navGrid',pager_selector,
		{ 	//navbar options
			add: true,
			addicon : 'icon-plus-sign purple',
			edit: false,
			del:false,
			search: false,
			refresh: false,
			view: false,
		},		
		{
			//new record form
			closeAfterAdd: true,
			recreateForm: true,
			reloadAfterSubmit:true,
			processData:"操作中...",
			viewPagerButtons: false,
			afterSubmit:function(result){						
				if (result&&jQuery.parseJSON(result.responseText).status) {
					jQuery(grid_selector).jqGrid().trigger('reloadGrid');
					return true;					
				}
				else{alert("操作失败！"); return false;} 			
			}
		}
	);
});
function toBom(){
	$("#tab_product").hide();
	$("#tab_bom").show();
}
function toProduct(){	
	$("#tab_bom").hide();
	$("#tab_product").show();
}
function setBom(id){
	product_id=id;
	toBom();
	var para={'method':'getProductById','id':id};	
	var product=exeJson(para);
	jQuery('#grid_subpart').jqGrid('setGridParam',{url:"views/setting/bom_data.php?id="+id,page:1});
	jQuery('#grid_subpart').jqGrid('setCaption',product['name']+' 物料清单:')
	.trigger('reloadGrid');	

}
function loadSubgrid(id){	
	jQuery("#grid_subpart").jqGrid({
		url:'views/setting/bom_data.php?id='+id,
		datatype: "json",
		height: 200,
		colNames:[' ','产品', '数量'],
		colModel:[
			{name:'act',index:'',width:20, sortable:false},						
			{name:'name',index:'name', width:90, sortable:true,editable: false},
			{name:'qty',index:'qty', width:120, sortable:true,editable: true,},			
		], 
		caption: '物料清单:',	
		gridComplete: function(){
			var ids = jQuery('#grid_subpart').jqGrid('getDataIDs');
			for(var i=0;i < ids.length;i++){
				var cl = ids[i];
				del = "<i class='icon-trash orange pointer ' onclick=\"delRow('"+cl+"');\" ></i>"; 
				jQuery('#grid_subpart').jqGrid('setRowData',ids[i],{act:del});
				//enter edit
				$('#grid_subpart').jqGrid('editRow',cl);
				//debugger
				var ele=$("#"+cl+"_qty");
				var width=ele.width();
				var td_width=ele.parent().width();
				ele.width(Math.round(td_width/2));
			}
		},
		autowidth: true,		
	});
}
function setMin(id){
	var para={'method':'getProductById','id':id};
	var product=exeJson(para);
	$('#modal').modal({show:true});
	$('#modal_title').text('设置最小库存: 产品 '+product['name']);
	$('#modal_body').empty();//清空
	var html="<form id='frm' class='form-inline'><div class='input-group'>"+
		"<input type='text' placeholder='输入最小库存' id='min_stock' name='min_stock'"+
		" class='form-control' /><span class='input-group-btn'>"+
		"<input type='button' class='btn btn-sm' id='btn_edit'  value='修改' />"+
		"<input type='submit' class='btn btn-success btn-sm' id='btn_save'  value='确定' />"+
		"</span></div></form><div id='error_container'></div>";		
	$('#modal_body').append(html);	
	$('#min_stock').val(product['min_stock']);
	viewMode();
	$('#btn_edit').click(function(){
		editMode();		
	})
	
	$("#frm").validate({	 	
		rules:{min_stock:{required:true,digits:true}},
		errorPlacement: function(error, element) {  
			var error_container=$('#error_container');
			error_container.empty();
		    error.appendTo(error_container);  
		},
        submitHandler:function(form){    
        	updateMinStock(id);
        	return false;
        }    
    });
}
function updateMinStock(id){
	var para={'method':'updateMinStock','id':id,'min_stock':$('#min_stock').val()};
	var result=exeJson(para);		
	viewMode();
	showMsg(result);
}
function viewMode(){
	$('#btn_edit').show();	
	$('#btn_save').hide();
	$('#min_stock').prop('disabled',true);
}

function editMode(){
	$('#btn_edit').hide();
	$("#btn_save").show();
	$('#min_stock').prop('disabled',false);
}

function delRow(id){
	jQuery("#grid_subpart").jqGrid('delRowData',id);
	return false;
}


function loadModalProducts(){
	jQuery("#modal_tbl_products").jqGrid({
		url:'ajax/get_products.php',
		datatype: "json",
		colNames:['产品代码', '产品名称'],
		colModel:[					
			{name:'id',index:'id'},
			{name:'name',index:'name'},			
		], 
		autowidth: true,	
		onSelectRow: function(id){			
			if(id && id!==lastsel){
				//产品添加到明细表中并且该行进入edit模式
				var flag=false;//产品是否已存在
				//var datarow=$('#modal_tbl_products').getRowData(id);
				if (id==product_id){flag=true};//防止子件与父件重复
				var trs=$('#grid_subpart tr');	
				for(var i=0;i<trs.length;i++){
					if (id==trs[i].id){
						flag=true;
						break;
					}
				}									
				if (!flag){						
					var newid=id;
					var datarow=$('#modal_tbl_products').getRowData(id);	
					var su=$('#grid_subpart').addRowData(newid, datarow, "last");	
									
					if (su){
						$('#grid_subpart').jqGrid('editRow',newid);
						var input_id=id+"_qty";
						var ele=$("#"+input_id);
						var width=ele.width();
						var td_width=ele.parent().width();
						ele.width(Math.round(td_width/2));	
						//var loc_id=$('#loc').val();						
						//var para={'method':'getStockById','loc_id':loc_id,'product_id':id};
						//var result=exeJson(para);
						//var stock_qty=result['qty']==null?0:parseInt(result['qty']);					
						var v_class={required:true,digits:true,min:0};
						addValidate(input_id,v_class);	
					}
				}				
			}
		},	
	});
}


function saveBom(){
	var para={'method':'saveBom','product_id':product_id};
	var dtl_data={};
	var trs=$("#grid_subpart tr");
	for (var i=1;i<trs.length;i++){
		dtl_data[i-1]={};		
		dtl_data[i-1]['sub_id']=trs[i].id;
		var qty=$('#'+trs[i].id+'_qty').val();
		dtl_data[i-1]['qty']=qty;
	}
	para['dtl_data']=dtl_data;
	var result=exeJson(para);
	showMsg(result);
	if(result['status']){
		toProduct();
	}
}

function loadRightSubgrid(){	
	jQuery("#right_subpart").jqGrid({
		url:'views/setting/bom_data.php',
		datatype: "json",
		height: 200,
		colNames:['产品', '数量'],
		colModel:[					
			{name:'name',index:'name', width:90, sortable:true,editable: false},
			{name:'qty',index:'qty', width:120, sortable:true,editable: true,},			
		], 
		caption: '物料清单:',
		autowidth: true,		
	});
}
