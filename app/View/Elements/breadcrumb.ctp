<ol class="breadcrumb success">
    <li><a href="<?php echo $this->Html->url(array('controller' => $controller, 'action' => 'index')); ?>"><?php echo $controller; ?></a></li>
    <li><a href="<?php echo $this->Html->url(array('controller' => $controller, 'action' => $action)); ?>"><?php echo isset($heading)? $heading: ""; ?></a></li>
</ol>