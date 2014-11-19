<?php
$this->start('sidebar-left');
echo $this->element('SlidebarLeft', array('tree'=>$slidebar_left_tree));
$this->end();
?>
Tree
<pre><?php print_r($slidebar_left_tree); ?></pre>