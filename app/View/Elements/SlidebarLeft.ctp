<?php
/**
 * Element hiển thị Slidebar left menu
 * Các thuộc tính:
 *
 *  tree => array, Cấu trúc dạng cây
 */
?>
<ul class="sidebar-menu">
	<?php
		echo $this->element('LeftMenuItem', array('items'=>$tree));
	?>
</ul>