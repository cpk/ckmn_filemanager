<script type="text/javascript"> var action = '<?php echo $action ?>'; </script>
<script type="text/javascript"> var id = '<?php echo $id ?>'; </script>
<script src="<?php echo $webroot; ?>/js/role.js"></script>
<div class="the-box">
    <?php
     echo $this->element('role_form');
     ?>
</div>