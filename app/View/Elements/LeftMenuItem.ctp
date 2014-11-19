<?php
/**
 * Element hiển thị menu item
 * Các thuộc tính:
 *
 *  items => array, Các item
 *  deep => int, Độ sâu hiện tại
 */

if(!isset($deep)){
	$deep = 0;
}
foreach($items as $item){
	?>
	<li>
		<a href="<?php echo !empty($item['url'])?$item['url']:'#'; ?>">
			<?php
				if($deep == 0 && $item['icon']){
					echo '<i class="fa fa-'.$item['icon'].' icon-sidebar"></i>';
				}
			?>
			<?php echo __($item['title']); ?>
			<?php echo $item['content']; ?>
		</a>
		<?php
		if(!empty($item['childrens'])){
			echo '<ul class="submenu">';
			echo $this->element('LeftMenuItem', array(
				'items'=>$item['childrens'],
				'deep'=>$deep + 1
			));
			echo '</ul>';
		}
		?>
	</li>
<?php
}
?>