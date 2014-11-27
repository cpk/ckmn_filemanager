<div class="row">
    <div class="col-xs-12 col-sm-9">
        <div class="well" style="background-color: #fff;">
            <ul class="list-inline">	
                <li class="pull-right">
                    <img src="<?php echo $webroot; ?>/img/avatar/avatar-<?php echo $notification['User']['id']; ?>.jpg" class="avatar img-circle" alt="Avatar">
                    <strong><?php echo $notification['User']['first_name'] . ' ' . $notification['User']['last_name']; ?></strong>
                </li>			
                <li>
                    <span><?php echo $notification['Notification']['date_create']; ?></span>
                </li>
            </ul>
        </div>
        <div class="well" style="background-color: #fff;">			
            <p>
                <?php echo $notification['Notification']['content']; ?>
            </p>
            <div style="border-top: 1px dashed #ddd;">
                <p>
                    <strong>
                        Đính kèm:
                    </strong>
                </p>
                <ul class="attachment-list">
                    <li><a href="#fakelink">Cerita hantu part 2.docx</a> - <small>1,245 Kb</small></li>
                    <li><a href="#fakelink">List belanja bulan April.xlsx</a> - <small>32 Kb</small></li>
                    <li><a href="#fakelink">Tutorial membuat webset.pdf</a> - <small>35,245 Kb</small></li>
                    <li><a href="#fakelink">Cerita hantu part 3.docx</a> - <small>1,545 Kb</small></li>
                    <li><a href="#fakelink">Photo kenangan.zip</a> - <small>20,545 Kb</small></li>
                </ul>
                <button class="btn btn-info"><i class="fa fa-cloud-download"></i> Tải về tất cả</button>
            </div>

            <div style="margin-top:20px; border-top: 1px dashed #ddd;">
                <p>
                    <strong>Các thông báo khác</strong>
                </p>
                <ul class="list-unstyled">
                    <?php
                    $max = 5;
                    for ($i = 0; $i < $max; $i++) {
                        if ($i == $id) {
                            $max += 1;
                        } else {
                            $notification = $notifications[$i];
                            ?>
                            <li style="margin-bottom: 10px;">
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="#">
                                            <strong><?php echo $notification['User']['first_name'] . ' ' . $notification['User']['last_name']; ?>
                                            </strong> <?php echo $notifyMessage[$notification['Notification']['type']]; ?>
                                        </a>
                                    </h4>
                                    <p class="text-danger"><small><?php echo $notification['Notification']['date_create']; ?></small></p>
                                    <p><?php echo $notification['Notification']['content']; ?></p>
                                </div>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>

        </div>
    </div>
    <div class="col-xs-12 col-sm-3">
        <div class="list-group">
            <a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'index')); ?>" class="list-group-item active list-group-item-info">Thông báo Công ty</a>
            <a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'index')); ?>" class="list-group-item">Thông báo hành chính</a>
            <a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'index')); ?>" class="list-group-item">Khen thưởng</a>
            <a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'index')); ?>" class="list-group-item">Porta ac consectetur ac</a>
            <a href="<?php echo Router::url(array('controller' => $this->name, 'action' => 'index')); ?>" class="list-group-item">Vestibulum at eros</a>
        </div>
    </div>
</div>