<div class="row">
	<div class="alert alert-info">
			<i class="icon-hand-right"></i>

			Please note that demo server is not configured to save the changes, therefore you may get an error message.
			<button class="close" data-dismiss="alert">
				<i class="icon-remove"></i>
			</button>
			<button id='modal-btn'>MODEL</button>
			<button id='btn_test'>TEST</button>
	</div>

	<div class="col-xs-6">
		<!-- PAGE CONTENT BEGINS -->
		<table id="grid-table"></table>

		<div id="grid-pager"></div>
		<!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->
	<div class="col-xs-6" id="div_dtl">
		<table id="list_d"></table>
		<div id="pager_d"></div>
	</div>
</div><!-- /.row -->

<!-- add new  -->
<div id="modal-table" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header no-padding">
				<div class="table-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						<span class="white">&times;</span>
					</button>
					Results for "Latest Registered Domains
				</div>
			</div>

		<div class="modal-body no-padding">		
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Text Field </label>

					<div class="col-sm-9">
						<input type="text" id="form-field-1" placeholder="Username" class="col-xs-10 col-sm-5" />
					</div>
				</div>

				<div class="space-4"></div>

				<div class="form-group">
					<label for="form-field-select-3" class="col-sm-3 control-label no-padding-right">客户</label>

					<div class="col-sm-9">
						<select class="chosen-select" id="form-field-select-3" data-placeholder="Choose a Country...">
							<option value="">&nbsp;</option>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>											
						</select>
					</div>
				</div>	
				
				<div class="modal-body ">
					<div class="col-xs-12">
						<table id="modal_dtl" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
						</table>
						<div id="modal_pager_dtl"></div>
					<div>
				</div>
				

				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						<button class="btn btn-info" type="button">
							<i class="icon-ok bigger-110"></i>
							Submit
						</button>

						&nbsp; &nbsp; &nbsp;
						<button class="btn" type="reset">
							<i class="icon-undo bigger-110"></i>
							Reset
						</button>
					</div>
				</div>
				
			</form>		
		</div>

			<div class="modal-footer no-margin-top">
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- PAGE CONTENT ENDS -->

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
<script src="views/sale/sale_order_maintain.js"></script>