<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
	$enddate=(strftime('%Y-%m-%d'));	

	$startdate=date("Y-m-d",strtotime("$enddate -".REPORT_DAYS." day"));
	$enddate=date("Y-m-d",strtotime("$enddate +1 day"));
?>
<label for="date_start" class="control-label no-padding-right">开始时间:</label>
<input type="textbox" id="date_start" VALUE="<?PHP echo $startdate ?>"/>
<label for="date_end" class="control-label no-padding-right">结束时间:</label>
<input type="textbox" id="date_end" VALUE="<?PHP echo $enddate ?>"/>
<button class="btn btn-success btn-sm icon-search" id="btn_search">查看</button>
<div class="row">
	<div class="col-xs-6">
		<table id="grid-table"></table>
		<div id="grid-pager"></div>
	</div><!-- /.col -->
	<div class="col-xs-6" id="div_dtl">
		<table id="list_d"></table>
	</div>
</div><!-- /.row -->

<!-- page specific plugin scripts -->
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="views/report/r_os_out.js"></script>