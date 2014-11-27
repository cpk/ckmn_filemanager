<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Sentir, Responsive admin and dashboard UI kits template">
        <meta name="keywords" content="admin,bootstrap,template,responsive admin,dashboard template,web apps template">
        <meta name="author" content="Ari Rusmanto, Isoh Design Studio, Warung Themes">
        <title>SENTIR - Responsive admin and dashboard UI kits template</title>

        <?php echo $this->element('css'); ?> 


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
        <!-- BEGIN PANEL DEMO -->
        <?php echo $this->element('panel'); ?>
        <!-- END PANEL DEMO -->
        <div class="wrapper">
            <!-- BEGIN TOP NAV -->
            <?php echo $this->element('topNav'); ?><!-- /.top-navbar -->
            <!-- END TOP NAV -->

            <!-- BEGIN TOP MAIN NAVIGATION -->
            <?php echo $this->element('topMainNav'); ?><!-- /.top-main-navigation -->
            <!-- END TOP MAIN NAVIGATION -->

            <!-- BEGIN SIDEBAR LEFT -->
            <?php // echo $this->element('sidebarLeft'); ?><!-- /.sidebar-left -->
            <!-- END SIDEBAR LEFT -->



            <?php echo $this->element('sidebarRight'); ?>



            <!-- BEGIN PAGE CONTENT -->
            <div class="page-content no-left-sidebar">
                <div class="container-fluid">	

                    <!-- Begin page heading -->

                    <!-- End page heading -->
                    <?php echo $this->element('heading'); ?>
                    <!-- Begin breadcrumb -->
                    <?php // echo $this->element('breadcrumb'); ?>
                    <!-- End breadcrumb -->
                    <!--
                    ===========================================================
                    Placed at the end of the document so the pages load faster
                    ===========================================================
                    -->
                    <?php echo $this->element('js'); ?>
                    <!-- Begin content -->
                    <?php echo $content_for_layout ?>
                    <!-- End content -->

                </div><!-- /.container-fluid -->



                <!-- BEGIN FOOTER -->
                <?php echo $this->element('footer'); ?>
                <!-- END FOOTER -->


            </div><!-- /.page-content -->
        </div><!-- /.wrapper -->
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
        <script>
		    MaDnh.init();
	    </script>
    </body>
</html>