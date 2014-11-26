(function () {
    var root = this;

    var MaDnhFileManager = function (obj) {
        if (obj instanceof MaDnhFileManager) {
            return obj;
        }
        if (!(this instanceof MaDnhFileManager)) {
            return new MaDnhFileManager(obj);
        }
    };
    root.MaDnhFileManager = MaDnhFileManager;
    var previousMaDnhFileManager = root.MaDnhFileManager;
    var __ = _;

    MaDnhFileManager.uploader = null;
    MaDnhFileManager._config = {
        fetch_item_url: '',
        folder_tree_url: '',
        create_folder_url: '',
        delete_item_url: '',
        rename_item_url: '',
        folder_tree_selector: '#folder_tree',
        container_selector: '#myfiles_wrap',
        folder_content_holder: '#folder_items',
        loading_selector: '#loading_content',
        drag_drop_selector: '#emptyfolder_upload',
        current_folder: '',
        uploader: {
            runtimes: 'html5,flash,html4',

            container: '',
            url: '',
            max_file_size: '50gb',
            mime_types: [],
            duplicates: true,
            chunk_size: 0,
            file_data_name: 'file',
            flash_swf_url: '',
            silverlight_xap_url: '',
            headers: {},
            max_retries: 0,
            multipart: true,
            send_data: {},
            multi_selection: true,
            features: {},
            resize: {},
            unique_names: false,
            rename: false,
            uploaded_callback: null
        },
        uploader_template: {
            template_name: 'uploader',
            file_item_name: 'uploader_item',
            item_list_selector: '.item_list',
            add_file_selector: 'add-files',
            drag_drop_selector: 'drag_drop',
            start_selector: ".start_upload",
            empty_list_selector: ".empty_list",
            stop_selector: ".stop_upload",
            progress_selector: '.total_progress',
            status_selector: '.upload_status',
            fileUploaded_callback: function (file) {
                console.log(file);
            }
        }
    };


    MaDnhFileManager.noConflict = function () {
        root.MaDnhFileManager = previousMaDnhFileManager;
        return this;
    };

    MaDnhFileManager.setUnderscore = function (underscore) {
        MaDnhFileManager.__ = underscore;
    };
    MaDnhFileManager.config = function (config) {
        MaDnhFileManager._config = __.extend({}, MaDnhFileManager._config, config);
    };
    MaDnhFileManager.configUploader = function (config) {
        MaDnhFileManager._config.uploader = __.extend({}, MaDnhFileManager._config.uploader, config);
    };
    MaDnhFileManager.configUploaderTemplate = function (config) {
        MaDnhFileManager._config.uploader_template = __.extend({}, MaDnhFileManager._config.uploader_template, config);
    };


    function createUploaderTemplate(option) {
        console.log('yahoa', option);
        if (MaDnh.Template.hasTemplate(MaDnhFileManager._config.uploader_template.template_name)) {
            return MaDnh.Template.render(MaDnhFileManager._config.uploader_template.template_name, option);
        }
        return '';
    }


    function createOption(uploader_id) {
        var option = {};
        var option_template = MaDnhFileManager._config.uploader_template;
        var uploader_config = MaDnhFileManager._config.uploader;

        console.log('uploader_config', uploader_config);
        option.id = uploader_id;
        option.runtimes = uploader_config.runtimes;
        if (option_template.add_file_selector) {
            option.browse_button = option_template.add_file_selector;
        }
        option.container = uploader_id;
        option.url = uploader_config.url;
        option.chunk_size = uploader_config.chunk_size;
        if (option.chunk_size) {
            option.required_features = 'chunks';
        }


        if (option_template.drag_drop_selector) {
            option.drop_element = option_template.drag_drop_selector;
        }


        if (option_template.drag_drop_selector) {
            option.drop_element = option_template.drag_drop_selector;
        }

        option.file_data_name = uploader_config.file_data_name;
        option.prevent_duplicates = !uploader_config.duplicates;
        option.flash_swf_url = uploader_config.flash_swf_url;
        option.headers = uploader_config.headers;
        option.max_retries = uploader_config.max_retries;
        option.multipart = uploader_config.multipart;
        option.multipart_params = __.extend({parent_id: MaDnhFileManager._config.current_folder}, uploader_config.send_data);
        option.multi_selection = uploader_config.multi_selection;
        option.silverlight_xap_url = uploader_config.silverlight_xap_url;
        option.unique_names = uploader_config.unique_names;
        option.rename = uploader_config.rename;

        uploader_config.resize = __.pick(uploader_config.resize, 'width', 'height', 'quality', 'crop');
        if (__.size(uploader_config.resize)) {
            option.resize = uploader_config.resize;
        }

        option.filters = {
            max_file_size: uploader_config.max_file_size,
            mime_types: uploader_config.mime_types
        };

        return option;
    }

    function handleStatus(file, option) {
        switch (file.status) {
            case plupload.DONE:
                $('#' + option.id + ' #' + file.id).addClass('success');
                if (file.status == plupload.DONE) {
                    $('#' + option.id + ' #' + file.id + " .status").html('<span class="label label-success">Thành công</span>');
                }
                break;
            case plupload.FAILED:
                $('#' + option.id + ' #' + file.id).addClass('error');
                $('#' + option.id + ' #' + file.id + " .status").html('<span class="label label-warning" role="tooltip" title="' + file.error + '">Có lỗi</span>');
                break;
            case plupload.UPLOADING:
                $('#' + option.id + ' #' + file.id).addClass('info');
                break;

            default:
        }
    }

    function updateTotalProgress(uploader, option, option_template) {
        $('#' + option.id + ' ' + option_template.status_selector).text("Đã tải lên " + uploader.total.uploaded + '/' + uploader.total.queued + ' tập tin, ' + plupload.formatSize(uploader.total.loaded) + '/ ' + plupload.formatSize(uploader.total.size));
        $("#" + option.id + ' ' + option_template.progress_selector + ' .progress-bar').css('width', uploader.total.percent + "%").text(uploader.total.percent + "%");
    }

    function updateList(uploader, option, option_template) {
        console.log('updateList');
        var fileList = $('#' + option.id + ' ' + option_template.item_list_selector), inputCount = 0, inputHTML;

        fileList.find('tr').remove();
        $.each(uploader.files, function (i, file) {
            inputHTML = '';
            if (file.status == plupload.DONE) {
                if (file.target_name) {
                    inputHTML += '<input type="hidden" name="' + option.id + '_' + inputCount + '_tmpname" value="' + plupload.xmlEncode(file.target_name) + '" />';
                }
                inputHTML += '<input type="hidden" name="' + option.id + '_' + inputCount + '_name" value="' + plupload.xmlEncode(file.name) + '" />';
                inputHTML += '<input type="hidden" name="' + option.id + '_' + inputCount + '_status" value="' + (file.status == plupload.DONE ? 'done' : 'failed') + '" />';

                inputCount++;

                $('#' + option.id + ' #' + option.id + '_count').val(inputCount);

            }
            file.humanReadableSize = plupload.formatSize(file.origSize);
            if (option_template.file_item_name && MaDnh.Template.hasTemplate(option_template.file_item_name)) {
                fileList.append(MaDnh.Template.render(option_template.file_item_name, file));
                $('#' + option.id + ' ' + option_template.item_list_selector).show();
                $('#' + option.id + ' #' + option_template.drag_drop_selector).hide();
                handleStatus(file, option);
                $('#' + file.id + ' td.status button').click(function (e) {
                    $('#' + option.id + ' #' + file.id).remove();
                    uploader.removeFile(file);
                    e.preventDefault();
                });
            }
        });


        $('#' + option.id + ' ' + option_template.status_selector).html(uploader.files.length + " tập tin, " + plupload.formatSize(uploader.total.size));
        $('#' + option.id + ' ' + option_template.start_selector).toggleClass('disabled', uploader.files.length == (uploader.total.uploaded + uploader.total.failed));

        updateTotalProgress(uploader, option, option_template);

        if (!uploader.files.length && uploader.features.dragdrop && uploader.settings.dragdrop) {
            $('#' + option.id + ' #' + option_template.drag_drop_selector).show();
        }
    }

    function uploaderBinds(uploader, option) {
        var option_template = MaDnhFileManager._config.uploader_template;
        console.log('bind');
        uploader.bind("UploadFile", function (up, file) {
            console.log('UploadFile');
            $('#' + option.id + ' #' + file.id).addClass('success');
        });

        uploader.bind('Init', function (up, res) {
            console.log('INIT');
            $('#' + option.id).append('<input type="hidden" id="' + option.id + '_count" name="' + option.id + '_count" value="0" />');
            // Enable rename support
            if (!option.unique_names && option.rename) {
                target.on('click', '#' + option.id + ' ' + option_template.item_list_selector + ' td.name span', function (e) {
                    var targetSpan = $(e.target), file, parts, name, ext = "";

                    // Get file name and split out name and extension
                    file = up.getFile(targetSpan.parents('tr')[0].id);
                    name = file.name;
                    parts = /^(.+)(\.[^.]+)$/.exec(name);
                    if (parts) {
                        name = parts[1];
                        ext = parts[2];
                    }

                    // Display input element
                    targetSpan.hide().after('<input type="text" />');
                    targetSpan.next().val(name).focus().blur(function () {
                        targetSpan.show().next().remove();
                    }).keydown(function (e) {
                        var targetInput = $(this);

                        if (e.keyCode == 13) {
                            e.preventDefault();

                            // Rename file and glue extension back on
                            file.name = targetInput.val() + ext;
                            targetSpan.html(file.name);
                            targetInput.blur();
                        }
                    });
                });
            }


            $('#' + option.id + ' ' + option_template.start_selector).click(function (e) {
                if (!$(this).is(':visible') || !$(this).hasClass('disable')) {
                    $('#' + option.id + ' .status span , #' + option.id + ' .status button').hide();
                    $('#' + option.id + ' .status .progress').show();
                    uploader.start();
                }
                e.preventDefault();
            }).addClass('disabled');

            $('#' + option.id + ' ' + option_template.empty_list_selector).click(function (e) {
                if (!$(this).is(':visible') || !$(this).hasClass('disable')) {
                    uploader.splice();
                }
                e.preventDefault();
            });
            $('#' + option.id + ' #' + option_template.drag_drop_selector).click(function (e) {
                $('#' + option_template.add_file_selector).trigger('click');
                e.preventDefault();
            });


            $('#' + option.id + ' ' + option_template.stop_selector).click(function (e) {
                e.preventDefault();
                uploader.stop();
            });
        });

        uploader.bind("PostInit", function (up) {
            console.log('PostInit');
            if (option.dragdrop && up.features.dragdrop) {
                $('#' + option.id + ' #' + option_template.drag_drop_selector).show();
            }
        });
        uploader.bind("UploadComplete", function (up, files) {
            if (option_template.status_selector) {
                $('#' + option.id + ' ' + option_template.status_selector).html('Tải lên hoàn tất');
            }
            if (option_template.progress_selector) {
                $('#' + option.id + ' ' + option_template.progress_selector).hide();
            }
            $('#' + option.id + ' .close-uploader').show();
        });

        uploader.bind("Error", function (up, err) {
            var file = err.file, message;

            if (file) {
                message = err.message;

                if (err.details) {
                    message += " (" + err.details + ")";
                }

                if (err.code == plupload.FILE_SIZE_ERROR) {
                    MaDnh.Helper.alert('Dung lượng không hợp lệ: ' + file.name);
                }

                if (err.code == plupload.FILE_EXTENSION_ERROR) {
                    MaDnh.Helper.alert('Định dạng tập tin không cho phép: ' + file.name);
                }

                file.hint = message;
                $("#" + option.id + ' #' + file.id).addClass('error').find('td.status span.label').removeClass('label').html(message).show();
            }
        });

        uploader.bind('StateChanged', function () {

            if (uploader.state === plupload.STARTED) {
                $('#' + option_template.add_file_selector).hide();

                $('#' + option.id + ' ' + option_template.stop_selector + ', #' + option.id + ' ' + option_template.progress_selector).show();
                $('#' + option.id + ' ' + option_template.empty_list_selector + ", #" + option.id + ' ' + option_template.start_selector).hide();
                $('#' + option.id + ' ' + option_template.status_selector).html("Đã tải lên " + uploader.total.uploaded + "/" + (uploader.total.queued + uploader.total.uploaded) + " tập tin");

                if (option.multiple_queues) {
                    $('#' + option.id + ' ' + option_template.status_selector).show();
                }
            } else {
                updateList(uploader, option, option_template);
                $('#' + option.id + ' ' + option_template.stop_selector + ', #' + option.id + ' ' + option_template.progress_selector).hide();
            }
        });

        uploader.bind('QueueChanged', function (up) {
            updateList(uploader, option, option_template);

            if (up.files.length > 0) {
                $('#' + option.id + ' ' + option_template.stop_selector).hide();
                $('#' + option.id + ' ' + option_template.empty_list_selector + ", #" + option.id + ' ' + option_template.start_selector + ', #' + option.id + ' ' + option_template.status_selector).show();
            } else {
                $('#' + option.id + ' ' + option_template.stop_selector).show();
                $('#' + option.id + ' ' + option_template.empty_list_selector + ", #" + option.id + ' ' + option_template.start_selector + ', #' + option.id + ' ' + option_template.totalStatus).hide();
            }

        });


        uploader.bind('FileUploaded', function (up, file, response) {
            console.log('FileUploaded', file, response);
            response.response = $.parseJSON(response.response);
            var result = new MaDnh.ProcessResult();
            if (MaDnh.Helper.isSystemJSON(response.response)) {
                result.addData('json_result_info', response.response.info);

                //import data
                __.each(response.response.process_data, function (value, key) {
                    result.addData(key, value);
                });
                //import info
                __.each(response.response.process_info, function (value) {
                    result.addInfo(value.content, value.type, value.code);
                });
                //import action
                __.each(response.response.process_action, function (value) {
                    result.addAction(value);
                });

                if (result.isError()) {
                    file.status = plupload.FAILED;
                    file.error = __.first(result.getInfos())['content'];
                }
            }

            console.log('result', result);


            handleStatus(file, option);
            if (!__.isNull(option.uploaded_callback)) {
                MaDnh.Helper.callFunctionDynamic(option.uploaded_callback, file);
            }
        });

        uploader.bind("UploadProgress", function (up, file) {
            $('#' + option.id + ' #' + file.id + ' .status span , #' + file.id + ' .status button').hide();
            $('#' + option.id + ' #' + file.id + ' .status .progress .progress-bar').css('width', file.percent + '%');
            $('#' + option.id + ' #' + file.id + ' .status .progress').show();
            handleStatus(file, option);
            updateTotalProgress(uploader, option, option_template);

            if (option.multiple_queues && uploader.total.uploaded + uploader.total.failed == uploader.files.length) {
                $('#' + option.id + ' ' + option_template.stop_selector + ', #' + option.id + ' ' + option_template.progress_selector).hide();
                $('#' + option.id + ' ' + option_template.empty_list_selector + ", #" + option.id + ' ' + option_template.start_selector).show().addClass('disabled');
                $('#' + option.id + ' ' + option_template.status_selector).hide();
            }
        });


        return uploader;
    }

    function createFolderTree(tree) {
        return MaDnh.Template.render('folder_nav_item_nested', tree);
    }

    function updateTree(template) {
        $(MaDnhFileManager._config.folder_tree_selector).html(template);
    }

    MaDnhFileManager.setCurrentFolder = function(id){
        MaDnhFileManager._config.current_folder = id;
        MaDnhFileManager._config.send_data = {parent_id: id};
    };
    MaDnhFileManager.loadItems = function (folder_id) {
        var ajax = new MaDnh.AJAXWorker();
        if (__.isUndefined(folder_id)) {
            folder_id = MaDnhFileManager._config.current_folder;
            MaDnhFileManager.setCurrentFolder(folder_id);
        }
        $(MaDnhFileManager._config.container_selector).addClass('loading');
        $(MaDnhFileManager._config.container_selector).removeClass('empty');
        ajax.option({
            requestPath: MaDnhFileManager._config.fetch_item_url,
            requestData: {folder_id: folder_id},
            requestType: 'POST',
            successFunc: function (data) {
                if (MaDnh.Helper.isProcessResult(data)) {
                    var content = '';
                    var items = __.extend({}, data.getData('items'));
                    console.log(items);
                    if (__.size(items)) {
                        __.each(items, function (item) {
                            var template_name = 'folder_content_';
                            if (item.item_type && MaDnh.Template.hasTemplate(template_name + item.item_type)) {
                                template_name += item.item_type;
                            } else {
                                template_name += 'item';
                            }
                            content += MaDnh.Template.render(template_name, item);
                        });
                        $(MaDnhFileManager._config.container_selector).removeClass('loading');
                        $(MaDnhFileManager._config.folder_content_holder).html(content);
                    } else {
                        $(MaDnhFileManager._config.container_selector).removeClass('loading');
                        $(MaDnhFileManager._config.container_selector).addClass('empty');
                    }
                }
            },
            errorFunc: function () {
                MaDnh.Helper.alert('Tải dữ liệu không thành công!');
            },
            completeFunc: function () {
                $(MaDnhFileManager._config.container_selector).removeClass('loading');
            }
        });
        ajax.request();
    };


    MaDnhFileManager.createFolder = function () {
        MaDnh.Helper.prompt('Tạo thư mục', '',function (value) {
            if (value === false) {
                return;
            }
            if (value) {
                var ajax = new MaDnh.AJAXWorker();
                $(MaDnhFileManager._config.container_selector).addClass('loading');
                ajax.option({
                    requestPath: MaDnhFileManager._config.create_folder_url,
                    requestData: {folder_name: value, parent_id: MaDnhFileManager._config.current_folder},
                    requestType: 'POST',
                    successFunc: function (data) {
                        if (MaDnh.Helper.isProcessResult(data) && !data.isError()) {
                            if (data.isSuccess()) {
                                MaDnhFileManager.loadFolderTree();
                                MaDnhFileManager.loadItems();
                            } else {
                                MaDnh.Helper.alertAjaxResult(data);
                            }
                        }
                    },
                    errorFunc: function () {
                        MaDnh.Helper.alert('Tạo folder không thành công');
                    },
                    completeFunc: function () {
                        $(MaDnhFileManager._config.container_selector).removeClass('loading');
                    }
                });
                ajax.request();
            } else {
                MaDnh.Helper.alert('Tên thư mục không hợp lệ', null, {type: 'error'});
            }
        });
    }


    MaDnhFileManager.loadUploader = function () {
        var uploader_id = 'uploader_' + MaDnh.Helper.randomString(10);
        var option;

        option = createOption(uploader_id);
        //console.log('option', option);
        $('body').append(createUploaderTemplate(option));
        if (__.isNull(MaDnhFileManager.uploader)) {
            MaDnhFileManager.uploader = new plupload.Uploader(option);
        }
        MaDnhFileManager.uploader = uploaderBinds(MaDnhFileManager.uploader, option);

        MaDnhFileManager.uploader.init();
        $('#' + uploader_id).modal({show: true, backdrop: 'static', keyboard: false});
        $('#' + uploader_id).on('hidden.bs.modal', function (e) {
            MaDnhFileManager.uploader.unbindAll();
            MaDnhFileManager.uploader.destroy();
            MaDnhFileManager.uploaders = __.omit(MaDnhFileManager.uploaders, uploader_id);
        })
    };

    MaDnhFileManager.loadFolderTree = function () {
        var ajax = new MaDnh.AJAXWorker();

        ajax.option({
            requestPath: MaDnhFileManager._config.folder_tree_url,

            successFunc: function (data) {
                if (MaDnh.Helper.isProcessResult(data)) {
                    updateTree(createFolderTree(data.getData('tree')));
                } else {
                    updateTree('');
                }
            },
            errorFunc: function () {
                updateTree('');
            },
            completeFunc: function(){
                MaDnhFileManager.selectFolderTreeItem(MaDnhFileManager._config.current_folder);
            }
        });
        ajax.request();
    };

    MaDnhFileManager.selectFolderTreeItem = function (id) {
        var folderNavItem = $('#folder_nav>ul li[data-folderid="' + id + '"]>a.folder_name');
        $("#folder_nav>ul").find('li.curent').removeClass('curent');
        folderNavItem.parent().addClass('curent');
        folderNavItem.parents('li').removeClass('collapsed').addClass('expanded');
        if(folderNavItem){
            MaDnhFileManager.setCurrentFolder(id);
        }
    };

    MaDnhFileManager.deleteItems = function () {

        var checkboxs = $(MaDnhFileManager._config.folder_content_holder + ' input:checkbox:checked');


        if (!checkboxs.length) {
            return;
        }

        MaDnh.Helper.confirm('Bạn có chắc muốn xóa những nội dung này?', function (action) {
            if (!action) {
                return;
            }
            var folders = [];
            var files = [];
            var ajax = new MaDnh.AJAXWorker();
            console.log('sadadad', checkboxs);

            __.each(checkboxs, function (e) {
                var row = $(e).parentsUntil('tr').parent();
                if (row.data('type') && row.data('item-id')) {
                    if (row.data('type') == 'folder') {
                        folders.push(row.data('item-id'));
                    } else {
                        files.push(row.data('item-id'));
                    }
                }
            });

            ajax.option({
                requestPath: MaDnhFileManager._config.delete_item_url,
                requestData: {folders: folders, files: files},
                requestType: 'POST',
                successFunc: function (data) {
                    MaDnhFileManager.loadItems();
                    MaDnhFileManager.loadFolderTree();
                },
                errorFunc: function () {
                    MaDnh.Helper.alert('Xóa nội dung không thành công');
                }
            });
            ajax.request();
        });
    }


    MaDnhFileManager.rename = function(type, id, old_name){
        MaDnh.Helper.prompt('Nhập tên mới', old_name, function(data){
            if(old_name != data){
                var ajax = new MaDnh.AJAXWorker();

                ajax.option({
                    requestPath: MaDnhFileManager._config.rename_item_url,
                    requestData: {type: type, id: id, new_name: data},
                    requestType: 'POST',
                    successFunc: function (data) {
                        if(MaDnh.Helper.isProcessResult(data)){
                            if(!data.isError()){
                                if(type == 'folder'){
                                    MaDnhFileManager.loadFolderTree();
                                }
                                MaDnhFileManager.loadItems();
                            }else{
                                MaDnh.Helper.alert('Đổi tên không thành công', {type:'error'});
                            }
                        }
                    },
                    errorFunc: function () {
                        MaDnh.Helper.alert('Đổi tên không thành công',  {type:'error'});
                    }
                });
                ajax.request();

            }
        }, {title: 'Đổi tên'});

    }


}).call(this);
