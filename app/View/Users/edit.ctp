<?php echo $this->Html->script('jquery.validate.min'); ?>
<?php echo $this->Html->script('jquery.validate.extended'); ?>
<script src="<?php echo $webroot; ?>js/user.js"></script>
<script type="text/javascript"> var action = '<?php echo $action ?>'; </script>
<script type="text/javascript"> var id = '<?php echo $id ?>'; </script>
<div class="toolbar">
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'index')); ?>">
            <i class="fa fa-list-alt"></i> List
        </a>
    </div>
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'show', $user['User']['id'])); ?>">
            <i class="fa fa-info"></i> View
        </a>
    </div>
</div>
<div class="the-box">
    <?php
     echo $this->element('user_form');
     ?>
</div>