<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
	$month=(strftime('%Y-%m'));	
?>
<div class="row">
	<div class="col-xs-12">
		<table id="grid-table"></table>
		<div id="grid-pager"></div>
	</div><!-- /.col -->
</div><!-- /.row -->

<!-- page specific plugin scripts -->
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="assets/js/chosen.jquery.js"></script>
<script src="views/work/tasks.js"></script>