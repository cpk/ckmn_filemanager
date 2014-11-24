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
			<button type="button" class="btn btn-danger" data-toggle="tooltip" title="Xóa">
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
	<tr>
		<td>
			<input type="checkbox" name="item[]" value="{{item_id}}"/>
		</td>
		<td>
			<img src="/img/filemanager/files/archive-v3.png" class="avatar">{{{item_name}}}
		</td>
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
			<input type="checkbox" class="item-checkbox" name="item[]" value="{{item_id}}"/>
		</td>
		<td>
			<img src="/img/filemanager/files/folder-v5.png" class="avatar">{{{item_name}}}
		</td>
		<td>
			&nbsp;
		</td>
		<td>{{item_human_create_time}}</td>
		<td>&nbsp;</td>
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

					<div class="drag_drop">
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
							<button class="btn btn-inverse stop_upload">
								<span>Dừng tải lên</span>
							</button>
							<button class="btn btn-primary start_upload">
								<span>Bắt đầu tải lên</span>
							</button>
							<button type="button" class="btn btn-default close-uploader" data-dismiss="modal" style="display: none;">Đóng</button>
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


<script>
	MaDnh.Template.compileAll();
	MaDnhFileManager.loadItems();
	$('#check_all').on('change', function () {
		MaDnh.DOM.setTableCheckboxsStatus('.table-contents', $(this).prop('checked'))
	});
</script>