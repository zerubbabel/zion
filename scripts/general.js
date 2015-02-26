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