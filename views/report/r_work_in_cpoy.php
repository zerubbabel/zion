<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
	$enddate=(strftime('%Y-%m-%d'));	
	$startdate=date("Y-m-d",strtotime("$enddate -".REPORT_DAYS." day"));
?>
<form id="frm">
<div class="row">
	<div class="col-xs-12">
		<label for="date_start" class="control-label no-padding-right">开始时间:</label>
		<input type="textbox" id="date_start" VALUE="<?PHP echo $startdate ?>"/>
		<label for="date_end" class="control-label no-padding-right">结束时间:</label>
		<input type="textbox" id="date_end" VALUE="<?PHP echo $enddate ?>"/>
		<button class="btn btn-success btn-sm icon-search" id="btn_search">查看</button>
		<table id="tbl_dtl" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
		</table>		
		<div id="pager"></div>											
	</div>						
</div>	
</form>

<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="views/report/r_work_in.js"></script>