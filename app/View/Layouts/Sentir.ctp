<!DOCTYPE html>
<html lang="en">
	<head>
		<?php echo $this->Html->charset(); ?>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Sentir, Responsive admin and dashboard UI kits template">
		<meta name="keywords" content="admin,bootstrap,template,responsive admin,dashboard template,web apps template">
		<meta name="author" content="Ari Rusmanto, Isoh Design Studio, Warung Themes">
		<title><?php echo $this->fetch( 'title' ); ?></title>
		<?php
		echo $this->Html->meta( 'icon' );
		echo $this->Html->css( array(
			'bootstrap.min',
			'style',
			'/plugins/font-awesome/css/font-awesome.min',
			'style-responsive'
		) );
		?>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="tooltips">

		<!--
		===========================================================
		BEGIN PAGE
		===========================================================
		-->
		<div class="wrapper">
			<!-- BEGIN TOP NAV -->
			<div class="top-navbar">
				<div class="top-navbar-inner">

					<!-- Begin Logo brand -->
					<div class="logo-brand">
						<a href="#">
							<?php
							echo $this->Html->image( 'sentir-logo-primary.png', array( 'alt' => 'Sentir logo' ) );
							?>
						</a>
					</div>
					<!-- /.logo-brand -->
					<!-- End Logo brand -->

					<div class="top-nav-content no-right-sidebar">

						<!-- Begin button sidebar left toggle -->
						<div class="btn-collapse-sidebar-left">
							<i class="fa fa-bars"></i>
						</div>
						<!-- /.btn-collapse-sidebar-left -->
						<!-- End button sidebar left toggle -->

						<!-- Begin button nav toggle -->
						<div class="btn-collapse-nav" data-toggle="collapse" data-target="#main-fixed-nav">
							<i class="fa fa-plus icon-plus"></i>
						</div>
						<!-- /.btn-collapse-sidebar-right -->
						<!-- End button nav toggle -->


						<!-- Begin user session nav -->
						<ul class="nav-user navbar-right full">
							<li class="dropdown">
								<a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown">
									<?php
									echo $this->Html->image( 'avatar/avatar-1.jpg', array( 'alt'   => 'Sentir logo',
									                                                       'class' => 'avatar img-circle'
										) );
									?>

									Hi, <strong>Paris Hawker</strong>
								</a>
								<ul class="dropdown-menu square primary margin-list-rounded with-triangle">
									<li><a href="#fakelink">Account setting</a></li>
									<li><a href="#fakelink">Payment setting</a></li>
									<li><a href="#fakelink">Change password</a></li>
									<li><a href="#fakelink">My public profile</a></li>
									<li class="divider"></li>
									<li><a href="lock-screen.html">Lock screen</a></li>
									<li><a href="login.html">Log out</a></li>
								</ul>
							</li>
						</ul>
						<!-- End user session nav -->

						<!-- Begin Collapse menu nav -->
						<div class="collapse navbar-collapse" id="main-fixed-nav">
							<!-- Begin nav search form -->
							<form class="navbar-form navbar-left" role="search">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Search">
								</div>
							</form>
							<!-- End nav search form -->
							<ul class="nav navbar-nav navbar-left">
								<!-- Begin nav notification -->
								<li class="dropdown">
									<a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown">
										<span class="badge badge-danger icon-count">7</span>
										<i class="fa fa-bell"></i>
									</a>
									<ul class="dropdown-menu square with-triangle">
										<li>
											<div class="nav-dropdown-heading">
												Notifications
											</div>
											<!-- /.nav-dropdown-heading -->
											<div class="nav-dropdown-content scroll-nav-dropdown">
												<ul>
													<li><a href="#fakelink">
															<?php
															echo $this->Html->image( 'avatar/avatar-10.jpg', array( 'alt'   => 'Avatar',
															                                                        'class' => 'absolute-left-content img-circle'
																) );
															?>
															<strong>Carl Rodriguez</strong> joined your weekend party
															<span class="small-caps">April 01, 2014</span>
														</a></li>
												</ul>
											</div>
											<!-- /.nav-dropdown-content scroll-nav-dropdown -->
											<button class="btn btn-primary btn-square btn-block">See all notifications
											</button>
										</li>
									</ul>
								</li>
								<!-- End nav notification -->
								<!-- Begin nav task -->
								<li class="dropdown">
									<a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown">
										<span class="badge badge-warning icon-count">3</span>
										<i class="fa fa-tasks"></i>
									</a>
									<ul class="dropdown-menu square margin-list-rounded with-triangle">
										<li>
											<div class="nav-dropdown-heading">
												Tasks
											</div>
											<!-- /.nav-dropdown-heading -->
											<div class="nav-dropdown-content scroll-nav-dropdown">
												<ul>
													<li class="unread"><a href="#fakelink">
															<i class="fa fa-check-circle-o absolute-left-content icon-task completed"></i>
															Creating documentation
															<span class="small-caps">Completed : Yesterday</span>
														</a></li>
													<li><a href="#fakelink">
															<i class="fa fa-clock-o absolute-left-content icon-task progress"></i>
															Eating sands
															<span class="small-caps">Deadline : Tomorrow</span>
														</a></li>
													<li><a href="#fakelink">
															<i class="fa fa-clock-o absolute-left-content icon-task progress"></i>
															Sending payment
															<span class="small-caps">Deadline : Next week</span>
														</a></li>
													<li><a href="#fakelink">
															<i class="fa fa-exclamation-circle absolute-left-content icon-task uncompleted"></i>
															Uploading new version
															<span class="small-caps">Deadline: 2 seconds ago</span>
														</a></li>
													<li><a href="#fakelink">
															<i class="fa fa-exclamation-circle absolute-left-content icon-task uncompleted"></i>
															Drinking coffee
															<span class="small-caps">Deadline : 2 hours ago</span>
														</a></li>
													<li class="unread"><a href="#fakelink">
															<i class="fa fa-check-circle-o absolute-left-content icon-task completed"></i>
															Walking to nowhere
															<span class="small-caps">Completed : over a year ago</span>
														</a></li>
													<li class="unread"><a href="#fakelink">
															<i class="fa fa-check-circle-o absolute-left-content icon-task completed"></i>
															Sleeping under bridge
															<span class="small-caps">Completed : Dec 31, 2013</span>
														</a></li>
													<li class="unread"><a href="#fakelink">
															<i class="fa fa-check-circle-o absolute-left-content icon-task completed"></i>
															Buying some cigarettes
															<span class="small-caps">Completed : 2 days ago</span>
														</a></li>
												</ul>
											</div>
											<!-- /.nav-dropdown-content scroll-nav-dropdown -->
											<button class="btn btn-primary btn-square btn-block">See all notifications
											</button>
										</li>
									</ul>
								</li>
								<!-- End nav task -->
								<!-- Begin nav message -->
								<li class="dropdown">
									<a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown">
										<span class="badge badge-success icon-count">9</span>
										<i class="fa fa-envelope"></i>
									</a>
									<ul class="dropdown-menu square margin-list-rounded with-triangle">
										<li>
											<div class="nav-dropdown-heading">
												Messages
											</div>
											<!-- /.nav-dropdown-heading -->
											<div class="nav-dropdown-content scroll-nav-dropdown">
												<ul>
													<li class="unread"><a href="#fakelink">
															<?php
															echo $this->Html->image( 'avatar/avatar-25.jpg', array( 'alt'   => 'Sentir logo',
															                                                        'class' => 'absolute-left-content img-circle'
																) );
															?>
															Lorem ipsum dolor sit amet, consectetuer adipiscing elit
															<span class="small-caps">17 seconds ago</span>
														</a></li>
													<li><a href="#fakelink">
															<?php
															echo $this->Html->image( 'avatar/avatar-17.jpg', array( 'alt'   => 'Sentir logo',
															                                                        'class' => 'absolute-left-content img-circle'
																) );
															?>
															Will you send me an invitation for your weeding party?
															<span class="small-caps">April 01, 2014</span>
														</a></li>
												</ul>
											</div>
											<!-- /.nav-dropdown-content scroll-nav-dropdown -->
											<button class="btn btn-primary btn-square btn-block">See all message
											</button>
										</li>
									</ul>
								</li>
								<!-- End nav message -->
							</ul>
						</div>
						<!-- /.navbar-collapse -->
						<!-- End Collapse menu nav -->
					</div>
					<!-- /.top-nav-content -->
				</div>
				<!-- /.top-navbar-inner -->
			</div>
			<!-- /.top-navbar -->
			<!-- END TOP NAV -->


			<!-- BEGIN SIDEBAR LEFT -->
			<div class="sidebar-left sidebar-nicescroller">
				<?php
				echo $this->fetch( 'sidebar-left' );
				?>
			</div>
			<!-- /.sidebar-left -->
			<!-- END SIDEBAR LEFT -->


			<!-- BEGIN PAGE CONTENT -->
			<div class="page-content">

				<div class="container-fluid">

					<!-- Begin page heading -->
					<h1 class="page-heading">DASHBOARD
						<small>No sidebar right</small>
					</h1>
					<!-- End page heading -->

					<?php echo $this->Session->flash(); ?>

					<?php echo $this->fetch( 'content' ); ?>

				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- /.page-content -->
		</div>
		<!-- /.wrapper -->
		<!-- END PAGE CONTENT -->


		<!-- BEGIN BACK TO TOP BUTTON -->
		<div id="back-top">
			<a href="#top"><i class="fa fa-chevron-up"></i></a>
		</div>
		<!-- END BACK TO TOP -->


		<!--
		===========================================================
		END PAGE
		===========================================================
		-->

		<!--
		===========================================================
		Placed at the end of the document so the pages load faster
		===========================================================
		-->
		<!-- MAIN JAVASRCIPT (REQUIRED ALL PAGE)-->
		<?php
		echo $this->Html->script( array(
			'jquery.min',
			'bootstrap.min',
			'/plugins/retina/retina.min',
			'/plugins/nicescroll/jquery.nicescroll',
			'/plugins/slimscroll/jquery.slimscroll.min',
			'/plugins/backstretch/jquery.backstretch.min',
		) );
		echo $this->fetch( 'footer_script' );
		echo $this->Html->script( array(
			'apps',
			'demo-panel',
		) );
		?>
	</body>
</html>