<div class="top-main-navigation">
    <nav class="navbar square navbar-default no-border" role="navigation">
        <div class="container-fluid">

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="top-main-navigation">
                <ul class="nav navbar-nav">
                    <li>                        
                        <a href="<?php echo $this->Html->url(array('controller' => 'admin', 'action' => 'dashboard')); ?>">
                            <span class="hidden-xs"><i class="fa fa-dashboard"></i></span>
                            <span class="hidden-xs">&#32;&#32;Trang chủ</span></a>
                        </a>
                    </li>

                    <li>                        
                        <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'index')); ?>">
                            <span class="hidden-xs"><i class="fa fa-users"></i></span>
                            <span class="hidden-xs">&#32;&#32;Người dùng</span></a>
                        </a>
                    </li>

                    <li>                        
                        <a href="<?php echo $this->Html->url(array('controller' => 'roles', 'action' => 'index')); ?>">
                            <span class="hidden-xs"><i class="fa fa-cogs"></i></span>
                            <span class="hidden-xs">&#32;&#32;Nhóm</span></a>
                        </a>
                    </li>

                    <li>                        
                        <a href="<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'index')); ?>">
                            <span class="hidden-xs"><i class="fa fa-unlock-alt"></i></span>
                            <span class="hidden-xs">&#32;&#32;Quyền truy cập</span></a>
                        </a>
                    </li>

	                <li>
		                <a href="<?php echo $this->Html->url(array('controller' => 'fileManagers', 'action' => 'index')); ?>">
			                <span class="hidden-xs"><i class="fa fa-folder"></i></span>
			                <span class="hidden-xs">&#32;&#32;Quản lý tập tin</span></a>
		                </a>
	                </li>

	                <li>
		                <a href="<?php echo $this->Html->url(array('controller' => 'notification', 'action' => 'index')); ?>">
			                <span class="hidden-xs"><i class="fa fa-bell"></i></span>
			                <span class="hidden-xs">&#32;&#32;Thông báo</span></a>
		                </a>
	                </li>

	                <li>
		                <a href="<?php echo $this->Html->url(array('controller' => 'BaoCao', 'action' => 'index')); ?>">
			                <span class="hidden-xs"><i class="fa fa-file"></i></span>
			                <span class="hidden-xs">&#32;&#32;Báo cáo</span></a>
		                </a>
	                </li>

	                <li>
		                <a href="<?php echo $this->Html->url(array('controller' => 'Calendar', 'action' => 'index')); ?>">
			                <span class="hidden-xs"><i class="fa fa-calendar"></i></span>
			                <span class="hidden-xs">&#32;&#32;Lịch</span></a>
		                </a>
	                </li>





                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <!-- End inverse navbar -->
</div>