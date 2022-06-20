<!DOCTYPE html>
<html lang="en">

<head>

	<title>Era Digital Media</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="Combines strategy, positioning, and people-centered design to create powerful brands, websites, and visuals that engage your audience and help you grow.">
    <meta name="keywords" content="Bikin website, website keren"/>
    <meta property="og:title" content="Webly" />
    <meta property="og:url" content="<?= current_url(); ?>" />
    <meta property="og:site_name" content="Webly" />
    <meta property="og:image" content="<?= base_url(); ?>assets/images/icon_w.png" />
    <meta property="og:description" content="Webly"/>
    <link rel="icon" href="<?= base_url(); ?>assets/images/icon_w.png" sizes="32x32" />
    <link rel="icon" href="<?= base_url(); ?>assets/images/icon_w.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="<?= base_url(); ?>assets/images/icon_w.png" />
    <meta name="msapplication-TileImage" content="<?= base_url(); ?>assets/images/icon_w.png" />
	<link rel="stylesheet" href="<?= base_url(); ?>themes/dashboard/assets/css/style.css">
	<link href="<?php echo base_url(); ?>themes/login/ladda-themeless.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>themes/include/icheck/square/grey.css" rel="stylesheet">

	<script src="<?php echo base_url(); ?>themes/js/jquery-1.11.2.js"></script>
	<script src="<?php echo base_url(); ?>themes/login/spin.min.js"></script>
	<script src="<?php echo base_url(); ?>themes/login/ladda.min.js"></script>
	<script>
		$(function() {
			Login.init()
		});
	</script>
	<script type="text/javascript">
		$(function() {
			$(".form-signin").on('submit', function() {
				$(".resultlogin").html("<div class='alert alert-inverse loading '>Hold On...</div>");
				$.post("<?php echo base_url('dashboard')?>/login", $(".form-signin").serialize(), function(response) {
					var resp = $.parseJSON(response);
					console.log(resp);
					if (!resp.status) {
						$(".resultlogin").html("<div class='alert alert-danger loading '>" + resp.msg + "</div>");
					} else {
						$(".resultlogin").html("<div class='alert alert-success login '>Redirecting Please Wait...</div>");
						window.location.replace(resp.url);
					}
				});
			});

		});
	</script>

</head>

<div class="auth-wrapper align-items-stretch aut-bg-img">
	<div class="flex-grow-1">
		<div class="h-100 d-md-flex align-items-center auth-side-img">
			<img src="<?= base_url(); ?>assets/images/logo.svg" style="width: 150px;" class="img-fluid">
		</div>
		<div class="auth-side-form">
			<div class=" auth-content">

				<h3 class="mb-4 f-w-400 mt-4">Login</h3>
				<form method="POST" class="form-signin form-horizontal" role="form" onsubmit="return false;">
					<div class="form-group fill">
						<label>Email address</label>
						<input type="text" name="email" placeholder=" " required="" autofocus="" class="form-control">

					</div>
					<div class="form-group fill">
						<label for="Password">Password</label>
						<input type="password" name="password" placeholder=" " required="" autofocus="" class="form-control">
					</div>

					<button type="submit" class="btn btn-primary btn-block ladda-button" data-style="zoom-in">Login</button>
					<div style="margin-top:10px" class="resultlogin"></div>
				</form>
			</div>
		</div>
	</div>
</div>


</body>

</html>
<script src="<?php echo base_url(); ?>themes/js/login.js"></script>
<script src="<?php echo base_url(); ?>themes/include/icheck/icheck.min.js"></script>
<script src="<?= base_url(); ?>themes/dashboard/assets/js/plugins/bootstrap.min.js"></script>

<script>
	Ladda.bind('div:not(.progress-demo) button', {
		timeout: 2000
	});
	Ladda.bind('.progress-demo button', {
		callback: function(instance) {
			var progress = 0;
			var interval = setInterval(function() {
				progress = Math.min(progress + Math.random() * 0.1, 1);
				instance.setProgress(progress);
				if (progress === 1) {
					instance.stop();
					clearInterval(interval);
				}
			}, 200);
		}
	});
</script>

<script>
	var cb, optionSet1;
	$(".checkbox").iCheck({
		checkboxClass: "icheckbox_square-grey",
		radioClass: "iradio_square-grey"
	});

	$(".radio").iCheck({
		checkboxClass: "icheckbox_square-grey",
		radioClass: "iradio_square-grey"
	});
</script>