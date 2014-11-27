<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Home</title>

		<?php echo $this->Html->css( 'bootstrap.min' ); ?>
		<?php echo $this->Html->css( 'bootstrap-responsive' ); ?>
		<?php echo $this->Html->css( '/plugins/font-awesome/css/font-awesome.min' ); ?>
		<?php echo $this->Html->css( 'home' ); ?>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>

		<div class="site-wrapper">

			<div class="site-wrapper-inner">

				<div class="cover-container">

					<div class="masthead clearfix">
						<div class="inner">
							<h3 class="masthead-brand">Cover</h3>
							<ul class="nav masthead-nav">
								<li class="active"><a href="#">Home</a></li>
								<li><a href="#">Features</a></li>
								<li><a href="#">Contact</a></li>
							</ul>
						</div>
					</div>

					<div class="inner cover">
						<?php echo $content_for_layout; ?>
					</div>

					<div class="mastfoot">
						<div class="inner">
							<p>Cover template for <a href="../../index.html">Bootstrap</a>, by <a
									href="https://twitter.com/mdo">@mdo</a>.</p>
						</div>
					</div>

				</div>

			</div>

		</div>

		<?php
		echo $this->Html->script( 'jquery.min' );
		echo $this->Html->script( 'bootstrap.min' );
		?>
	</body>
</html>
