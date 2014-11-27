<div class="row">
    <div class="col-xs-12 col-sm-9">
        <div class="well" style="background-color: #fff;">
            <ul class="media-list">
                <?php
                foreach ($notifications as $key => $notification) {
                    ?>
                    <li class="media">
                        <div class="media-body">
                            <h4 class="media-heading">
                                <a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'read', $key)); ?>">
                                    <img src="<?php echo $webroot; ?>/img/avatar/avatar-<?php echo $notification['User']['id']; ?>.jpg" class="avatar img-circle" alt="Avatar">
                                    <?php
                                    if ($notification['Notification']['status'] == 0) {
                                        echo '<strong>'.$notification['User']['first_name'].' '.$notification['User']['last_name'].' '.$notifyMessage[$notification['Notification']['type']].'</strong> <span class="badge badge-danger">Chưa xem!</span>';
                                    } else {
                                        echo $notification['User']['first_name'].' '.$notification['User']['last_name'].' '.$notifyMessage[$notification['Notification']['type']];
                                    }
                                    ?>
                                </a>
                            </h4>

                            <p class="text-muted">
                                <span><?php echo $notification['Notification']['date_create']; ?></span>
                            </p>

                            <p>
                                <?php echo $notification['Notification']['content']; ?>
                            </p>
                        </div>
                        <hr/>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <div class="text-center">
                <ul class="pagination">
                    <li><a href="#">&laquo;</a></li>
                    <li class="active bg-info"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-3">
        <div class="list-group">
            <a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'index')); ?>" class="list-group-item active list-group-item-info">Thông báo Công ty</a>
            <a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'index')); ?>" class="list-group-item">Thông báo hành chính</a>
            <a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'index')); ?>" class="list-group-item">Khen thưởng</a>
        </div>
    </div>
</div>