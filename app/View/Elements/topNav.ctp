<div class="top-navbar dark-color">
    <div class="top-navbar-inner">

        <!-- Begin Logo brand -->
        <div class="logo-brand">
            <a href="#">
                <img height="100%" src="<?php echo $webroot; ?>/img/logo_02.png" alt="Sentir logo" class="float-left" style="margin-left: 50px;margin-right: 0px">
                <span style="line-height: 10px">10010011<br/>ABC</span>
            </a>
        </div><!-- /.logo-brand -->
        <!-- End Logo brand -->

        <div class="top-nav-content main-top-nav-layout">

            <!-- Begin button sidebar left toggle -->
            <div class="btn-collapse-main-navigation" data-toggle="collapse" data-target="#top-main-navigation">
                <i class="fa fa-bars"></i>
            </div><!-- /.btn-collapse-sidebar-left -->
            <!-- End button sidebar left toggle -->

            <!-- Begin button sidebar right toggle -->
<!--            <div class="btn-collapse-sidebar-right">
                <i class="fa fa-bullhorn"></i>
            </div> /.btn-collapse-sidebar-right -->
            <!-- End button sidebar right toggle -->

            <!-- Begin button nav toggle -->
            <div class="btn-collapse-nav" data-toggle="collapse" data-target="#main-fixed-nav">
                <i class="fa fa-plus icon-plus"></i>
            </div><!-- /.btn-collapse-sidebar-right -->
            <!-- End button nav toggle -->


            <!-- Begin user session nav -->
            <ul class="nav-user navbar-right">
                <li class="dropdown">
                    <a href="#fakelink" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo $webroot; ?>/img/avatar/avatar-<?php echo $currentUser['id']; ?>.jpg" class="avatar img-circle" alt="Avatar">
                        Hi, <strong><?php echo $currentUser['username']; ?></strong>
                    </a>
                    <ul class="dropdown-menu square primary margin-list-rounded with-triangle">
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'account_setting')); ?>">Account setting</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'change_password')); ?>">Change password</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'logout')); ?>">Log out</a></li>
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
                            <?php
                            $max = count($notifications)>10?10:count($notifications);
                            ?>
                            <span class="badge badge-danger icon-count"><?php echo $newCount; ?></span>
                            <i class="fa fa-bell"></i>
                        </a>
                        <ul class="dropdown-menu square with-triangle">
                            <li>
                                <div class="nav-dropdown-heading">
                                    Thông báo
                                </div><!-- /.nav-dropdown-heading -->
                                <div class="nav-dropdown-content scroll-nav-dropdown">
                                    <ul>
                                        <?php
                                        
                                        for($i=0; $i<$max; $i++){
                                            $notification = $notifications[$i];
                                        ?>                                        
                                        <li class="<?php echo ($notification['Notification']['status'] == 0)? 'unread':'' ?>">
                                            <a href="<?php echo $webroot.$notifyLink[$notification['Notification']['type']] ?>">
                                                <img src="<?php echo $webroot; ?>/img/avatar/avatar-<?php echo $notification['User']['id']; ?>.jpg" class="absolute-left-content img-circle" alt="Avatar">
                                                <strong><?php echo $notification['User']['first_name'].' '.$notification['User']['last_name']; ?>
                                                    </strong> <?php echo $notifyMessage[$notification['Notification']['type']]; ?>
                                                <span class="small-caps">
                                                <?php
                                                $today = strtotime(date('Y-m-d h:m:s'));
                                                $dateCreate = strtotime($notification['Notification']['date_create']);
                                                $todayYear = date('Y', $today);
                                                $todayMonth = date('m', $today);
                                                $todayDay = date('d', $today);
                                                $todayHour = date('h', $today);
                                                $todayMin = date('m', $today);
                                                $todaySec = date('s', $today);
                                                $dateCreateYear = date('Y', $dateCreate);
                                                $dateCreateMonth = date('m', $dateCreate);
                                                $dateCreateDay = date('d', $dateCreate);
                                                $dateCreateyHour = date('h', $dateCreateDay);
                                                $dateCreateMin = date('m', $dateCreate);
                                                $dateCreateSec = date('s', $dateCreate);
                                                $yearAgo = $todayYear - $dateCreateYear;
                                                $monthAgo = $todayMonth - $dateCreateMonth;
                                                $dayAgo = $todayDay - $dateCreateDay;
                                                $hourAgo = $todayHour - $dateCreateyHour;
                                                $minAgo = $todayMin - $dateCreateMin;
                                                $secAgo = $todaySec - $dateCreateSec;
                                                $timeAgo = '';
                                                if($yearAgo > 0){
                                                    $timeAgo .= $yearAgo.' năm ';
                                                }
                                                if($monthAgo > 0){
                                                    $timeAgo .= $monthAgo.' tháng ';
                                                }
                                                if($dayAgo > 0){
                                                    $timeAgo .= $dayAgo.' ngày ';
                                                }
                                                if($hourAgo > 0){
                                                    $timeAgo .= $hourAgo.' giờ ';
                                                }
                                                if($minAgo > 0){
                                                    $timeAgo .= $minAgo.' phút ';
                                                }
                                                if($secAgo > 0){
                                                    $timeAgo .= $secAgo.' giây ';
                                                }
                                                $timeAgo .= ' trước';
                                                echo $timeAgo;
                                                ?>
                                                </span>
                                            </a>
                                        </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div><!-- /.nav-dropdown-content scroll-nav-dropdown -->
                                <a href="<?php echo $this->Html->url(array('controller' => 'notification', 'action' => 'index')); ?>" class="btn btn-primary btn-square btn-block">Xem tất cả thông báo</a>
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
                        <ul class="dropdown-menu square with-triangle">
                            <li>
                                <div class="nav-dropdown-heading">
                                    Nhắc nhở
                                </div><!-- /.nav-dropdown-heading -->
                                <div class="nav-dropdown-content scroll-nav-dropdown">
                                    <ul>
                                        <li class="unread">
                                            <a href="#fakelink">
                                                <i class="fa fa-check-circle-o absolute-left-content icon-task completed"></i>
                                                Báo cáo thuế.
                                                <span class="small-caps">hôm nay</span>
                                            </a>
                                        </li>
                                        <li class="unread">
                                            <a href="#fakelink">
                                                <i class="fa fa-check-circle-o absolute-left-content icon-task completed"></i>
                                                Thu quỹ.
                                                <span class="small-caps">ngày mai</span>
                                            </a>
                                        </li>
                                        <li class="unread">
                                            <a href="#fakelink">
                                                <i class="fa fa-check-circle-o absolute-left-content icon-task completed"></i>
                                                Họp hội đồng.
                                                <span class="small-caps">hôm mai</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div><!-- /.nav-dropdown-content scroll-nav-dropdown -->
                                <a href="#" class="btn btn-primary btn-square btn-block">Xem tất cả nhắc nhở</a>
                            </li>
                        </ul>
                    </li>
                    <!-- End nav task -->
                    
                </ul>
            </div><!-- /.navbar-collapse -->
            <!-- End Collapse menu nav -->
        </div><!-- /.top-nav-content -->
    </div><!-- /.top-navbar-inner -->
</div>