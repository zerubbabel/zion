<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>
<form id="frm">
	<div class="col-xs-4">
		外协单位:
		<select id='os_unit'>
			<!--<option value=0>--请选择--</option>-->
		</select>	
	</div>	
	<div class="col-xs-1">
		交货时间：
	</div>
	<div class="col-xs-7">		
		<div class="input-group input-group-sm">			
			<input type="text" id="deliveryday" name="deliveryday" class="form-control" placeholder='交货时间' />
			<span class="input-group-addon">
				<i class="icon-calendar"></i>
			</span>
			<button id='add_btn' class="btn btn-success icon-plus">添加产品</button>
			<button id='save_btn' class="btn btn-primary icon-save" type="submit">保存</button>													
		</div>	
	</div>
	<div class="col-xs-12">	
		<table id="grid_dtl" ></table>	
	</div>
	
</form>
<?php include '../modal_products.php';?>
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="views/outsource/new_os_order.js"></script>