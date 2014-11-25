<script type="text/javascript"> var action = '<?php echo $action ?>'; </script>
<script type="text/javascript"> var id = '<?php echo $id ?>'; </script>
<div class="toolbar">
    <div class="float-left">
        <a href="<?php echo $this->Html->url(array('controller' => 'permissions', 'action' => 'index')); ?>">
            <i class="fa fa-list-alt"></i> List
        </a>
    </div>
</div>
<div class="the-box">
    <?php
     echo $this->element('permission_form');
     ?>
</div>