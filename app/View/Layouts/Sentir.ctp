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
									echo $this->Html->image( 'avatar/avatar-1.jpg', array( 'alt' => 'Sentir logo', 'class'=>'avatar img-circle' ) );
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
															echo $this->Html->image( 'avatar/avatar-10.jpg', array( 'alt' => 'Avatar', 'class'=>'absolute-left-content img-circle' ) );
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
															echo $this->Html->image( 'avatar/avatar-25.jpg', array( 'alt' => 'Sentir logo', 'class'=>'absolute-left-content img-circle' ) );
															?>
															Lorem ipsum dolor sit amet, consectetuer adipiscing elit
															<span class="small-caps">17 seconds ago</span>
														</a></li>
													<li><a href="#fakelink">
															<?php
															echo $this->Html->image( 'avatar/avatar-17.jpg', array( 'alt' => 'Sentir logo', 'class'=>'absolute-left-content img-circle' ) );
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
				<ul class="sidebar-menu">
					<li>
						<a href="index-2.html">
							<i class="fa fa-dashboard icon-sidebar"></i>
							Dashboard
							<span class="label label-success span-sidebar">UPDATED</span>
						</a>
					</li>
					<li>
						<a href="front-end.html">
							<i class="fa fa-bomb icon-sidebar"></i>
							Web templates
							<span class="label label-danger span-sidebar">NEW</span>
						</a>
					</li>
					<li class="active selected">
						<a href="#fakelink">
							<i class="fa fa-desktop icon-sidebar"></i>
							<i class="fa fa-angle-right chevron-icon-sidebar"></i>
							Layout template
							<span class="badge badge-warning span-sidebar">9</span>
						</a>
						<ul class="submenu visible">
							<li><a href="#fakelink">Default layout<span
										class="label label-success span-sidebar">CURRENT</span></a></li>
							<li class="active selected"><a href="layout-no-sidebar-right.html">No sidebar right</a></li>
							<li><a href="layout-profile-left.html">Profile summary left</a></li>
							<li><a href="layout-no-sidebar-left.html">No sidebar left</a></li>
							<li><a href="layout-shrink-navbar.html">Shrink navbar</a></li>
							<li><a href="layout-top-navigation.html">Top navigation</a></li>
							<li><a href="layout-tour.html">Tour layout</a></li>
							<li><a href="layout-hidden-sidebar-left.html">Hidden sidebar left<span
										class="label label-danger span-sidebar">NEW</span></a></li>
							<li><a href="layout-top-notification.html">Top notification<span
										class="label label-danger span-sidebar">NEW</span></a></li>
						</ul>
					</li>
					<li>
						<a href="#fakelink">
							<i class="fa fa-flask icon-sidebar"></i>
							<i class="fa fa-angle-right chevron-icon-sidebar"></i>
							Widget UI kits
						</a>
						<ul class="submenu">
							<li><a href="widget-default.html">Default<span
										class="label label-success span-sidebar">UPDATED</span></a></li>
							<li><a href="widget-store.html">Store</a></li>
							<li><a href="widget-real-estate.html">Real estate <span
										class="label label-warning span-sidebar">HOT</span></a>
							</li>
							<li><a href="widget-blog.html">Blog</a></li>
							<li><a href="widget-social.html">Social <span
										class="label label-warning span-sidebar">HOT</span></a></li>
						</ul>
					</li>
					<li>
						<a href="#fakelink">
							<i class="fa fa-folder icon-sidebar"></i>
							<i class="fa fa-angle-right chevron-icon-sidebar"></i>
							Basic elements
							<span class="label label-info span-sidebar">BS3</span>
						</a>
						<ul class="submenu">
							<li><a href="element-typography.html">Typography</a></li>
							<li><a href="element-form.html">Form element</a></li>
							<li><a href="element-form-example.html">Form example</a></li>
							<li><a href="element-wyswyg.html">Form WYSWYG</a></li>
							<li><a href="element-validation.html">Form validation</a></li>
							<li><a href="element-button.html">Button</a></li>
						</ul>
					</li>
					<li>
						<a href="#fakelink">
							<i class="fa fa-folder-open icon-sidebar"></i>
							<i class="fa fa-angle-right chevron-icon-sidebar"></i>
							More elements
						</a>
						<ul class="submenu">
							<li><a href="element-icon.html">Icons <span
										class="badge badge-info span-sidebar">3</span></a></li>
							<li><a href="element-box-panel.html">Box &amp; panel</a></li>
							<li><a href="element-nav-dropdown.html">Nav &amp; dropdown</a></li>
							<li><a href="element-breadcrumb-pagination.html">Breadcrumb &amp; pagination</a></li>
							<li><a href="element-thumbnail-jumbotron.html">Jumbotron &amp; thumbnail</a></li>
							<li><a href="element-alert-progress-bar.html">Alert &amp; progress</a></li>
							<li><a href="element-list-media.html">List group &amp; media object</a></li>
							<li><a href="element-collapse.html">Collapse</a></li>
							<li><a href="element-grid-masonry.html">Grid &amp; masonry</a></li>
							<li><a href="element-masonry-js.html">Masonry JS</a></li>
							<li><a href="element-toastr.html">Toastr notifications</a></li>
							<li><a href="element-carousel.html">Carousel</a></li>
							<li><a href="element-calendar.html">Calendar</a></li>
							<li><a href="element-extra.html">Extra elements</a></li>
						</ul>
					</li>
					<li>
						<a href="#fakelink">
							<i class="fa fa-table icon-sidebar"></i>
							<i class="fa fa-angle-right chevron-icon-sidebar"></i>
							Tables
						</a>
						<ul class="submenu">
							<li><a href="table-static.html">Static table</a></li>
							<li><a href="table-color.html">Table color</a></li>
							<li><a href="table-datatable.html">Jquery datatable</a></li>
						</ul>
					</li>
					<li>
						<a href="#fakelink">
							<i class="fa fa-bar-chart-o icon-sidebar"></i>
							<i class="fa fa-angle-right chevron-icon-sidebar"></i>
							Chart or Graph
						</a>
						<ul class="submenu">
							<li><a href="chart-morris.html">Morris chart</a></li>
							<li><a href="chart-c3.html">C3 chart</a></li>
							<li><a href="chart-flot.html">Flot chart</a></li>
							<li><a href="chart-easy-knob.html">Easy pie chart &amp; knob</a></li>
						</ul>
					</li>
					<li class="static">EXTRA DESIGNS</li>
					<li>
						<a href="#fakelink">
							<i class="fa fa-envelope icon-sidebar"></i>
							<i class="fa fa-angle-right chevron-icon-sidebar"></i>
							Mail apps
							<span class="label label-warning span-sidebar">HOT</span>
						</a>
						<ul class="submenu">
							<li><a href="mail-inbox.html">Inbox <span class="badge badge-success span-sidebar">6</span></a>
							</li>
							<li><a href="mail-send.html">Sent mail</a></li>
							<li><a href="mail-new.html">New mail</a></li>
							<li><a href="mail-contact.html">Mail contact</a></li>
							<li><a href="mail-read.html">Read mail</a></li>
							<li><a href="mail-reply.html">Reply mail</a></li>
						</ul>
					</li>
					<li>
						<a href="#fakelink">
							<i class="fa fa-shopping-cart icon-sidebar"></i>
							<i class="fa fa-angle-right chevron-icon-sidebar"></i>
							Store apps
						</a>
						<ul class="submenu">
							<li><a href="store-product-list.html">Product list</a></li>
							<li><a href="store-product-column.html">Product column</a></li>
							<li><a href="store-product-masonry.html">Product masonry</a></li>
							<li><a href="store-product-detail.html">Product detail</a></li>
							<li><a href="store-shopping-cart.html">Shopping cart</a></li>
							<li><a href="store-checkout.html">Checkout</a></li>
							<li><a href="store-new-product.html">Add new product</a></li>
							<li><a href="store-orderlist.html">Order list</a></li>

						</ul>
					</li>
					<li>
						<a href="#fakelink">
							<i class="fa fa-home icon-sidebar"></i>
							<i class="fa fa-angle-right chevron-icon-sidebar"></i>
							Real estate apps
						</a>
						<ul class="submenu">
							<li><a href="real-estate-property-list.html">Property list</a></li>
							<li><a href="real-estate-property-column.html">Property column</a></li>
							<li><a href="real-estate-property-masonry.html">Property masonry</a></li>
							<li><a href="real-estate-property-detail.html">Property detail</a></li>
							<li><a href="real-estate-property-search.html">Search property</a></li>
						</ul>
					</li>
					<li>
						<a href="#fakelink">
							<i class="fa fa-comment icon-sidebar"></i>
							<i class="fa fa-angle-right chevron-icon-sidebar"></i>
							<span class="label label-success span-sidebar">TOP</span>
							Blog apps
						</a>
						<ul class="submenu">
							<li><a href="blog-list.html">Blog list</a></li>
							<li><a href="blog-column.html">Blog column</a></li>
							<li><a href="blog-masonry.html">Blog masonry</a></li>
							<li><a href="blog-detail.html">Blog detail</a></li>
							<li><a href="blog-home.html">Featured home</a></li>
							<li><a href="blog-new.html">Add new blog</a></li>
							<li><a href="blog-comments.html">Comments</a></li>
						</ul>
					</li>
					<li>
						<a href="#fakelink">
							<i class="fa fa-users icon-sidebar"></i>
							<i class="fa fa-angle-right chevron-icon-sidebar"></i>
							Social apps
						</a>
						<ul class="submenu">
							<li><a href="social-home.html">Home activity</a></li>
							<li><a href="social-my-profile.html">My profile</a></li>
							<li><a href="social-friendlist.html">Friend list <span
										class="badge badge-info span-sidebar">5</span></a></li>
							<li><a href="social-timeline.html">Timeline</a></li>
							<li><a href="social-photos.html">Photos</a></li>
						</ul>
					</li>
					<li>
						<a href="#fakelink">
							<i class="fa fa-heart icon-sidebar"></i>
							<i class="fa fa-angle-right chevron-icon-sidebar"></i>
							Example pages
						</a>
						<ul class="submenu">
							<li><a href="login.html">Login</a></li>
							<li><a href="lock-screen.html">Lock screen</a></li>
							<li><a href="forgot-password.html">Forgot password</a></li>
							<li><a href="register.html">Register</a></li>
							<li><a href="example-pricing-table.html">Pricing table</a></li>
							<li><a href="example-invoice.html">Invoice</a></li>
							<li><a href="example-faq.html">FAQ</a></li>
							<li><a href="example-search.html">Search page</a></li>
							<li><a href="example-media-library.html">Media library</a></li>
							<li><a href="404.html">404</a></li>
							<li><a href="blank.html">Blank page</a></li>
						</ul>
					</li>

					<li class="static">SYSTEM SETTING</li>
					<li class="text-content">
						<div class="switch">
							<div class="onoffswitch blank">
								<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="alertme"
								       checked>
								<label class="onoffswitch-label" for="alertme">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</div>
						Alert me when system down
					</li>
					<li class="text-content">
						<div class="switch">
							<div class="onoffswitch blank">
								<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="autoupdate">
								<label class="onoffswitch-label" for="autoupdate">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</div>
						Automatic update
					</li>
					<li class="text-content">
						<div class="switch">
							<div class="onoffswitch blank">
								<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="dailyreport">
								<label class="onoffswitch-label" for="dailyreport">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</div>
						Daily task report
					</li>
					<li class="text-content">
						<div class="switch">
							<div class="onoffswitch blank">
								<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
								       id="remembercomputer" checked>
								<label class="onoffswitch-label" for="remembercomputer">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</div>
						Remember this computer
					</li>
				</ul>
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

					<?php echo $this->fetch('content'); ?>

				</div>
				<!-- /.container-fluid -->


				<!-- BEGIN FOOTER -->
				<footer>
					&copy; 2014 <a href="#fakelink">Your company</a><br/>
					Design by <a href="http://isohdesign.com/" target="_blank">ids</a>. Purchase this item at <a
						href="http://goo.gl/wSCjxD" target="_blank">Themeforest</a>
				</footer>
				<!-- END FOOTER -->


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
			echo $this->Html->script(array(
				'jquery.min',
				'bootstrap.min',
				'/plugins/retina/retina.min',
				'/plugins/nicescroll/jquery.nicescroll',
				'/plugins/slimscroll/jquery.slimscroll.min',
				'/plugins/backstretch/jquery.backstretch.min',
			));
			echo $this->fetch('footer_script');
			echo $this->Html->script(array(
				'apps',
				'demo-panel',
			));
		?>
	</body>
</html>