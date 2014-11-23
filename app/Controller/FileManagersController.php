<?php

App::uses( 'AppController', 'Controller' );
App::uses( 'Tree', 'Lib' );
App::uses( 'MadnhJson', 'Lib' );
App::uses( 'ProcessResult', 'Lib' );
App::uses( 'Filesystem', 'Lib' );

class FileManagersController extends AppController {
	public $uses = array( 'Folder', 'File' );

	public function index() {
		$this->layout = 'admin';

	}

	public function folderItems( $folder_id = null ) {
		$this->autoRender = false;
		$this->layout     = false;
		$this->response->type('json');
		App::import( 'Helper', 'Number' );
		$number_helper = new NumberHelper( new View( $this ) );

		$folders = $this->Folder->find( 'all' );
		$files   = $this->File->find( 'all' );

		$tmp_items = array();
		foreach ( $folders as $folder ) {
			$tmp['item_type']              = 'folder';
			$tmp['item_name']              = htmlspecialchars( $folder['Folder']['folder_name'] );
			$tmp['item_id']                = $folder['Folder']['folder_id'];
			$tmp['item_parent_id']         = $folder_id;
			$tmp['item_sub_files']         = 0;
			$tmp['item_sub_folders']       = 0;
			$tmp['item_create_time']       = $folder['Folder']['folder_create_time'];
			$tmp['item_human_create_time'] = date( "Y-n-j H-i-s", $tmp['item_create_time'] );
			$tmp['item_size']              = $folder['Folder']['folder_size'];
			$tmp['item_human_size']         = $number_helper->toReadableSize($folder['Folder']['folder_size']);
			$tmp['item_extra_info']        = $tmp['item_sub_files'] . ' tập tin, ' . $tmp['item_sub_folders'] . ' thư mục';

			$tmp_items[] = $tmp;
		}

		foreach ( $files as $file ) {
			$tmp['item_type']              = ( Filesystem::getFileExtention( $file['File']['file_name'] ) !== false ) ? htmlentities( Filesystem::getFileExtention( $file['File']['file_name'] ) ) : 'unknow';
			$tmp['item_name']              = htmlspecialchars( $file['File']['file_name'] );
			$tmp['item_id']                = $file['File']['file_id'];
			$tmp['item_parent_id']         = $folder_id;
			$tmp['item_create_time']       = $file['File']['file_create_time'];
			$tmp['item_human_create_time'] = date( "Y-n-j H-i-s", $tmp['item_create_time'] );
			$tmp['item_downloads']         = $file['File']['file_downloads'];
			$tmp['item_size']              = $file['File']['file_size'];
			$tmp['item_human_size']         = $number_helper->toReadableSize($file['File']['file_size']);
			$tmp['item_extra_info']        = '';

			$tmp_items[] = $tmp;
		}

		$result = new ProcessResult();
		$result->addData( 'items', $tmp_items);

		return MadnhJson::output( $result );
	}


	public function getFolderTree() {
		$this->autoRender = false;

		$user_id = 1;

		$result = new ProcessResult();
		$result->addData( 'sadw', $_SERVER );
		$result->addData( 'user_id', $user_id );
		$result->addData( 'is_ajax', $this->request->is( 'ajax' ) );


		return MadnhJson::output( $result );
	}

	public function createFolder() {
		$this->autoRender = false;
		$this->layout     = false;
		$this->response->type('json');

		$folder_name = $this->request->data('folder_name');
		$parent_id = $this->request->data('parent_id');
		$result = new ProcessResult();
		$result->addData( 'parent_id', $parent_id);
		$result->addData( 'folder_name', $folder_name);
		if(!empty($parent_id)){
			if(false){
				$result->addInfo('Thư mục không tồn tại', ProcessResult::PROCESS_ERROR);
			}
		}else{
			$parent_id = 0;
		}
		if(empty($folder_name)){
			$result->addInfo('Tên thư mục hợp lệ', ProcessResult::PROCESS_ERROR);
		}
		if(!$result->hasWarning()){
			$result->addInfo('Tạo thư mục thành công', ProcessResult::PROCESS_SUCCESS);
		}

		return MadnhJson::output( $result );
	}


} 