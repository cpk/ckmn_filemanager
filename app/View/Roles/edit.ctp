<script type="text/javascript"> var action = '<?php echo $action ?>'; </script>
<script type="text/javascript"> var id = '<?php echo $id ?>'; </script>
<script src="<?php echo $webroot; ?>js/role.js"></script>
<div class="toolbar">
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'roles', 'action' => 'index')); ?>">
            <i class="fa fa-list-alt"></i> List
        </a>
    </div>
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'roles', 'action' => 'show', $role['Role']['id'])); ?>">
            <i class="fa fa-info"></i> View
        </a>
    </div>
</div>
<div class="the-box">
    <?php
     echo $this->element('role_form');
     ?>
</div>