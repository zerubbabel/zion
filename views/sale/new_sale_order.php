<div class="row">

	<div class="col-xs-12">
		<form class="form-horizontal" role="form">			
			<div class="form-group">
				<div class="col-sm-6">
					<button id='add_btn' class="btn icon-plus">添加产品</button>
					<button id='save_btn' class="btn icon-save">保存</button>
				</div>
				<div class="col-sm-6">
					<label for="cust" class="control-label no-padding-right">客户</label>
					<?php //include '../../ajax/select_cust.php' ?>
				</div>			
			</div>	

			
			<div class="modal-body ">
				<div class="col-xs-12">
					<table id="grid_dtl" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
					</table>
					<!--<div id="pager_dtl"></div>-->
				<div>
			</div>
			
		</form>	
	</div><!-- /.col -->

</div><!-- /.row -->

<!--modal of products-->
<div id="modal_products" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header no-padding">
				<div class="table-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						<span class="white">&times;</span>
					</button>
					选择产品 
				</div>
			</div>

			<div class="modal-body no-padding ">												
				<div class="modal-body ">
					<div class='row'>
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">筛选：</label>

						<div class="col-sm-9">
							<input type="text" id="product_filter" placeholder="产品描述" class="col-xs-10 col-sm-5" />
						</div>
					</div>
					<div class='row'>	
						<div class="col-sm-12">						
							<table id="modal_tbl_products" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
							</table>						
						</div>
					</div>	
				</div>				
			</div>

			<div class="modal-footer no-margin-top">
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<!-- end of modal of products-->

<!-- page specific plugin scripts -->
<!--<script src="assets/js/jqModal.min.js"></script>-->
<!--
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>-->
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="assets/js/data-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/data-time/bootstrap-datepicker.zh-CN.js"></script>
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="views/sale/new_sale_order.js"></script>