<li class="cf" data-created="<?php echo $item['item_create_time']; ?>"
    data-type="<?php echo $item['item_type']; ?>"
	<?php
	if ( $item['item_type'] != 'folder' ) {
		?>
		data-downloads="<?php echo $item['item_downloads']; ?>"
		data-size="<?php echo $item['item_size']; ?>"
	<?php
	}
	?>
    data-id="<?php echo $item['item_id']; ?>"
    title="<?php echo $item['item_type'] == 'folder' ? 'Thư mục' : 'Tập tin'; ?>">
	<?php
	echo '<a href="#' . $item['item_id'] . '" class="thumbnailClickArea" title="' . htmlentities( $item['item_name'] ) . '" target="' . $target . '"></a>';
	?>

	<div class="grip_column">
		<div class="checkbox-custom" title="Select/Deselect Item"></div>
		<img src="/img/1x1_transparent.Gif" alt="" class="dragfile_icon" width="30" height="45" border="0"/>
	</div>
	<div class="filetype_column">
		<div class="filetype-<?php echo $item['item_type']; ?>"></div>
	</div>
	<div class="file_maindetails">
		<span class="created"><?php echo $item['item_human_create_time']; ?></span>
		<?php
		if ( isset( $item['item_size'] ) ) {
			echo '<span class="size">' . $number_helper->toReadableSize( $item['item_size'] ) . '</span>';
		}
		?>
		<span class="downloads">
		<?php
		if ( isset( $item['item_downloads'] ) ) {
			echo $item['item_downloads'];
		} else {
			echo '---';
		}
		?>
	</span>
	</div>
	<div class="info cf">
		<div class="filename_outer">
			<a class="foldername" href="#<?php echo $item['item_id']; ?>"
			   target="<?php echo $target; ?>">
				<span class="info-name"><?php echo $item['item_name']; ?></span>
				<span class="extraInfo"><?php echo $item['item_extra_info']; ?></span>
			</a>

			<div class="itemStatus"></div>

		</div>
	</div>
</li>