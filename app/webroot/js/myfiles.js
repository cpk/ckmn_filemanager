var folderNav = $('#folder_nav>ul>li>ul'),
	curentFolderId = 0,
	folderTreeData,
	folderData = {
		'folders': [],
		'files': []
	};

$(document).ready(function () {
    initHandlebarsTemplate();
    registerHandlebarsHelperFnc();
    loadFolderTree();
    loadFolderData();
    changeView('list');
    $('#uploadMenu').delegate('a', 'click', function (e) {
        e.preventDefault();
        switch ($(this).attr('id')) {
            case 'uploadFromComputer':
                uploadFromComputer();

        }

    });

    /* Add click event to Folder Nav li*/
    $("#folder_nav>ul").delegate('li>a.folder_name', "click", function (e) {
        e.stopPropagation();
        $("#folder_nav>ul").find('li.curent').removeClass('curent');
        $(this).parent().addClass('curent');
        curentFolderId = $(this).parent().data('folderid');
        loadFolderData();
        e.preventDefault();
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
   $('ol#main_list').delegate('li','click',function(e){
   	e.stopPropagation();
   	var $this=$(this),
   		id=$this.data('id');
   		if(id){
   			console.log(id);
   			$this.toggleClass('selected');
   		}
   	
   		
   }).delegate('li a','click',function(e){
   	e.stopPropagation();
   	var $this=$(this), liParent=$this.parents('li').first(),id=liParent.data('id'), folderNavItem;
   	
   	if(liParent.data('type')=='folder' && id){
   		e.preventDefault();
   		window.location.hash='#'+id;
   		folderNavItem=$('#folder_nav>ul li[data-folderid="'+id+'"]>a.folder_name');
   		folderNavItem.parents('li').removeClass('collapsed').addClass('expanded');
   		folderNavItem.trigger('click');
   		console.log(folderNavItem);
   	}  	
   	
   });

});


function bytesToHumanReadable(bytes) {
    var s = ['bytes', 'kB', 'MB', 'GB', 'TB', 'PB'];
    var e = Math.floor(Math.log(bytes) / Math.log(1024));
    return (bytes / Math.pow(1024, Math.floor(e))).toFixed(2) + " " + s[e];
}


/* Modal Function*/
function initHandlebarsTemplate() {
    var compiled = new Object();
    var templated = new Object();
    

    compiled.modalStruct = Handlebars.compile($('script#modalStruc_modal').html());
	compiled.folderNavItem = Handlebars.compile($('script#folderNavItem').html());
    compiled.folderNavItemWithNested = Handlebars.compile($('script#folderNavItemWithNested').html());
    compiled.folderContentItem = Handlebars.compile($('script#folderContentItem').html());
    compiled.uploadFromComputerModalStruct = Handlebars.compile($('script#modalStruct_uploadFromComputer').html());
    compiled.uploadFromComputer_uploadContent = Handlebars.compile($('script#modalBody_uploadContent').html());



    templated.modalAddFolder = compiled.modalStruct({
        modalId: "addFolder",
        modalTitle: "Thêm thư mục",
        modalBody: $("script#modalAddFolder").html(),
        modalCancelString: "Hủy",
        modalActionString: "Thêm thư mục"
    });

    globalVars.jsTemplate.compiled = compiled;
    globalVars.jsTemplate.templated = templated;

    console.warn(globalVars.jsTemplate);

}

function registerHandlebarsHelperFnc() {

    Handlebars.registerHelper('folderNavItemWithNested', function (info) {
        return globalVars.jsTemplate.compiled.folderNavItemWithNested(info);
    });
    Handlebars.registerHelper('compare', function(lvalue, rvalue, options) {
    if (arguments.length < 3)
        throw new Error("Handlerbars Helper 'compare' needs 2 parameters");
    operator = options.hash.operator || "==";
    var operators = {
        '==':       function(l,r) { return l == r; },
        '===':      function(l,r) { return l === r; },
        '!=':       function(l,r) { return l != r; },
        '<':        function(l,r) { return l < r; },
        '>':        function(l,r) { return l > r; },
        '<=':       function(l,r) { return l <= r; },
        '>=':       function(l,r) { return l >= r; },
        'typeof':   function(l,r) { return typeof l == r; }
    }
    if (!operators[operator])
        throw new Error("Handlerbars Helper 'compare' doesn't know the operator "+operator);
    var result = operators[operator](lvalue,rvalue);
    if( result ) {
        return options.fn(this);
    } else {
        return options.inverse(this);
    }
  });
}

function addFolder() {
    var folderNameInput, modalContainer;

    $('body').append(globalVars.jsTemplate.templated.modalAddFolder);
    modalContainer = $('#modal_addFolder');
    folderNameInput = modalContainer.find('input[name="folder_name"]').first();

    modalContainer.modal().on('shown', function () {
        folderNameInput.focus();
    }).on('hidden', function () {
        modalContainer.detach();

    }).find('.modal-footer button.btn.btn-primary').click(function () {
        if (folderNameInput.val() != '') {
            console.log('Thu muc hien tai: ' + curentFolderId);
            ajaxFunction(globalSettings.apiUrl + '?type=userfile&action=create_folder', 'POST', 'json', {
                'folder_name': folderNameInput.val(),
                'folder_parent_id': curentFolderId
            }, 'progressAddFolderResult');
            modalContainer.modal('hide');
        }

    });

}

function uploadFromComputer() {
    var modalTemplate;
    modalTemplate = $('#modal_uploadFromComputer');
    if (modalTemplate) {
        modalTemplate.remove();
    }
    $('body').append(globalVars.jsTemplate.compiled.uploadFromComputerModalStruct({}));
    loadUploader();
    modalTemplate = $('#modal_uploadFromComputer');
    modalTemplate.modal('show');
}
function loadUploader(submitData){
	var uploaderSettings=new Object;
	globalSettings.modalDragAndDropContainer=$('#'+globalSettings.modalDragAndDropContainerId);	
	uploaderSettings={
			runtimes : 'html5',
			url : globalSettings.uploadPath,
			multipart:true,
			file_data_name:globalSettings.fileDataName,
			max_file_size : globalSettings.maxFileSize,
			unique_names:false,
			chunk_size : globalSettings.chunkSize,
			required_features: 'chunks',
			dragdrop: true,
			flash_swf_url : 'includes/templates/default/js/plupload/Moxie.swf',
			silverlight_xap_url : 'includes/templates/default/js/plupload/Moxie.xap',
			fileUploaded_callback:'progressUploadCompleteResult'
	};
	
	if(!submitData){
		submitData=new Object;
	}
	submitData.form_token=globalSettings.uploadToken;
	submitData.parent_id=curentFolderId;
	uploaderSettings.multipart_params=submitData;
	
	$("#"+globalSettings.uploadContainer).pluploadQueue(uploaderSettings);
}

/* AJAX FUNCTION */
function ajaxFunction($url, $type, $dataType, $data, $successCallBackFunction, $completeCallBackFunction, $errorCallBackFunction) {
    $.ajax({
        url: $url,
        type: $type,
        dataType: $dataType,
        data: $data,
        success: function (data) {
            console.log('RECEIVE AJAX DATA SUCCESS');
            if (typeof $successCallBackFunction != undefined) {
                try {
                    window[$successCallBackFunction](data);
                } catch (e) {

                }
            }
        },
        complete: function (jqxhr, textStatus) {
            console.log('AJAX COMPLETE');
            if (typeof $completeCallBackFunction != undefined) {
                try {
                    window[$completeCallBackFunction](jqxhr, textStatus);
                } catch (e) {

                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('AJAX ERROR');
            console.warn(textStatus);
            console.warn(errorThrown);
            if (typeof $errorCallBackFunction != undefined) {
                try {
                    window[$errorCallBackFunction](jqXHR, textStatus, errorThrown);
                } catch (e) {

                }
            }
        }
    });
}

function loadFolderData() {
    $('#loading_content').show();
    $('#emptyfolder_upload').hide();
    $('#main_list').hide();
    ajaxFunction(globalSettings.apiUrl + '?type=userfile&action=folder_content&folder_id=' + curentFolderId, 'GET', 'json', {}, 'progressFetchFolderInfoResult');
}

function loadFolderTree() {
    folderNav.empty();
    ajaxFunction(globalSettings.apiUrl + '?type=userfile&action=folder_tree', 'GET', 'json', {}, 'progressFetchFolderTreeResult');
}

/* Progress ajax result */
function progressAddFolderResult(data) {
    if (data.result != undefined) {
        if (data.result == 'success') {
            console.warn('Ket qua: ' + data.message);
            console.warn(data.info);
            folderData.folders.push(data.info);
            parseFolderItem();
            
            var folder,find,parentFolder;
            folder={folder_id:data.info.item_id,folder_name:data.info.item_name};
            console.warn(folder);
            find=$('li[data-folderid="'+data.info.item_parent_id+'"]').parents('li').map(function () {return $(this).data('folderid');}).get().reverse();
            find.push(data.info.item_parent_id);
            find.shift();
            console.log('=============================');
            console.log(find);
            find=find.join('.sub_folders.');
            if($.exists(find,folderTreeData)){
            	//Ton tai thu muc cha can tim
            	$.setObject(find+'.sub_folders.'+folder.folder_id,folder,folderTreeData);
				
            }
            folderNav.empty().append(globalVars.jsTemplate.compiled.folderNavItemWithNested(folderTreeData));
            folderNav.find('li[data-folderid="'+data.info.item_parent_id+'"]').removeClass('collapsed').addClass('expanded curent').parents('li').removeClass('collapsed').addClass('expanded');

        } else {
            console.warn('Them thu muc co loi! ' + data.message);
        }
    } else {
        console.warn('Them thu muc co loi! khong xac dinh');
    }
}

function progressFetchFolderInfoResult(data) {
    if (data.result != undefined) {
        if (data.result == 'success') {
            folderData = {
                'folders': [],
                'files': []
            };
            for (item in data.info) {

                if (data.info[item].item_type == 'folder') {
                    folderData.folders.push(data.info[item]);
                } else {
                    folderData.files.push(data.info[item]);
                }
            }
            parseFolderItem();
            rebuilContextMenu();

        } else {
            console.warn('Lay thong tin thu muc co loi! ' + data.message);
        }
    } else {
        console.warn('Co loi khong xac dinh');
    }
}

function progressFetchFolderTreeResult(data) {
    console.warn(data);
    if (data.result != undefined) {
        if (data.result == 'success') {
        	console.log(data.info);
        	folderTreeData=data.info;
            folderNav.append(globalVars.jsTemplate.compiled.folderNavItemWithNested(data.info));
        } else {
            console.warn('Lay cau truc thu muc co loi! ' + data.message);
        }
    } else {
        console.warn('Co loi khong xac dinh');
    }
}

function progressUploadCompleteResult(file,responses){
	var data=responses.response;
	
	console.log(data);
	$('#' + file.id + " .status").html('<span class="label label-info">Đang kiểm tra...</span>');
	if(responses.status!=200){
		$('#' + file.id + " .status").html('<span class="label label-warning">Lỗi kết nối!</span>');	
	}else{
		if (data.result) {
			if (data.result == "success") {
				$('#' + file.id + " .status").html('<span class="label label-success">Thành công</span>');
				folderData.files.push(data.info);
				parseFolderItem();
				 } else {
					 $('#' + file.id + " .status").html('<span class="label label-important" title="'+data.message+'">Lỗi</span>');
			}
		} else {
			console.warn('Them thu muc co loi! khong xac dinh');
		}
	}
	
		
	
	
}
/* File Manager Function */

function rebuilContextMenu(){
	$('#main_list li').rightClickMenu('#context-menu');
}
function parseFolderItem() {
    console.warn('Parse Folder Info to list view');
    console.warn(folderData);
    var mainList = $('ol#main_list');
    var curFolderNavList = $('#folder_nav>ul').find('li.curent').first();
    mainList.empty();
    $('#loading_content').hide();
    if (folderData.folders.length + folderData.files.length > 0) {
        $('#emptyfolder_upload').hide();
        for (item in folderData.folders) {
            $info = folderData.folders[item];
            
            mainList.append(globalVars.jsTemplate.compiled.folderContentItem($info));
        }
        for (item in folderData.files) {
            $info = folderData.files[item];
            $info.item_humanSize=plupload.formatSize($info.item_size);
            mainList.append(globalVars.jsTemplate.compiled.folderContentItem($info));
        }

        $('ol#main_list').show();
        rebuilContextMenu();
    } else {
        $('#emptyfolder_upload').show();
    }
}

/* Thay doi cach hien thi du lieu */
function changeView(type) {
    var changeViewDiv = $('div#changeView');
    changeViewDiv.find('button').click(function () {
        $(this).parent().find('button.active').removeClass('active');
        type = $(this).data('type');
        $(this).addClass('active');
        updateView(type);
        return;
    });
    changeViewDiv.find('button[data-type="' + type + '"]').addClass('active');
    updateView(type);

    function updateView(type) {
        switch (type) {
            case 'grid_sizeS':
                $('div#myfiles_wrap').removeClass('sizeM').addClass('sizeS thumbnailView');
                break;
            case 'grid_sizeM':
                $('div#myfiles_wrap').removeClass('sizeS').addClass('sizeM thumbnailView');
                break;
            case 'list':
                $('div#myfiles_wrap').removeClass('sizeS').removeClass('thumbnailView');
                break;
        }
    }

}