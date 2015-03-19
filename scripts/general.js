//执行insert,delete,update
function exeSql(optype,table,cols,datas){
	var ans;
	showLoading();
	$.ajax({
		type:'post',
		url:'ajax/exe.php',		
		async:false,
		data:{'cols':cols,'table':table,'data':datas,'type':optype},
		success:function(data){
			if(data!=null){			
				ans=eval(data);
				closeLoading();
				return eval(data);
			}	
		},
		error:function(){
			ans=-1;
			closeLoading();
			return -1;
		}
	});
	return ans;
}
//获得json数据
function getJsonData(para){
	var ans;
	showLoading();
	$.ajax({
		type:'get',
		dataType: 'json',//important
		url:'ajax/sale_data.php',
		async:false,
		data:{'para':para},
		success:function(data){
			if(data!=null){		
				ans=data;
				closeLoading()
				return data;
			}	
		},
		error:function(){
			ans=false;		
			closeLoading();	
			return false;
		}
	});	
	closeLoading();
	return ans;
}
//执行操作并返回json数据
function exeJson(para){
	var ans;
	showLoading();
	$.ajax({
		type:'post',
		dataType: 'json',//important
		url:'ajax/exe_json.php',
		async:false,
		data:{'para':para},
		success:function(data){		
			if(data!=null){		
				ans=data;
				closeLoading();
				return data;
			}	
		},
		error:function(){
			ans=false;
			closeLoading();
			return false;
		}
	});
	closeLoading();
	return ans;
}

function loadLoc(selector){
	var para={'method':'getLoc'};
	var data=getJsonData(para);
	var jsonobj=eval(data);		        
    var length=jsonobj.length;		      
    for(var i=0;i<length;i++){  		       
    	selector.append("<option value='"+jsonobj[i].id+"' >"+jsonobj[i].name+"</option>");
    }    
}

function loadCust(selector){
	var para={'method':'getCust'};
	var data=getJsonData(para);
	var jsonobj=eval(data);		        
    var length=jsonobj.length;		      
    for(var i=0;i<length;i++){  		       
    	selector.append("<option value='"+jsonobj[i].id+"' >"+jsonobj[i].name+"</option>");
    }    
}

//通用select内容loader
function loadSelect(selector,table){	
	var para={'method':'getSelect','table':table};
	var data=exeJson(para);
	
	var jsonobj=eval(data);		        
    var length=jsonobj.length;		      
    for(var i=0;i<length;i++){  		       
    	selector.append("<option value='"+jsonobj[i].id+"' >"+jsonobj[i].name+"</option>");
    }
}

//显示jQuery 遮罩层
function showLoading() {
    var bh = $("body").height();
    var bw = $("body").width();
    $("#fullbg").css({
        height:bh,
        width:bw,
        display:"block"
    });
	
    $("#loading").show();
}
//关闭jQuery 遮罩
function closeLoading() {
    $("#fullbg,#loading").hide();
}

//jqgrid
//replace icons with FontAwesome icons like above
function updatePagerIcons(table) {
	var replacement = 
	{
		'ui-icon-seek-first' : 'icon-double-angle-left bigger-140',
		'ui-icon-seek-prev' : 'icon-angle-left bigger-140',
		'ui-icon-seek-next' : 'icon-angle-right bigger-140',
		'ui-icon-seek-end' : 'icon-double-angle-right bigger-140'
	};
	$('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function(){
		var icon = $(this);
		var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
		
		if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
	})
}	

function enableTooltips(table) {
	$('.navtable .ui-pg-button').tooltip({container:'body'});
	$(table).find('.ui-pg-div').tooltip({container:'body'});
}

//计算订单剩余数量
function calRealData(order_data,out_data){
	for (var i =0; i<order_data.length; i++) {
		var product_id=order_data[i]['id'];
		var order_qty=parseInt(order_data[i]['qty']);
		for(var j=0;j<out_data.length;j++){
			var id=out_data[j]['id'];
			var out_qty=parseInt(out_data[j]['qty']);
			if (product_id==id){
				order_data[i]['qty']=order_qty-out_qty;
			}
		}
	}
	return order_data;
}

function showMsg(result){
	var $path_assets = "assets";
	var class_name;
	if(result['status']){
		class_name='gritter-success';
	}else{
		class_name='gritter-error';
	}
	$.gritter.add({
		title: '提醒:',
		text: result['msg'],
		image: $path_assets+'/avatars/avatar1.png',
		class_name: class_name
	});
}

function addValidate(input_id,v_class){
	//验证规则											
	var ele=$("#"+input_id);	
	ele.attr('name',input_id);				
	ele.rules("add",v_class);	
}

function collapse(ele,id){
	var class_name=$(ele).attr('class');
	var str1=class_name.substring(0,13);
	var str2=class_name.substring(13);
	var new_str;
	if (str2=='up'){
		new_str='down';
		$($(id+' .widget-body')[0]).hide()
	}else{
		new_str='up';
		$($(id+' .widget-body')[0]).show()
	}
	var new_class_name=str1+new_str;
	$(ele).attr('class',new_class_name);
}


function doFilter(grid,str){
	var rows=$('#'+grid).jqGrid('getRowData');
	var trs=$('#'+grid).find('tr');
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
function loadModal(title,data,dst_grid,input){	
	//$('#modal_body').empty();//清空

	$('#modal_title').text(title);	
	/*
	var grid_html='<table id="modal_grid"></table>';
	$("#div_grid").empty();
	$("#div_grid").append(grid_html);*/

	$('#modal_filter').keyup(function(){
		doFilter('modal_grid',this.value);
	})	
	
	$('#modal').modal({show:true});
	loadModalGrid(data,dst_grid,input);
	
}

function loadModalGrid(data,dst_grid,input){
	jQuery("#modal_grid").jqGrid({
		data:data,
		datatype: "local",
		colNames:['产品代码', '产品名称'],
		colModel:[					
			{name:'id',index:'id'},
			{name:'name',index:'name'},			
		], 
		height:300,
		rowNum:10,
		rowList:[10,20,30],
		autowidth: true,	
		onSelectRow: function(id){			
			if(id){
				//产品添加到明细表中并且该行进入edit模式
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
						var input_id=id+input;
						var ele=$("#"+input_id);
						ele.attr('name',input_id);
						var width=ele.width();
						var td_width=ele.parent().width();
						ele.width(Math.round(td_width/2));						
						var v_class={required:true,digits:true};
						addValidate(input_id,v_class);	
					}
				}					
			}
		},	
	});
}

function openProducts(){
	$('#modal_body').empty();//清空				
	$('#modal_title').text('选择产品');

	var para={'method':'getProducts'};
	var products=exeJson(para);	
	var html='<div class="row">'+
	'<div class="col-xs-12">筛选:'+
	'<input type="text" id="product_filter" placeholder="产品描述" />'+
	'</div><div class="col-xs-12">'+					
	'<table id="modal_tbl_products" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">'+
	'</table></div></div>';		
	$('#modal_body').append(html);	
	$('#product_filter').keyup(function(){
		doFilter('modal_tbl_products',this.value);
	})	
	loadModalProducts(products);
	$('#modal').modal({show:true});
}

/*
function loadModalProducts(products){
	jQuery("#modal_tbl_products").jqGrid({
		data:products,
		datatype: "local",
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
					var newid=id;
					var su=$('#grid_dtl').addRowData(newid, datarow, "last");						
					if (su){
						$('#grid_dtl').jqGrid('editRow',newid);
						var input_id=id+"_qty";
						var ele=$("#"+input_id);
						var width=ele.width();
						var td_width=ele.parent().width();
						ele.width(Math.round(td_width/2));						
						var v_class={required:true,digits:true};
						addValidate(input_id,v_class);	
					}
				}				
			}
		},	
	});
}
*/
function get_status(){
	//return "FE:FedEx;IN:InTime;TN:TNT;AR:ARAMEX";
	//动态生成select内容
	var str="";
	var para={'method':'getStatus'};
	var data=exeJson(para);
    var jsonobj=eval(data);    
    var length=jsonobj.length;
    for(var i=0;i<length;i++){  
        if(i!=length-1){
        	str+=jsonobj[i].id+":"+jsonobj[i].name+";";
        }else{
          	str+=jsonobj[i].id+":"+jsonobj[i].name;
        }
     }   
	return str;	
}

function delRow(grid,id){
	jQuery(grid).jqGrid('delRowData',id);
	return false;
}
function getGroups(){
	//return "FE:FedEx;IN:InTime;TN:TNT;AR:ARAMEX";
	var str="";
	var para={'method':'getGroups'};
	var data=exeJson(para);
    var jsonobj=eval(data);    
    var length=jsonobj.length;
    for(var i=0;i<length;i++){  
        if(i!=length-1){
        	str+=jsonobj[i].id+":"+jsonobj[i].name+";";
        }else{
          	str+=jsonobj[i].id+":"+jsonobj[i].name;
        }
     }   
	return str;	
}

//通用 产品选择
//html:modal_products
//data:all products data
//dst_grid:'#grid_id' 目标grid
//input:目标grid中待验证的input id 后半部分
function openModalProducts(data,dst_grid,input){	
	$('#modal_title').text('选择产品');	
	$('#modal').modal({show:true});
	loadModalProducts(data,dst_grid,input);
	//产品过滤
	var grid_selector='#modal_grid';
	$('#modal_filter').keyup(function(){
		var keyword=this.value;
		grid_data=[];
		for (var i=0;i<data.length;i++){
			var pos=data[i]['name'].indexOf(keyword);
		  	if (pos>=0){
				grid_data.push(data[i]);
			}
		}
		$(grid_selector).clearGridData();
		$(grid_selector).setGridParam({data: grid_data});
		$(grid_selector).trigger('reloadGrid');
	})
}
function loadModalProducts(data,dst_grid,input){
	jQuery("#modal_grid").jqGrid({
		data:data,
		datatype: "local",
		colNames:['产品代码', '产品名称'],
		colModel:[					
			{name:'id',index:'id'},
			{name:'name',index:'name'},			
		], 
		height:jqgrid_height,
		rowNum:jqgrid_row_num,
		//rowList:[10,20,30],
		width:500,
		//autowidth: true,	
		pager : '#modal_pager',
		viewrecords : true,
		loadComplete : function() {
			var table = this;
			setTimeout(function(){
				updatePagerIcons(table);
				enableTooltips(table);
			}, 0);
		},
		onSelectRow: function(id){			
			if(id){
				//产品添加到明细表中并且该行进入edit模式
				var flag=false;//产品是否已存在
				var trs=$(dst_grid+' tr');	
				for(var i=1;i<trs.length;i++){
					if (id==trs[i].id){
						flag=true;
						break;
					}
				}									
				if (!flag){						
					var newid=id;
					var datarow=$('#modal_grid').getRowData(id);	
					var su=$(dst_grid).addRowData(newid, datarow, "last");										
					if (su){
						$(dst_grid).jqGrid('editRow',newid);
						var input_id=id+input;
						var ele=$("#"+input_id);
						ele.attr('name',input_id);
						var width=ele.width();
						var td_width=ele.parent().width();
						ele.width(Math.round(td_width/2));						
						var v_class={required:true,digits:true};
						addValidate(input_id,v_class);	
					}
				}					
			}
		},	
	});
}

function openModalOsProducts(data,dst_grid,input){	
	$('#modal_title').text('选择产品');	
	$('#modal').modal({show:true});
	loadModalOsProducts(data,dst_grid,input);
	var grid_selector='#modal_grid';
	$(grid_selector).clearGridData();
	$(grid_selector).setGridParam({data:data});
	$(grid_selector).trigger('reloadGrid');
	//产品过滤
	var grid_selector='#modal_grid';
	$('#modal_filter').keyup(function(){
		var keyword=this.value;
		grid_data=[];
		for (var i=0;i<data.length;i++){
			var pos=data[i]['name'].indexOf(keyword);
		  	if (pos>=0){
				grid_data.push(data[i]);
			}
		}
		$(grid_selector).clearGridData();
		$(grid_selector).setGridParam({data: grid_data});
		$(grid_selector).trigger('reloadGrid');
	})
}
function loadModalOsProducts(data,dst_grid,input){
	jQuery("#modal_grid").jqGrid({
		data:data,
		datatype: "local",
		colNames:['产品名称','数量'],
		colModel:[					
			{name:'name',index:'name'},			
			{name:'qty',index:'qty'},	
		], 
		height:jqgrid_height,
		rowNum:jqgrid_row_num,
		//rowList:[10,20,30],
		//autowidth: true,	
		width:500,
		onSelectRow: function(id){		
			if(id){
				var flag=false;//产品是否已存在
				var trs=$(dst_grid+' tr');	
				for(var i=1;i<trs.length;i++){
					if (id==trs[i].id){
						flag=true;
						break;
					}
				}									
				if (!flag){						
					var newid=id;
					var datarow=$('#modal_grid').getRowData(id);	
					var su=$(dst_grid).addRowData(newid, datarow, "last");								
					if (su){
						$(dst_grid).jqGrid('editRow',newid);
						del = "<i class='icon-trash red pointer actionIcon ' onclick=\"delRow('"+dst_grid+"',"+newid+");\" ></i>"; 				
						jQuery(dst_grid).jqGrid('setRowData',newid,{act:del});
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