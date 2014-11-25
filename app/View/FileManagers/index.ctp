<?php
echo $this->Html->css( 'jsTree/default/style.min' );
echo $this->Html->css( 'filemanager' );
?>
<div id="file_manager_content">
	<div class="row">
		<div class="col-xs-12">
			<div class="progress no-rounded progress-striped active">
				<div class="progress-bar progress-bar-info" style="width: 60%">
					<span class="sr-only">Loading...</span>
				</div>
			</div>
		</div>
	</div>
</div>


<?php
echo $this->Html->script( 'handlebars' );
echo $this->Html->script( 'plupload/plupload.full.min' );
//echo $this->Html->script( 'plupload/jquery.plupload.queue/jquery.plupload.queue.min' );

echo $this->Html->script( 'madnh_file_manager' );
//echo $this->Html->script( 'myfiles' );
?>
<script>
	MaDnh.addInitCommand(function () {
		MaDnh.Template.compileAll();

		MaDnhFileManager.config({
			fetch_item_url: '<?php echo Router::url(array('controller' => $this->name, 'action' => 'folderItems')); ?>',
			create_folder_url: '<?php echo Router::url(array('controller' => $this->name, 'action' => 'createFolder')); ?>',
			folder_tree_url: '<?php echo Router::url(array('controller' => $this->name, 'action' => 'getFolderTree')); ?>',
			folder_content_holder: '#folder_items'
		});

		MaDnhFileManager.configUploader({
			url: '<?php echo Router::url(array('controller' => $this->name, 'action' => 'upload')); ?>',
			flash_swf_url: '/js/plupload/Moxie.swf',
			silverlight_xap_url: '/js/plupload/Moxie.xap'
		});

		function loadFileManager(){
			var ajax = new MaDnh.AJAXWorker();

			var load_fail = '<div class="alert alert-danger square">Tải trình quản lý không thành công!</div>';
			ajax.option({
				dataType: 'json',
				requestPath: '<?php echo Router::url(array('controller' => $this->name, 'action' => 'getFileManager')); ?>',
				successFunc: function(data){
					if(data.hasData('content')){
						$('#file_manager_content').html(data.getData('content'));
					}else{
						$('#file_manager_content').html(load_fail);
					}
				},
				errorFunc: function(){
					$('#file_manager_content').html(load_fail);
				}
			});
			ajax.request();
		}
		loadFileManager();


	}, MaDnh.Priority.hightest_priority);
</script>
