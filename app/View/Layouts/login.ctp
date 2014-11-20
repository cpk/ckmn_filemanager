<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Sentir, Responsive admin and dashboard UI kits template">
		<meta name="keywords" content="admin,bootstrap,template,responsive admin,dashboard template,web apps template">
		<meta name="author" content="Ari Rusmanto, Isoh Design Studio, Warung Themes">
		<title>Login | SENTIR - Responsive admin and dashboard UI kits template</title>
 
		<!-- BOOTSTRAP CSS (REQUIRED ALL PAGE)-->
		<link href="<?php echo $webroot; ?>/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- PLUGINS CSS -->
                <?php echo $this->Html->css('bootstrap-responsive.css'); ?>
		<link href="<?php echo $webroot; ?>/plugins/weather-icon/css/weather-icons.min.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/prettify/prettify.min.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/magnific-popup/magnific-popup.min.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/owl-carousel/owl.carousel.min.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/owl-carousel/owl.theme.min.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/owl-carousel/owl.transitions.min.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/chosen/chosen.min.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/icheck/skins/all.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/datepicker/datepicker.min.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/validator/bootstrapValidator.min.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/summernote/summernote.min.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/markdown/bootstrap-markdown.min.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/datatable/css/bootstrap.datatable.min.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/morris-chart/morris.min.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/c3-chart/c3.min.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/slider/slider.min.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/salvattore/salvattore.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/toastr/toastr.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/plugins/fullcalendar/fullcalendar/fullcalendar.print.css" rel="stylesheet" media="print">
		
		<!-- MAIN CSS (REQUIRED ALL PAGE)-->
		<link href="<?php echo $webroot; ?>/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/css/style.css" rel="stylesheet">
		<link href="<?php echo $webroot; ?>/css/style-responsive.css" rel="stylesheet">
 
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
 
	<body class="login tooltips">
		
		<!-- BEGIN PANEL DEMO -->
		<div class="box-demo">
			<div class="inner-panel">
				<div class="cog-panel" id="demo-panel"><i class="fa fa-cog fa-spin"></i></div>
				<p class="text-muted small text-center">COLOR SCHEMES</p>
				<div class="row text-center">
					<div class="col-xs-3">
						<div class="xs-tiles" data-toggle="tooltip" title="Default" id="color-reset">
							<div class="half-tiles bg-primary"></div>
							<div class="half-tiles bg-primary"></div>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="xs-tiles" data-toggle="tooltip" title="Success" id="bg-success">
							<div class="half-tiles bg-success"></div>
							<div class="half-tiles bg-success"></div>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="xs-tiles" data-toggle="tooltip" title="Info" id="bg-info">
							<div class="half-tiles bg-info"></div>
							<div class="half-tiles bg-info"></div>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="xs-tiles" data-toggle="tooltip" title="Danger" id="bg-danger">
							<div class="half-tiles bg-danger"></div>
							<div class="half-tiles bg-danger"></div>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="xs-tiles" data-toggle="tooltip" title="Warning" id="bg-warning">
							<div class="half-tiles bg-warning"></div>
							<div class="half-tiles bg-warning"></div>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="xs-tiles" data-toggle="tooltip" title="Dark" id="bg-dark">
							<div class="half-tiles bg-dark"></div>
							<div class="half-tiles bg-dark"></div>
						</div>
					</div>
				</div>
				<button class="btn btn-block btn-primary btn-sm" id="btn-reset">Reset to default</button>
				<a href="http://themeforest.net/item/sentir-responsive-admin-and-dashboard-ui-kits/7700260?ref=arirusmanto" class="btn btn-block btn-danger btn-sm" id="btn-reset"><i class="fa fa-shopping-cart"></i> Buy this template</a>
			</div>
		</div>
		<!-- END PANEL DEMO -->

        <?php echo $content_for_layout ?>



        <!--
		===========================================================
		Placed at the end of the document so the pages load faster
		===========================================================
		-->
		<!-- MAIN JAVASRCIPT (REQUIRED ALL PAGE)-->
		<script src="<?php echo $webroot; ?>/js/jquery.min.js"></script>
		<script src="<?php echo $webroot; ?>/js/bootstrap.min.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/retina/retina.min.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/nicescroll/jquery.nicescroll.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/backstretch/jquery.backstretch.min.js"></script>
 
		<!-- PLUGINS -->
		<script src="<?php echo $webroot; ?>/plugins/skycons/skycons.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/prettify/prettify.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/owl-carousel/owl.carousel.min.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/chosen/chosen.jquery.min.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/icheck/icheck.min.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/datepicker/bootstrap-datepicker.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/timepicker/bootstrap-timepicker.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/mask/jquery.mask.min.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/validator/bootstrapValidator.min.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/datatable/js/bootstrap.datatable.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/summernote/summernote.min.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/markdown/markdown.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/markdown/to-markdown.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/markdown/bootstrap-markdown.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/slider/bootstrap-slider.js"></script>
		
		<script src="<?php echo $webroot; ?>/plugins/toastr/toastr.js"></script>
		
		<!-- FULL CALENDAR JS -->
		<script src="<?php echo $webroot; ?>/plugins/fullcalendar/lib/jquery-ui.custom.min.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
		<script src="<?php echo $webroot; ?>/js/full-calendar.js"></script>
		
		<!-- EASY PIE CHART JS -->
		<script src="<?php echo $webroot; ?>/plugins/easypie-chart/easypiechart.min.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/easypie-chart/jquery.easypiechart.min.js"></script>
		
		<!-- KNOB JS -->
		<!--[if IE]>
		<script type="text/javascript" src="<?php echo $webroot; ?>/plugins/jquery-knob/excanvas.js"></script>
		<![endif]-->
		<script src="<?php echo $webroot; ?>/plugins/jquery-knob/jquery.knob.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/jquery-knob/knob.js"></script>

		<!-- FLOT CHART JS -->
		<script src="<?php echo $webroot; ?>/plugins/flot-chart/jquery.flot.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/flot-chart/jquery.flot.tooltip.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/flot-chart/jquery.flot.resize.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/flot-chart/jquery.flot.selection.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/flot-chart/jquery.flot.stack.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/flot-chart/jquery.flot.time.js"></script>

		<!-- MORRIS JS -->
		<script src="<?php echo $webroot; ?>/plugins/morris-chart/raphael.min.js"></script>
		<script src="<?php echo $webroot; ?>/plugins/morris-chart/morris.min.js"></script>
		
		<!-- C3 JS -->
		<script src="<?php echo $webroot; ?>/plugins/c3-chart/d3.v3.min.js" charset="utf-8"></script>
		<script src="<?php echo $webroot; ?>/plugins/c3-chart/c3.min.js"></script>
		
		<!-- MAIN APPS JS -->
		<script src="<?php echo $webroot; ?>/js/apps.js"></script>
		<script src="<?php echo $webroot; ?>/js/demo-panel-login.js"></script>
		
	</body>
</html>
