<div class="row">
	<div class="span3" id="folder_nav">

	</div>

	<div class="col-xs-12 col-sm-3" id="folder_nav">
		<!-- Navigation folder -->
		<ul class="list-unstyled">
			<li id="myfiles" class="expanded curent" data-folderid="0">
				<a href="javascript:void(0);" class="folder_arrow"></a>
				<a href="javascript:void(0);" class="folder_name" title="My Files" onclick="MaDnhFileManager.setCurrentFolder(0);">My Files</a>
				<ul class="list-unstyled" id="folder_tree"></ul>
			</li>

		</ul>
	</div>
	<!--	Folder items-->
	<div class="col-xs-12 col-sm-9">
		<div class="well" style="background-color:#fff;">
			<div class="btn-toolbar">
				<div class="btn-group">
					<button type="button" class="btn btn-danger" id="upload_button" data-toggle="tooltip"
					        title="Upload dữ liệu" onclick="MaDnhFileManager.loadUploader()">
						<i class="fa fa-upload"></i> Upload
					</button>

				</div>
				<div class="btn-group">
					<button type="button" class="btn btn-success" data-toggle="tooltip" title="Tạo thư mục"
					        onclick="MaDnhFileManager.createFolder()">
						<i class="fa fa-plus"></i> Tạo thư mục
					</button>

				</div>

				<div class="btn-group" data-toggle="tooltip" title="Load lại dữ liệu">
					<button type="button" class="btn btn-info" onclick="MaDnhFileManager.loadFolderTree(); MaDnhFileManager.loadItems()">
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
					<button type="button" class="btn btn-danger" data-toggle="tooltip" title="Xóa"
					        onclick="MaDnhFileManager.deleteItems()">
						<i class="fa fa-trash-o"></i>
					</button>
				</div>
				<div class="btn-group">
					<button type="button" class="btn btn-info" data-toggle="tooltip" title="Chia sẻ">
						<i class="fa fa-send-o"></i>
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
			<!-- End Empty data -->
			<table class="table table-th-block table-contents">
				<thead>
				<tr>
					<th width="20">
						<input type="checkbox" id="check_all"/>
					</th>
					<th>Tên</th>
					<th>Size</th>
					<th>Date</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody id="folder_items">

				</tbody>


			</table>
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

		</div>
	</div>
	<!--	End Folder items-->
</div>


<script id="template_folder_content_item" type="text/x-handlebars-template">
	<tr id="folder_item_{{item_id}}" data-type="{{item_type}}" data-item-id="{{item_id}}">
		<td>
			<input type="checkbox" name="item[]" value="{{item_id}}"/>
		</td>
		<td>
			<img src="/img/filemanager/files/archive-v3.png" class="avatar">
			<a href="javascript:;" class="item-name">{{{item_name}}}</a>
		</td>
		<td>
			{{item_human_size}}
		</td>
		<td>{{item_human_create_time}}</td>
		<td>
			<div class="btn-group">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-cog"></i>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li>
						<a href="javascript:MaDnhFileManager.rename('{{item_type}}', '{{item_id}}', '{{{item_name}}}');">
							<i class="fa fa-pencil"></i> Đổi tên
						</a>
					</li>
				</ul>
			</div>
		</td>
	</tr>
</script>

<script id="template_folder_content_folder" type="text/x-handlebars-template">
	<tr id="folder_item_{{item_id}}" data-type="{{item_type}}" data-item-id="{{item_id}}">
		<td>
			<input type="checkbox" class="item-checkbox" name="item[]" value="{{item_id}}"/>
		</td>
		<td>
			<img src="/img/filemanager/files/folder-v5.png" class="avatar">
			<a href="javascript:;" class="item-name">{{{item_name}}}</a>
		</td>
		<td>
			&nbsp;
		</td>
		<td>{{item_human_create_time}}</td>
		<td>
			<div class="btn-group">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-cog"></i>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li>
						<a href="javascript:MaDnhFileManager.rename('{{item_type}}', '{{item_id}}', '{{{item_name}}}');">
							<i class="fa fa-pencil"></i> Đổi tên
						</a>
					</li>
				</ul>
			</div>
		</td>
	</tr>
</script>


<script id="template_uploader" type="text/x-handlebars-template">
	<div class="modal fade" id="{{{id}}}">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title">Tải tập tin từ máy tính</h4>
				</div>
				<div class="modal-body">

					<table class="table table-striped table-condensed table-hover">
						<thead>
						<tr>
							<!-- <th class="preview">Loại</th> -->
							<th class="name">Tên tập tin</th>
							<th class="size">Kích thước</th>
							<th class="status">Tình trạng</th>
						</tr>
						</thead>
						<tbody class="item_list">
						{{&uploadContent}}
						</tbody>
					</table>

					<div id="drag_drop"
					     style="margin: 10px auto; text-align: center; padding: 50px 0px; border: 5px dashed #aaa;">
						<p>Kéo và thả các tập tin vào đây để tải lên</p>
					</div>


				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-xs-12 col-sm-6 text-left">
							<button class="btn " id="add-files">
								<span class="fa fa-plus"></span>
							</button>
							<span class="upload_status">0 tập tin</span>
						</div>
						<div class="col-xs-12 col-sm-6">
							<button class="btn btn-inverse empty_list" title="Xóa danh sách" style="display:none;">
								<span class="fa fa-refresh"></span>
							</button>
							<button class="btn btn-inverse stop_upload" data-dismiss="modal">
								<span>Dừng tải lên</span>
							</button>
							<button class="btn btn-primary start_upload">
								<span>Bắt đầu tải lên</span>
							</button>
							<button type="button" class="btn btn-default close-uploader" data-dismiss="modal"
							        style="display: none;">Đóng
							</button>
						</div>
					</div>

				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div><!-- /.modal -->

</script>


<script id="template_uploader_item" type="text/x-handlebars-template">
	<tr class="template-upload" id="{{id}}">
		<td class="name"><span>{{name}}</span></td>
		<td class="size">{{humanReadableSize}}</td>
		<td class="status" style="text-align: center">
			<span class="label" style="display:none;">Error</span>

			<div class="progress no-rounded progress-striped active" style="display: none">
				<div class="progress-bar progress-bar-info " role="progressbar" style="width: 60%">
				</div>
			</div>
			<button class="btn" title="Xóa">
				<span class="fa fa-trash-o"></span>
			</button>
		</td>
	</tr>

</script>

<script id="template_folder_nav_item_nested" type="text/x-handlebars-template">
	{{#each this}}
	{{#if sub_folders}}
	<li data-folderid="{{id}}" class="collapsed">
		<a href="javascript:void(0);" class="folder_arrow"></a>
		<a href="javascript:void(0);" class="folder_name" title="Thu muc {{&folder_name}}">
			{{&folder_name}}
		</a>
		<ul class="list-unstyled">
			{{&folderNavItemWithNested sub_folders}}
		</ul>

	</li>
	{{else}}
	<li data-folderid="{{id}}">
		<a href="javascript:void(0);" class="folder_name" title="Thu muc {{&folder_name}}">
			{{{folder_name}}}
		</a>
	</li>
	{{/if}}
	{{/each}}
</script>
<script id="template_folder_nav_item" type="text/x-handlebars-template" charset="utf-8">
	<li data-folderid="{{id}}">
		<a href="javascript:void(0);" class="folder_name" title="Thu muc {{folder_name}}">{{{folder_name}}}</a>
	</li>
</script>


<script>
	MaDnh.Template.compileAll();
	Handlebars.registerHelper('folderNavItemWithNested', function (info) {
		return MaDnh.Template.render('folder_nav_item_nested', info);
	});

	MaDnhFileManager.loadFolderTree();
	MaDnhFileManager.loadItems();

	$("#folder_nav>ul").delegate('li>a.folder_name', "click", function (e) {
		e.stopPropagation();
		e.preventDefault();
		$("#folder_nav>ul").find('li.curent').removeClass('curent');
		$(this).parent().addClass('curent');
		if ($(this).parent().data('folderid')) {
			MaDnhFileManager.setCurrentFolder($(this).parent().data('folderid'));
			MaDnhFileManager.loadItems($(this).parent().data('folderid'));
		} else {
			MaDnhFileManager.loadItems();
		}
	}).delegate('li>a.folder_arrow', 'click', function (e) {
		if ($(this).parent().hasClass('expanded')) {
			$(this).parent().removeClass('expanded').addClass('collapsed').children('ul').first().slideUp('slow');
		} else if ($(this).parent().hasClass('collapsed')) {
			$(this).parent().removeClass('collapsed').addClass('expanded').children('ul').first().slideDown('slow');
		}
		e.preventDefault();

	});

	/*
	 Add click event to Main list item
	 */
	$('#folder_items').delegate('td a.item-name', 'click', function (e) {
		e.stopPropagation();
		var $this = $(this), row = $this.parents('tr').first(), id = row.data('item-id');
		if (row.data('type') == 'folder' && id) {
			e.preventDefault();
			MaDnhFileManager.selectFolderTreeItem(id);
			MaDnhFileManager.loadItems(id);
		} else {
			console.log('NO');
		}

	});

	$('#check_all').on('change', function () {
		MaDnh.DOM.setTableCheckboxsStatus('.table-contents', $(this).prop('checked'))
	});
</script>