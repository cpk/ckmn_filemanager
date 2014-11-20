<!-- BEGIN SIDEBAR RIGHT HEADING -->
<div class="sidebar-right-heading">
    <ul class="nav nav-tabs square nav-justified">
        <li class="active"><a href="#online-user-sidebar" data-toggle="tab"><i class="fa fa-comments"></i></a></li>
        <li><a href="#notification-sidebar" data-toggle="tab"><i class="fa fa-bell"></i></a></li>
        <li><a href="#task-sidebar" data-toggle="tab"><i class="fa fa-tasks"></i></a></li>
        <li><a href="#setting-sidebar" data-toggle="tab"><i class="fa fa-cogs"></i></a></li>
    </ul>
</div><!-- /.sidebar-right-heading -->
<!-- END SIDEBAR RIGHT HEADING -->



<!-- BEGIN SIDEBAR RIGHT -->
<div class="sidebar-right sidebar-nicescroller">
    <div class="tab-content">
        <?php echo $this->element('onlineSidebar'); ?><!-- /#online-user-sidebar -->
        <?php echo $this->element('notificationSidebar'); ?><!-- /#notification-sidebar -->
        <?php echo $this->element('taskSidebar'); ?><!-- /#task-sidebar -->
        <?php echo $this->element('settingSidebar'); ?><!-- /#setting-sidebar -->

    </div><!-- /.tab-content -->
</div><!-- /.sidebar-right -->
<!-- END SIDEBAR RIGHT -->