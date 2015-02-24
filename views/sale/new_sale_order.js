var products=[];
var lastsel;
var maxid=0;
jQuery(function($) {
	//客户
	$(".chosen-select").chosen(); 
	$(this).find('.chosen-container').each(function(){
		$(this).find('a:first-child').css('width' , '210px');
		$(this).find('.chosen-drop').css('width' , '210px');
		$(this).find('.chosen-search input').css('width' , '200px');
	});

	//明细
	loadDetail();
	
	//新增产品
	$('#add_btn').click(function(){
		$('#modal_products').modal({show:true});
		loadModalProducts();
		
		//jQuery("#grid_dtl").jqGrid('editGridRow',"new",{height:280,reloadAfterSubmit:false}); 
	});

	$('#product_filter').keyup(function(){
		doFilter(this.value);
	})

	//保存
	$('#save_btn').click(function(){
		if(newSaleOrderMst()){
			newSaleOrderDtl();
		}
	});
});

function newSaleOrderMst(){
	return true;
}

function newSaleOrderDtl(){
	return true;
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

function add_new(){
    $("#addBtn").bind("click", function() {  
            $("#jqGridId").jqGrid('addRow',{  
                rowID : "new_row",  
                initdata : {},  
                position :"first",  
                useDefValues : true,  
                useFormatter : true,  
                addRowParams : {extraparam:{  
                      
                }}  
            });  
            //当前新增id进入可编辑状态  
            $('#jqGridId').jqGrid('editRow','new_row',{  
                keys : true,        //这里按[enter]保存  
                url: s2web.appURL + "jq/save.action",  
                mtype : "POST",  
                restoreAfterError: true,  
                extraparam: {  
                },  
                oneditfunc: function(rowid){  
                    console.log(rowid);  
                },  
                succesfunc: function(response){  
                    alert("save success");  
                    return true;  
                },  
                errorfunc: function(rowid, res){  
                    console.log(rowid);  
                    console.log(res);  
                }  
            });  
          
    });   

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
				var datarow=$('#modal_tbl_products').getRowData(id);				
				$.each(products,function(key,value){
					if(id==this.id){
						flag=true;
						return false;
					}
				})
				
				if (!flag){					
					products.push(datarow);
					maxid++;
					var newid=maxid;//$("#grid_dtl").getGridParam("reccount")+1;					
					var su=$('#grid_dtl').addRowData(newid, datarow, "last");						
					if (su){
						$('#grid_dtl').jqGrid('editRow',newid);
					}
				}
				
			}
		},	
	});
}

function doFilter(str){
	var rows=$('#modal_tbl_products').jqGrid('getRowData');
	var trs=$('#modal_tbl_products').find('tr');
	$(rows).each(function(i,v){
		$(trs[i+1]).hide();
		$.each(v, function(key, value) { 
			var pos=value.indexOf(str);
		  	if (value.indexOf(str)>=0){
				$(trs[i+1]).show();
				return false;
			}
		});
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