<script type="text/javascript"> var action = '<?php echo $action ?>'; </script>
<script type="text/javascript"> var webroot = '<?php echo $webroot ?>'; </script>
<script src="<?php echo $webroot; ?>/js/role.js"></script>
<div class="toolbar">
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'roles', 'action' => 'index')); ?>">
            <i class="fa fa-list-alt"></i> List
        </a>
    </div>
</div>
<div class="the-box">
    <?php
     echo $this->element('role_form');
     ?>
</div>