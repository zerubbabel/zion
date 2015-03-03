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
	//debugger
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
		var product_id=order_data[i]['product_id'];
		var order_qty=parseInt(order_data[i]['qty']);
		for(var j=0;j<out_data.length;j++){
			var id=out_data[j]['product_id'];
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
