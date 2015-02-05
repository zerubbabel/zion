<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>UI Elements - Ace Admin</title>
	<meta name="description" content="Common UI Features &amp; Elements" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<!-- basic styles -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="assets/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" />
	<link rel="stylesheet" href="assets/css/jquery.gritter.css" />
	<!-- ace styles -->
	<link rel="stylesheet" href="assets/css/ace.min.css" />
	<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
	<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
</head>
<body>
	<p>hello world!</p>
	<p>你好!</p>
	<button id="bootbox-confirm" class="btn btn-info">Confirm</button>
	<button id="gritter-error" class="btn btn-danger">Error</button>
	
	<div class="widget-box">
		<div class="widget-header">
			<h4>Default</h4>
		</div>

		<div class="widget-body">
			<div class="widget-main no-padding">
				<form>
					<!-- <legend>Form</legend> -->

					<fieldset>
						<label>Label name</label>

						<input type="text" placeholder="Type something…">
						<span class="help-block">Example block-level help text here.</span>

						<label class="pull-right">
							<input type="checkbox" class="ace">
							<span class="lbl"> check me out</span>
						</label>
					</fieldset>

					<div class="form-actions center">
						<button class="btn btn-sm btn-success" type="button">
							Submit
							<i class="icon-arrow-right icon-on-right bigger-110"></i>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="../jquery2.0.3/jquery-2.0.3.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery-ui-1.10.3.custom.min.js"></script>
	<script src="assets/js/bootbox.min.js"></script>
	<script src="assets/js/jquery.gritter.min.js"></script>
	<script src="assets/js/ace.min.js"></script>
	<!-- inline scripts related to this page -->
	<script type="text/javascript">
		$(document).ready(function(){
			$("#bootbox-confirm").on(ace.click_event, function() {
				bootbox.confirm("Are you sure?", function(result) {
					if(result) {
						alert('yes');
					}
					else{
						alert('no');
					}
				});
			});
			
			$('#gritter-error').on(ace.click_event, function(){
				$.gritter.add({
					title: 'This is a warning notification',
					text: 'Just add a "gritter-light" class_name to your $.gritter.add or globally to $.gritter.options.class_name',
					class_name: 'gritter-error' 
				});
		
				return false;
			});
		});
	</script>
</body>
</html>