<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>

<form id="frm">
	<div class="row" style="height:50px">
		<div class="col-xs-4">
			供应商:
			<select class="width-50 chosen-select" id="supplier" 
				data-placeholder="选择供应商...">		
			</select>
		</div>	
		<div class="col-xs-8">	
			入库仓库:
			<select id='loc'>
			</select>	
			<button id='btn_save' type="submit" class="btn btn-success icon-save">生成采购入库单</button>
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
<script src="assets/js/chosen.jquery.js"></script>
<script src="views/purchase/purchase_in.js"></script>