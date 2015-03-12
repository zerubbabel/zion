<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>
<form id="frm">	
	<div class="col-xs-12">
		车间:<select id='workcenter'></select>
		入库仓库:<select id='loc'></select>			
		<button id='btn_save' type="submit" class="btn btn-success icon-save">入库</button>		
	</div>		
	<div class="col-xs-12">	
		<table id="tbl_dtl"></table>													
	</div>							
</form>

<!--modal-->
<div id="modal" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header no-padding">
				<div class="table-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						<span class="white">&times;</span>
					</button>
					<div id="modal_title"></div> 
				</div>
			</div>
			<div class="modal-body no-padding " id="modal_body">				
				<div class="col-xs-12">
					筛选：
					<input type="text" id="modal_filter" placeholder="产品描述" />
				</div>									
				<div class="col-xs-12" id="div_grid">						
					<table id="modal_grid"></table>						
				</div>								
			</div>
			<div class="modal-footer no-margin-top">
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<!-- end of modal-->

<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="views/work/work_in.js"></script>