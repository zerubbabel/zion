var products=[];
var lastsel;
//var validate_rule={};

jQuery(function($) {
	var html='<div class="col-xs-12 col-sm-12 widget-container-span ui-sortable">'+
	'<div class="widget-box">'+
		'<div class="widget-header header-color-blue">'+
			'<h5 class="header-title"></h5>'+
			'<div class="widget-toolbar">'+
				'<a data-action="collapse" href="#" class="collapse">'+
					'<i class="icon-chevron-up"></i>'+
				'</a>'+
			'</div>'+
		'</div>'+
		'<div class="widget-body">'+
			'<div class="widget-main no-padding">'+
			'</div>'+
		'</div>'+
	'</div>'+
'</div>';
	setTitle();	
	loadSelect($("#group"),"user_group");		
	var group_id=$("#group").val();
	loadPrivilege(group_id);

	$(".collapse").click(function(){
		var id=this.id;
		id="#"+id.substring(2);
		//alert(id);
		var ele=this.children[0];
		collapse(ele,id);
		return false;
	})

	$("#group").change(function(){
		var group_id=$(this).val();
		loadPrivilege(group_id);
	})

	$("#btn_save").click(function(){
		savePrivilege();
	})
});
function savePrivilege(){
	var para={'method':'updatePrivilege','group_id':$("#group").val()};
	var data=[];
	$(".pages").each(function(){		
		if ($(this).prop("checked")){			
			data.push(this.value);
		}
	})
	para['data']=data;
	var result=exeJson(para);
	showMsg(result);
}
function loadPrivilege(group_id){
	$('.pages').prop("checked",false);
	var para={'method':'getPrivilege','group_id':group_id};
	var result=exeJson(para);
	for(var i=0;i<result.length;i++){
		var ele=$("#page_"+result[i]['id']);
		ele.prop("checked",true);
	}
}

