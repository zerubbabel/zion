$(document).ready(function(){
	var mst_data={'lco_id':1};
	var dtl_data=[{'product_id':'1','qty':10000},
	{'product_id':'2','qty':200000},
	{'product_id':'3','qty':10}];
	var para={'mst_data':mst_data,'dtl_data':dtl_data};
	$('#btn').click(function(){
		var ans;
		$.ajax({
			type:'get',
			dataType: 'json',//important
			url:'test/testClass.php',
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
	})
})