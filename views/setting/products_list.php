<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>
<div class="row">

	<div id="toolbar" class="col-xs-12"></div>
	<div class="col-xs-6">
		筛选：<input type="text" id="product_filter"/>

		<!-- PAGE CONTENT BEGINS -->
		<table id="grid-table"></table>

		<div id="grid-pager"></div>
		<!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->
	<div class="col-xs-6" id="div_dtl">
		<table id="list_d"></table>
		<!--<div id="pager_d"></div>-->
	</div>
</div><!-- /.row -->

<!-- page specific plugin scripts -->
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="views/setting/products_list.js"></script>