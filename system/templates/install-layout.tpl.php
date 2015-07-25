<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Install Cmfive <?php echo CMFIVE_VERSION; ?></title>

        <?php
		$w->enqueueStyle(array("name" => "normalize.css", "uri" => "/system/templates/js/foundation-5.5.0/css/normalize.css", "weight" => 1010));
		$w->enqueueStyle(array("name" => "foundation.css", "uri" => "/system/templates/js/foundation-5.5.0/css/foundation.css", "weight" => 1005));
		$w->enqueueStyle(array("name" => "install.css", "uri" => "/system/templates/css/install.css", "weight" => 1000));
		$w->enqueueStyle(array("name" => "jquery-ui-1.8.13.custom.css", "uri" => "/system/templates/js/jquery-ui-new/css/custom-theme/jquery-ui-1.8.13.custom.css", "weight" => 970));
		$w->enqueueScript(array("name" => "modernizr.js", "uri" => "/system/templates/js/foundation-5.5.0/js/vendor/modernizr.js", "weight" => 1010));
		$w->enqueueScript(array("name" => "jquery.js", "uri" => "/system/templates/js/foundation-5.5.0/js/vendor/jquery.js", "weight" => 1000));
		$w->enqueueScript(array("name" => "jquery-ui-1.10.4.custom.min.js", "uri" => "/system/templates/js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js", "weight" => 960));
		$w->enqueueScript(array("name" => "foundation.min.js", "uri" => "/system/templates/js/foundation-5.5.0/js/foundation.min.js", "weight" => 940));
		$w->enqueueScript(array("name" => "zxcvbn-async.js", "uri" => "/system/templates/js/zxcvbn-async.js", "weight" => 940));
		$w->outputStyles();
		$w->outputScripts();
		?>
	</head>
	<body>
		<div class="row body">
			<div class="row-fluid">
				<div class="show-for-medium-up columns large-12 clearfix">
					<h3 class="header"><img src="/system/templates/img/cmfive-logo.png" alt="Cmfive" /> Installing Cmfive <?php echo CMFIVE_VERSION; ?></h3>
				</div>
				<div class="hide-for-medium-up columns small-12">
					<h2 class="header">Installing Cmfive <?php echo CMFIVE_VERSION; ?></h2>
				</div>
				<?php echo !empty($body) ? $body : ''; ?>
			</div>
        </div>
		<script>
		$(document)
		  .foundation({
			abide : {
			  patterns: {
				ip_address: /^((25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])\.){3}(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])$/
			  }
			}
		  });
		</script>
	</body>
</html>