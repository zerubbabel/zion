<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>
<form id="frm">
<div class="row">
	<div class="col-xs-2">		
		客户:
		<select id='cust'>
			<!--<option value=0>--请选择--</option>-->
		</select>
	</div>
	<!--
	<div class="col-xs-3">	
		<input type="text" id="order_no" name="order_no" placeholder='订单号' />		
	</div>	
	
	<div class="col-xs-2">
		交货时间：
	</div>
	<div class="col-xs-2">			
			<input type="text" id="deliveryday" name="deliveryday" class="form-control" placeholder='交货时间' />
	</div>-->
	<div class="col-xs-2">

			<button id='add_btn' class="btn btn-info icon-plus">添加产品</button>
		</div>
		<div class="col-xs-1">
			<button id='save_btn' class="btn btn-success icon-save" type="submit">保存</button>
		
	</div>
	<div class="col-xs-12">
		<table id="grid_dtl" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
		</table>	
	</div>	
</div>	
</form>
<?php include '../modal_products.php';?>
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="views/sale/new_customer_order.js"></script>