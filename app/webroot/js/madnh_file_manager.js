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

    MaDnhFileManager._config = {
        fetch_item_url: '',
        create_folder_url: '',
        container_selector: '#myfiles_wrap',
        folder_content_holder: '#folder_items',
        loading_selector: '#loading_content',
        drag_drop_selector: '#emptyfolder_upload',
        current_folder: ''
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

    MaDnhFileManager.loadItems = function (folder_id) {
        var ajax = new MaDnh.AJAXWorker();
        if(__.isUndefined(folder_id)){
            folder_id = MaDnhFileManager._config.current_folder;
        }
        $(MaDnhFileManager._config.container_selector).addClass('loading');
        ajax.option({
            requestPath: MaDnhFileManager._config.fetch_item_url,
            requestData: {folder_id: folder_id},
            requestType: 'POST',
            successFunc: function (data) {
                if (MaDnh.Helper.isProcessResult(data)) {
                    var content = '';
                    __.each(__.extend({}, data.getData('items')), function (item) {
                        var template_name = 'folder_content2_';
                        if (item.item_type && MaDnh.Template.hasTemplate(template_name + item.item_type)) {
                            template_name += item.item_type;
                        } else {
                            template_name += 'item';
                        }
                        content += MaDnh.Template.render(template_name, item);
                    });
                    $(MaDnhFileManager._config.folder_content_holder).html(content);

                }
            },
            errorFunc: function () {
                MaDnh.Helper.alert('Load folder items fail!');
            },
            completeFunc: function () {
                $(MaDnhFileManager._config.container_selector).removeClass('loading');
            }
        });
        ajax.request();
    };

    MaDnhFileManager.createFolder = function(){
        MaDnh.Helper.prompt('Tạo thư mục', function(value){
            if(value === false){
                return;
            }
            if(value){
                var ajax = new MaDnh.AJAXWorker();
                $(MaDnhFileManager._config.container_selector).addClass('loading');
                ajax.option({
                    requestPath: MaDnhFileManager._config.create_folder_url,
                    requestData: {folder_name: value, parent_id: MaDnhFileManager._config.current_folder},
                    requestType: 'POST',
                    successFunc: function (data) {
                        if (MaDnh.Helper.isProcessResult(data) && !data.isError()) {
                            if(data.isSuccess()){
                                MaDnhFileManager.loadItems(MaDnhFileManager._config.current_folder);
                            }else{
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
            }else{
                MaDnh.Helper.alert('Tên thư mục không hợp lệ', null, {type:'error'});
            }
        });
    }

}).call(this);
