//执行insert,delete,update
function exeSql(optype,table,cols,datas){
	var ans;
	$.ajax({
		type:'post',
		url:'ajax/exe.php',		
		async:false,
		data:{'cols':cols,'table':table,'data':datas,'type':optype},
		success:function(data){
			if(data!=null){			
				ans=eval(data);
				return eval(data);
			}	
		},
		error:function(){
			ans=-1;
			return -1;
		}
	});
	return ans;
}
//获得json数据
function getJsonData(para){
	var ans;
	$.ajax({
		type:'get',
		dataType: 'json',//important
		url:'ajax/sale_data.php',
		async:false,
		data:{'para':para},
		success:function(data){
			if(data!=null){		
				ans=data;
				return data;
			}	
		},
		error:function(){
			ans=false;
			return false;
		}
	});
	return ans;
}
//验证显示错误信息及取消错误信息显示
function unShowError(ele){	
	var error_id='error_'+ele.attr('id');
	ele.insertAfter('#'+error_id);
	$('#'+error_id).remove();
}
function showError(ele,msg){
	var error_id='error_'+ele.attr('id');
	var msg_id='msg_'+ele.attr('id');
	if ($('#'+error_id).length==0){
		var html='<div class="form-group has-error" id="'+error_id+'">'+
			'<span class="block input-icon "></span>'+
			'<div class="help-block inline" id="'+msg_id+'">'+msg+'</div>'+
			'</div>';
		ele.wrap(html);
	}
	else{
		$("#"+msg_id).text(msg);
	}
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

/*
function get_custs(){
	//return "FE:FedEx;IN:InTime;TN:TNT;AR:ARAMEX";
	//动态生成select内容
	var str="";
	$.ajax({
		type:"get",
		async:false,
		url:"ajax/get_custs.php",
		success:function(data){
			if (data != null) {
	        var jsonobj=eval(data);	        
	        var length=jsonobj.length;
	        for(var i=0;i<length;i++){  
	            if(i!=length-1){
	            	str+=jsonobj[i].id+":"+jsonobj[i].cust_name+";";
	            }else{
	              	str+=jsonobj[i].id+":"+jsonobj[i].cust_name;
	            }
	         }   

	        }
		}
	});	
	return str;	
}

function get_products(){
	var str="";
	$.ajax({
		type:"get",
		async:false,
		url:"ajax/get_products.php",
		success:function(data){
			if (data != null) {
	        var jsonobj=eval(data);
	        
	        var length=jsonobj.length;
	        for(var i=0;i<length;i++){  
	            if(i!=length-1){
	            	str+=jsonobj[i].id+":"+jsonobj[i].name+";";
	            }else{
	              	str+=jsonobj[i].id+":"+jsonobj[i].name;
	            }
	         }   

	        }
		}
	});	
	return str;	
}
*/