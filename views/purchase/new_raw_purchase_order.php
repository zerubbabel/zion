<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>
<form id="frm">
<div class="row">
	<div class="col-xs-4">
		供应商:
		<select id='supplier'></select>			
	</div>	
	<div class="col-xs-8">		
		<div class="input-group input-group-sm">			
			<button id='add_btn' class="btn btn-info icon-plus">添加产品</button>
			<button id='save_btn' class="btn btn-success icon-save" type="submit">保存</button>
		</div>
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
<script src="views/purchase/new_raw_purchase_order.js"></script>