var products=[];
var lastsel;
//var validate_rule={};

jQuery(function($) {
	setTitle();	
	$("#btn_reset").click(function(){
		resetAll();
	})
	//验证
	$("#frm").validate({
		rules:{
			old_password:{required:true},
			new_password:{required:true},
			new_password2:{required:true,equalTo:new_password},
			
		},
        submitHandler:function(form){
    		changePassword();       	
        }    
    });		


});

function changePassword(){
	var para={'method':'changePassword'};
	var old_password=$("#old_password").val();
	var new_password=$("#new_password").val();
	para['old_password']=old_password;
	para['new_password']=new_password;	
	var result=exeJson(para);	
	if(result['status']){
		resetAll();
	}	
	showMsg(result);
}

function resetAll(){
	$("#old_password").val("");
	$("#new_password").val("");
	$("#new_password2").val("");
}
