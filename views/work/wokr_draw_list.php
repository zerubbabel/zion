<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>
<div class="row">
	<div class="col-xs-12" id="toolbar"></div>
	<div class="col-xs-8">
		<table id="grid-table"></table>
		<div id="grid-pager"></div>
	</div><!-- /.col -->
	<div class="col-xs-4" id="div_dtl">
		<table id="list_d"></table>
	</div>
</div><!-- /.row -->

<!-- page specific plugin scripts -->
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="views/outsource/os_order_list.js"></script>