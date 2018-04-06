<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>

<button id='print_btn' class="btn btn-success icon-print">打印</button>

<div class="row">
	<div class="col-xs-12" id="toolbar">		
	</div>
	<div class="col-xs-4">
		<table id="grid-table"></table>
		<div id="grid-pager"></div>
	</div><!-- /.col -->
	<div class="col-xs-8" id="div_dtl">
		<span id="cust_name"></span>
		<table id="list_d"></table>
	</div>
</div><!-- /.row -->
<!-- page specific plugin scripts -->
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
<script src="assets/js/jquery.jqprint-0.3.js"></script>
<script src="views/sale/customer_orders_manage.js"></script>