<?php
echo $this->Html->css( 'jsTree/default/style.min' );
echo $this->Html->css( 'filemanager' );
?>
<div class="row">
	<div class="col-xs-12 col-sm-2">
		<div id="jstree_demo_div">
			<ul>
				<li>Root node 1</li>
				<li>Root node 2</li>
			</ul>
		</div>
	</div>
	<div class="col-xs-12 col-sm-10">
		<div class="well" style="background-color:#fff;">
			<div class="btn-toolbar">
				<div class="btn-group">
					<button type="button" class="btn btn-danger" id="upload_button" data-toggle="tooltip" title="Upload dữ liệu">
						<i class="fa fa-upload"></i> Upload
					</button>

				</div>
				<div class="btn-group">
					<button type="button" class="btn btn-success" data-toggle="tooltip" title="Tạo thư mục" onclick="MaDnhFileManager.createFolder()">
						<i class="fa fa-plus"></i> Tạo thư mục
					</button>

				</div>

				<div class="btn-group" data-toggle="tooltip" title="Load lại dữ liệu">
					<button type="button" class="btn btn-info" onclick="MaDnhFileManager.loadItems()">
						<i class="fa fa-refresh"></i>
					</button>
				</div>

				<div class="btn-group">
					<button type="button" class="btn btn-info" data-toggle="tooltip" title="Sao chép">
						<i class="fa fa-copy"></i>
					</button>
					<button type="button" class="btn btn-info" data-toggle="tooltip" title="Cắt">
						<i class="fa fa-cut"></i>
					</button>
					<button type="button" class="btn btn-info" data-toggle="tooltip" title="Dán">
						<i class="fa fa-paste"></i>
					</button>
				</div>
				<div class="btn-group">
					<button type="button" class="btn btn-info" data-toggle="tooltip" title="Chia sẻ">
						<i class="fa fa-share-alt"></i>
					</button>
				</div>


				<div class="btn-group">
					<button type="button" class="btn btn-info">Action</button>
					<button type="button" class="btn btn-info active dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu info" role="menu">
						<li><a href="#fakelink">Tên</a></li>
						<li><a href="#fakelink">Kích thước</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="well" id="myfiles_wrap">
			<!-- Slide Right -->
			<div id="loading_content" class="text-center"></div>
			<div id="emptyfolder_upload" class="text-center">
				<!-- Empty data -->
				<h3>Thư mục này hiện rỗng</h3>
				<h4>Tải lên hay tạo dữ liệu mới bằng menu "Thêm tập tin"
					<br/>
					hoặc kéo và thả dữ liệu từ máy tính của bạn. </h4>

				<div class="emptyArrow"></div>
				<div class="dragFileContainer">
					<div class="dragFile"></div>
				</div>
			</div>
			<!-- End Empty data -->
			<table class="table table-th-block table-contents">
				<thead>
					<tr>
						<th>Tên</th>
						<th>Size</th>
						<th>Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="folder_items">

				</tbody>


			</table>

		</div>


		<div class="row">

		</div>
		<!-- /.row -->


	</div>
</div>

<?php
echo $this->Html->script( 'madnh_file_manager' );
echo $this->Html->script( 'handlebars' );
//echo $this->Html->script( 'plupload/plupload.full.min' );
//echo $this->Html->script( 'myfiles' );
?>
<script>
	MaDnh.addInitCommand(function () {
		MaDnh.Template.compileAll();

		MaDnhFileManager.config({
			fetch_item_url: '<?php echo Router::url(array('controller' => $this->name, 'action' => 'folderItems')); ?>',
			create_folder_url: '<?php echo Router::url(array('controller' => $this->name, 'action' => 'createFolder')); ?>',
			folder_content_holder: '#folder_items'
		});

		MaDnhFileManager.loadItems();

		$('#upload_button').click(function(){
			MaDnh.Helper.alert('Chưa đâu cưng :D', function(){
				MaDnh.Helper.alert('ĐÃ BẢO LÀ CHƯA MÀ!!!!', function(){
					MaDnh.Helper.alert('Vậy hoy đi nha!', null, {
						title: 'Tôi bị điên',
						type: 'danger'
					});
				});
			}, {
				type:'primary'
			});
		});

	}, MaDnh.Priority.hightest_priority);
</script>
<script id="template_test" type="text/x-handlebars-template">
	Hello, {{name}}
</script>
<script id="template_folder_content_item" type="text/x-handlebars-template">
	<li class="cf" data-created="{{item_create_time}}" data-downloads="{{item_downloads}}" data-size="{{item_size}}"
	    data-type="{{item_type}}" data-id="{{item_id}}" title="Tập tin {{{item_name}}}">
		<a href="?{{item_id}}" class="thumbnailClickArea" title="{{{item_name}}}" target="_blank"></a>

		<div class="grip_column">
			<div class="checkbox-custom" title="Select/Deselect Item"></div>
			<img class="dragfile_icon" width="30" height="45" src="/img/1x1_transparent.gif" border="0">
		</div>
		<div class="filetype_column">
			<div class="filetype-{{item_type}}"></div>
		</div>
		<div class="file_maindetails">
			<span class="created">{{item_human_create_time}}</span>
			<span class="size">{{item_human_size}}</span>
		<span class="downloads">
			{{#if item_downloads}}
				{{item_downloads}}
			{{else}}
			--
			{{/if}}
		</span>
		</div>
		<div class="info cf">
			<div class="filename_outer">
				<a class="foldername" href="/{{item_id}}" target="_blank">
					<span class="info-name">{{{item_name}}}</span>
					<span class="extraInfo">{{{item_extra_info}}}</span>
				</a>
				<input type="text" value="{{{item_name}}}" id="rename-{{item_id}}" class="updatename"
				       style="display:none;">

				<div class="itemStatus"></div>
			</div>
		</div>
	</li>
</script>

<script id="template_folder_content_folder" type="text/x-handlebars-template">
	<li class="cf" data-created="{{item_create_time}}" data-downloads="{{item_downloads}}" data-size="{{item_size}}"
	    data-type="{{item_type}}" data-id="{{item_id}}" title="Thư mục {{{item_name}}}">
		<a href="?{{item_id}}" class="thumbnailClickArea" title="{{item_name}}" target="_blank"></a>

		<div class="grip_column">
			<div class="checkbox-custom" title="Select/Deselect Item"></div>
			<img class="dragfile_icon" width="30" height="45" src="/img/1x1_transparent.gif" border="0">
		</div>
		<div class="filetype_column">
			<div class="filetype-{{item_type}}"></div>
		</div>
		<div class="file_maindetails">
			<span class="created">{{item_human_create_time}}</span>
			<span class="size">{{item_human_size}}</span>
		</div>
		<div class="info cf">
			<div class="filename_outer">
				<a class="foldername" href="#" target="_self">
					<span class="info-name">{{{item_name}}}</span>
					<span class="extraInfo">{{{item_extra_info}}}</span>
				</a>

				<div class="itemStatus"></div>
			</div>
		</div>
	</li>
</script>


<script id="template_folder_content2_item" type="text/x-handlebars-template">
	<tr >
		<td>
			<img src="/img/filemanager/files/archive-v3.png" class="avatar">{{{item_name}}}</td>
		<td>
			{{item_human_size}}
		</td>
		<td>{{item_human_create_time}}</td>
		<td>&nbsp;</td>
	</tr>
</script>

<script id="template_folder_content2_folder" type="text/x-handlebars-template">
	<tr>
		<td>
			<img src="/img/filemanager/files/folder-v5.png" class="avatar">{{{item_name}}}</td>
		<td>
			&nbsp;
		</td>
		<td>{{item_human_create_time}}</td>
		<td>&nbsp;</td>
	</tr>
</script>