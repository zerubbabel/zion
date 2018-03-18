<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>
<form id="frm">
	<div class="row" style="height:50px">
		<div class="col-xs-5">
			客户:
			<select id='cust' class='width-50 chosen-select' data-placeholder='选择客户...'>
			</select>
		</div>	
		<div class="col-xs-7">		
			<button id='btn_save' type="submit" class="btn btn-success icon-save">生成销售出库单</button>
		</div>
	</div>	
	<div class="row">
		<div class="col-xs-12">	
			<table id="tbl_dtl"></table>													
		</div>						
	</div>	
</form>
<?php include '../modal_products.php';?>
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="views/sale/client_order_out.js"></script>