<div class="top-main-navigation">
    <nav class="navbar square navbar-default no-border" role="navigation">
        <div class="container-fluid">

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="top-main-navigation">
                <ul class="nav navbar-nav">
                    <li>                        
                        <a href="<?php echo $this->Html->url(array('controller' => 'admin', 'action' => 'dashboard')); ?>">
                            <span class="hidden-xs"><i class="fa fa-dashboard"></i></span>
                            <span class="hidden-xs">&#32;&#32;Dashboard</span></a>
                        </a>
                    </li>

                    <li>                        
                        <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'index')); ?>">
                            <span class="hidden-xs"><i class="fa fa-users"></i></span>
                            <span class="hidden-xs">&#32;&#32;User</span></a>
                        </a>
                    </li>

                    <li>                        
                        <a href="<?php echo $this->Html->url(array('controller' => 'roles', 'action' => 'index')); ?>">
                            <span class="hidden-xs"><i class="fa fa-cogs"></i></span>
                            <span class="hidden-xs">&#32;&#32;Roles</span></a>
                        </a>
                    </li>

                    <li>                        
                        <a href="<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'index')); ?>">
                            <span class="hidden-xs"><i class="fa fa-unlock-alt"></i></span>
                            <span class="hidden-xs">&#32;&#32;Permissions</span></a>
                        </a>
                    </li>

                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <!-- End inverse navbar -->
</div>