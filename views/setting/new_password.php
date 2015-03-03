<form id="frm">
<div class="row" style="height:40px">
	<div class="col-xs-5">
	</div>
	<div class="col-xs-1">
		<label>原密码:</label>
	</div>
	<div class="col-xs-5">
		<input type="password" id="old_password" name="old_password" />
	</div>
	<div class="col-xs-1">
	</div>
</div>	
<div class="row" style="height:40px">
	<div class="col-xs-5">
	</div>
	<div class="col-xs-1">
		<label>新密码:</label>
	</div>
	<div class="col-xs-5">
		<input type="password" id="new_password" name="new_password" />
	</div>
	<div class="col-xs-1">
	</div>
</div>
<div class="row" style="height:40px">
	<div class="col-xs-5">
	</div>
	<div class="col-xs-1">
		<label>重复新密码:</label>
	</div>
	<div class="col-xs-5">		
		<input type="password" id="new_password2" name="new_password2"/>
	</div>
	<div class="col-xs-1">
	</div>
</div>
<div class="row" style="height:40px">
	<div class="col-xs-12 text-center">
		<input type="submit" class="btn btn-success icon-save" value="修改" id="btn_save"/>
		<input type="reset" class="btn icon-reset" value="重置" id="btn_reset"/>
	</div>
</div>
</form>

<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="views/setting/new_password.js"></script>