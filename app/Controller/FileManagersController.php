<?php

App::uses( 'AppController', 'Controller' );
App::uses( 'Tree', 'Lib' );
App::uses( 'ArrayHelper', 'Lib' );
App::uses( 'MadnhJson', 'Lib' );
App::uses( 'ProcessResult', 'Lib' );
App::uses( 'Filesystem', 'Lib' );

class FileManagersController extends AppController {

	public $uses = array( 'Folder', 'File', 'Download' );
	protected $options = array(
		'accept_file_types'                => '/.+zip|rar|tar|gz|taz.gr|aif|iff|m3u|m4u|mid|mp3|ra|wav|wma|3g2|3gp|asf|asx|avi|flv|mov|mpg|rm|srt|swf|vob|wmv|wmv|mkv|avis|jpg|txt|file$/i',
		'script_url'                       => '/',
		'upload_dir'                       => 'uploads',
		'mkdir_mode'                       => '0755',
		'param_name'                       => 'file',
		'access_control_allow_origin'      => '*',
		'access_control_allow_credentials' => false,
		'access_control_allow_methods'     => array( 'POST' ),
		'access_control_allow_headers'     => array( 'Content-Type', 'Content-Range', 'Content-Disposition' ),
		'max_file_size'                    => 0,
		'min_file_size'                    => 1,
		'max_number_of_files'              => null,
		'discard_aborted_uploads'          => true,
	);
	protected $error_messages = array(
		1                     => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
		2                     => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
		3                     => 'The uploaded file was only partially uploaded',
		4                     => 'No file was uploaded',
		6                     => 'Missing a temporary folder',
		7                     => 'Failed to write file to disk',
		8                     => 'A PHP extension stopped the file upload',
		'post_max_size'       => 'The uploaded file exceeds the post_max_size directive in php.ini',
		'max_file_size'       => 'File is too big',
		'min_file_size'       => 'File is too small',
		'accept_file_types'   => 'Filetype not allowed',
		'max_number_of_files' => 'Maximum number of files exceeded',
	);

	public function index() {
		$this->layout = 'admin';

		$yahoo = Cache::read( 'yahoo' );
		if ( ! $yahoo ) {
			$yahoo = 'Tôi bị điesdasd';
			Cache::write( 'yahoo', $yahoo );
		}

		$this->set( 'yahoo', $yahoo );


	}

	public function folderItems() {
		$this->autoRender = false;
		$this->layout     = false;
		$this->response->type( 'json' );
		App::import( 'Helper', 'Number' );
		$number_helper         = new NumberHelper( new View( $this ) );
		$this->Folder->user_id = $this->currentUser['id'];
		$this->File->user_id   = $this->currentUser['id'];

		$folder_id = $this->request->data( 'folder_id' );
		if ( ! $folder_id ) {
			$folder_id = 0;
		}

		$folders = $this->Folder->find( 'all', array(
			'conditions' => array(
				'Folder.user_id'   => $this->currentUser['id'],
				'Folder.folder_id' => $folder_id,
			),
			'order'      => array( 'Folder.folder_name ASC' ),
		) );
		$files   = $this->File->find( 'all', array(
			'conditions' => array(
				'File.user_id'   => $this->currentUser['id'],
				'File.folder_id' => $folder_id,
				"File.status != 'deleted'",
			),
			'order'      => array( 'File.file_name ASC' ),
		) );

		$tmp_items = array();
		foreach ( $folders as $folder ) {
			$tmp['item_type']              = 'folder';
			$tmp['item_name']              = htmlspecialchars( $folder['Folder']['folder_name'] );
			$tmp['item_id']                = $folder['Folder']['id'];
			$tmp['item_parent_id']         = $folder_id;
			$tmp['item_sub_files']         = 0;
			$tmp['item_sub_folders']       = 0;
			$tmp['item_create_time']       = $folder['Folder']['folder_create_time'];
			$tmp['item_human_create_time'] = date( "Y-n-j H-i-s", $tmp['item_create_time'] );
			$tmp['item_size']              = $folder['Folder']['folder_size'];
			$tmp['item_human_size']        = $number_helper->toReadableSize( $folder['Folder']['folder_size'] );
			$tmp['item_extra_info']        = $tmp['item_sub_files'] . ' tập tin, ' . $tmp['item_sub_folders'] . ' thư mục';

			$tmp_items[] = $tmp;
		}

		foreach ( $files as $file ) {
			$tmp['item_type']              = ( Filesystem::getFileExtention( $file['File']['file_name'] ) !== false ) ? htmlentities( Filesystem::getFileExtention( $file['File']['file_name'] ) ) : 'unknow';
			$tmp['item_name']              = htmlspecialchars( $file['File']['file_name'] );
			$tmp['item_id']                = $file['File']['id'];
			$tmp['item_parent_id']         = $folder_id;
			$tmp['item_create_time']       = $file['File']['file_create_time'];
			$tmp['item_human_create_time'] = date( "Y-n-j H-i-s", $tmp['item_create_time'] );
			$tmp['item_downloads']         = $file['File']['file_downloads'];
			$tmp['item_size']              = $file['File']['file_size'];
			$tmp['item_human_size']        = $number_helper->toReadableSize( $file['File']['file_size'] );
			$tmp['item_extra_info']        = '';

			$tmp_items[] = $tmp;
		}

		$result = new ProcessResult();
//		$result->addData( 'items', array() );
		$result->addData( 'items', $tmp_items );
		$result->addData( 'user_id', $this->currentUser['id'] );
		$result->addAction( 'alert(123)', 12 );

		return MadnhJson::output( $result );
	}

	public function getFileManager() {
		$this->autoRender = false;
		$this->layout     = false;
		$this->response->type( 'json' );
		$this->Folder->user_id = $this->currentUser['id'];
		$this->File->user_id   = $this->currentUser['id'];

		$result       = new ProcessResult();
		$view         = new View( $this );
		$view->layout = false;
		$result->addData( 'content', $view->render( 'file_manager' ) );
		$result->addData( 'upload_path', $this->get_upload_path( 'abc.com' ) );
		$result->addData( 'post_max', ini_get( 'post_max_size' ) );
		$result->addData( 'post_max2', $this->get_config_bytes( ini_get( 'post_max_size' ) ) );

		return MadnhJson::output( $result );
	}

	public function getFolderTree() {
		$this->autoRender = false;
		$this->layout     = false;
		$this->response->type( 'json' );
		$result                = new ProcessResult();
		$this->Folder->user_id = $this->currentUser['id'];
		$this->File->user_id   = $this->currentUser['id'];


		$tree_result = Cache::read( 'folder_tree_' . $this->currentUser['id'] );
		if ( ! is_array( $tree_result ) ) {
			$this->Folder->cacheFolderTree();
			$tree_result = Cache::read( 'folder_tree_' . $this->currentUser['id'] );
		}
		$tree_result = ArrayHelper::toArray( $tree_result );

		$result->addData( 'tree', $tree_result );

		return MadnhJson::output( $result );
	}

	public function createFolder() {
		$this->autoRender = false;
		$this->layout     = false;
		$this->response->type( 'json' );
		$this->Folder->user_id = $this->currentUser['id'];
		$this->File->user_id   = $this->currentUser['id'];

		$folder_name = $this->request->data( 'folder_name' );
		$parent_id   = $this->request->data( 'parent_id' );
		$result      = new ProcessResult();
		$result->addData( 'parent_id', $parent_id );
		$result->addData( 'folder_name', $folder_name );
		if ( ! empty( $parent_id ) ) {
			$folder = $this->Folder->findById( $parent_id );
			if ( ! $folder ) {
				$result->addInfo( 'Thư mục không tồn tại', ProcessResult::PROCESS_ERROR );
			}
		} else {
			$parent_id = 0;
		}
		if ( empty( $folder_name ) ) {
			$result->addInfo( 'Tên thư mục hợp lệ', ProcessResult::PROCESS_ERROR );
		}
		if ( ! $result->hasWarning() ) {
			if ( $this->request->is( 'post' ) ) {
				$this->Folder->create();
				$this->Folder->set( 'folder_name', $folder_name );
				$this->Folder->set( 'folder_id', $parent_id );
				$this->Folder->set( 'user_id', $this->currentUser['id'] );
				$this->Folder->set( 'folder_create_time', time() );
				if ( $this->Folder->save() ) {
					$result->addInfo( 'Tạo thư mục thành công', ProcessResult::PROCESS_SUCCESS );
					$this->Folder->cacheFolderTree();
				} else {
					$result->addInfo( 'Tạo thư mục không thành công', ProcessResult::PROCESS_ERROR );
				}
			} else {
				$result->addInfo( 'Yêu cầu không hợp lệ', ProcessResult::PROCESS_ERROR );
			}
		}

		return MadnhJson::output( $result );
	}


	public function upload() {
		$this->autoRender = false;
		$this->layout     = false;
		$this->response->type( 'json' );
		$result                = new ProcessResult();
		$this->Folder->user_id = $this->currentUser['id'];
		$this->File->user_id   = $this->currentUser['id'];

		$parent_id = $this->request->data( 'parent_id' );
		if ( ! empty( $parent_id ) ) {
			$folder = $this->Folder->findById( $parent_id );
			if ( ! $folder ) {
				$result->addInfo( 'Thư mục chứa không hợp lệ!', ProcessResult::PROCESS_ERROR );
			}
		} else {
			$parent_id = 0;
		}

		$result->addData( 'files', $_FILES );
		$result->addData( 'parent_id', $parent_id );

		if ( ! $result->hasWarning() ) {
			$upload    = ! empty( $_FILES[ $this->options['param_name'] ] ) ? $_FILES[ $this->options['param_name'] ] : null;
			$file_name = ! empty( $_POST["name"] ) ? $_POST["name"] : null;
			$file_id   = ! empty( $_POST["file_id"] ) ? $_POST["file_id"] : null;
			$rangeFrom = ! empty( $_POST["rangeFrom"] ) ? intval( $_POST["rangeFrom"] ) : 0;
			$rangeTo   = ! empty( $_POST["rangeTo"] ) ? intval( $_POST["rangeTo"] ) : 0;

			$size = ( ! empty( $_POST['total'] ) && is_numeric( $_POST['total'] ) && $_POST['total'] > 0 ) ? $_POST['total'] : null;

			$content_range = array( $rangeFrom, $rangeTo, $size );

			$files = array();
			if ( $upload && is_array( $upload['tmp_name'] ) ) {
				foreach ( $upload['tmp_name'] as $index => $value ) {
					$files[] = $this->handle_file_upload(
						$upload['tmp_name'][ $index ],
						$file_name ? $file_name : $upload['name'][ $index ],
						$file_id,
						$parent_id,
						$size ? $size : $upload['size'][ $index ],
						$upload['type'][ $index ],
						$upload['error'][ $index ],
						$index,
						$content_range
					);
				}
			} else {
				$files[] = $this->handle_file_upload(
					isset( $upload['tmp_name'] ) ? $upload['tmp_name'] : null,
					$file_name ? $file_name : ( isset( $upload['name'] ) ? $upload['name'] : null ),
					$file_id,
					$parent_id,
					$size ? $size : ( isset( $upload['size'] ) ? $upload['size'] : $_SERVER['CONTENT_LENGTH'] ),
					isset( $upload['type'] ) ? $upload['type'] : $_SERVER['CONTENT_TYPE'],
					isset( $upload['error'] ) ? $upload['error'] : null,
					null,
					$content_range
				);
			}

			$this->create_headers();
			$file = $files[0];
			if ( empty( $file->error ) ) {
				$tmp['item_type']              = ( Filesystem::getFileExtention( $file->realName ) !== false ) ? htmlentities( Filesystem::getFileExtention( $file->realName ) ) : 'unknow';
				$tmp['item_name']              = htmlentities( $file->realName );
				$tmp['item_id']                = $file->id;
				$tmp['item_parent_id']         = $file->parentId;
				$tmp['item_create_time']       = time();
				$tmp['item_human_create_time'] = date( "Y-n-j H-i-s", $tmp['item_create_time'] );
				$tmp['item_downloads']         = 0;
				$tmp['item_size']              = $file->size;
				$tmp['item_extra_info']        = '';
				$result->addInfo( 'File tải lên thành công', ProcessResult::PROCESS_SUCCESS );

			} else {
				$result->addInfo( $files[0]->error, ProcessResult::PROCESS_ERROR );
			}

		}


		return MadnhJson::output( $result );
	}

	public function rename() {
		$this->autoRender = false;
		$this->layout     = false;
		$this->response->type( 'json' );

		$this->Folder->user_id = $this->currentUser['id'];
		$this->File->user_id   = $this->currentUser['id'];
		$result                = new ProcessResult();

		$type = $this->request->data( 'type' );
		$id   = $this->request->data( 'id' );
		$name = $this->request->data( 'new_name' );
		$result->addData( 'name', $name );
		$result->addData( 'type', $type );
		$result->addData( 'id', $id );
		$result->addData( 'a', empty( $type ) );
		$result->addData( 'b', empty( $id ) );
		$result->addData( 'c', empty( $name ) );
		$result->addData( 'd', ! is_string( $name ) );


		if ( empty( $type ) || empty( $id ) || empty( $name ) || ! is_string( $name ) ) {
			$result->addInfo( 'Nội dung không đầy đủ', $result::PROCESS_ERROR );
		}

		if ( ! $result->hasWarning() ) {
			if ( $type == 'folder' ) {
				$folder = $this->Folder->findById( $id );
				if ( ! $folder ) {
					$result->addInfo( 'Thư mục không tồn tại', $result::PROCESS_ERROR );
				} else {
					$this->Folder->set( 'id', $id );
					if ( $this->Folder->save( array(
								'folder_name'          => $name,
								'folder_modified_time' => time()
							)
						)
					) {
						$this->Folder->cacheFolderTree();
						$result->addInfo( 'Đổi tên thư mục thành công', $result::PROCESS_SUCCESS );
					} else {
						$result->addInfo( 'Đổi tên thư mục không thành công', $result::PROCESS_ERROR );
					}
				}
			} else {
				$file = $this->File->findById( $id );
				if ( ! $file ) {
					$result->addInfo( 'Nội dung không tồn tại', $result::PROCESS_ERROR );
				} else {
					$this->File->set( 'id', $id );
					if ( $this->File->save( array( 'file_name' => $name, 'file_modified_time' => time() ) ) ) {
						$result->addInfo( 'Đổi tên nội dung thành công', $result::PROCESS_SUCCESS );
					} else {
						$result->addInfo( 'Đổi tên nội dung không thành công', $result::PROCESS_ERROR );
					}
				}
			}
		}

		return MadnhJson::output( $result );
	}

	public function delete() {
		$this->autoRender = false;
		$this->layout     = false;
		$this->response->type( 'json' );

		$this->Folder->user_id = $this->currentUser['id'];
		$this->File->user_id   = $this->currentUser['id'];

		$result = new ProcessResult();

		$folders = ArrayHelper::toArray( $this->request->data( 'folders' ) );
		$files   = ArrayHelper::toArray( $this->request->data( 'files' ) );

		foreach ( $folders as $k => $v ) {
			if ( ! is_numeric( $v ) ) {
				unset( $folders[ $k ] );
			}
		}
		foreach ( $files as $k => $v ) {
			if ( ! is_numeric( $v ) ) {
				unset( $files[ $k ] );
			}
		}

		$result->addData( 'files', $files );
		$result->addData( 'folders', $folders );

		if ( ! empty( $folders ) ) {
			$this->Folder->deleteFolders( $folders, $this->get_upload_path() );
		}


		if ( ! empty( $files ) ) {
			$result->addData( 'delete_files', $this->File->deleteFiles( $files, $this->get_upload_path() ) );
		}


		return MadnhJson::output( $result );
	}

	public function download( $key = null ) {
		if ( empty( $key ) ) {
			$this->response->location( '/' );

			return $this->response;
		}
		$this->layout = 'home';

		$info = new ProcessResult();

		$download = $this->Download->findByKey( $key );
		if ( ! $download ) {
			$info->addInfo( 'Yêu cầu tải không hợp lệ', ProcessResult::PROCESS_ERROR );
		}

		$this->set( 'infos', $info->getInfos() );
		$this->set( 'files', '' );


	}


	protected function get_upload_path( $file_name = '' ) {
		return $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . trim( $this->options['upload_dir'], '\\/' ) . DIRECTORY_SEPARATOR . $file_name;
	}


	protected function fix_integer_overflow( $size ) {
		if ( $size < 0 ) {
			$size += 2.0 * ( PHP_INT_MAX + 1 );
		}

		return $size;
	}

	protected function get_file_size( $file_path, $clear_stat_cache = false ) {
		if ( $clear_stat_cache ) {
			clearstatcache( true, $file_path );
		}

		return $this->fix_integer_overflow( filesize( $file_path ) );
	}

	protected function is_valid_file_object( $file_name ) {
		$file_path = $this->get_upload_path( $file_name );
		if ( is_file( $file_path ) && $file_name[0] !== '.' ) {
			return true;
		}

		return false;
	}

	protected function get_file_object( $file_name ) {
		if ( $this->is_valid_file_object( $file_name ) ) {
			$file       = new stdClass();
			$file->name = $file_name;
			$file->size = $this->get_file_size( $this->get_upload_path( $file_name ) );
//			$file->url  = $this->get_download_url( $file->name );

			$file->url = '';

			return $file;
		}

		return null;
	}

	protected function get_error_message( $error ) {
		return array_key_exists( $error, $this->error_messages ) ? $this->error_messages[ $error ] : $error;
	}

	protected function get_config_bytes( $val ) {
		$val  = trim( $val );
		$last = strtolower( $val[ strlen( $val ) - 1 ] );
		switch ( $last ) {
			case 'g' :
				$val *= 1024;
			case 'm' :
				$val *= 1024;
			case 'k' :
				$val *= 1024;
		}

		return $this->fix_integer_overflow( $val );
	}

	protected function validate_upload_file( $uploaded_file, $file, $error, $index ) {
		//Kiểm tra bằng kết quả upload file
		if ( $error ) {
			$file->error = $this->get_error_message( $error );

			return false;
		}
		//Kiểm tra dung lượng file upload được phép trong php.ini
		$content_length = $this->fix_integer_overflow( intval( $_SERVER['CONTENT_LENGTH'] ) );
		$post_max_size  = $this->get_config_bytes( ini_get( 'post_max_size' ) );

		if ( $post_max_size && ( $content_length > $post_max_size ) ) {
			$file->error = $this->get_error_message( 'post_max_size' );

			return false;
		}
		//Kiểm tra loại file
		if ( ! preg_match( $this->options['accept_file_types'], ( ! empty( $file->realName ) ? $file->realName : $file->name ) ) ) {
			$file->error = $this->get_error_message( 'accept_file_types' );

			return false;
		}
		//Kiểm tra dung lượng file
		if ( $uploaded_file && is_uploaded_file( $uploaded_file ) ) {
			$file_size = $this->get_file_size( $uploaded_file );
		} else {
			$file_size = $content_length;
		}
		if ( $this->options['max_file_size'] && ( $file_size > $this->options['max_file_size'] || $file->size > $this->options['max_file_size'] ) ) {
			$file->error = $this->get_error_message( 'max_file_size' );

			return false;
		}
		if ( $this->options['min_file_size'] && $file_size < $this->options['min_file_size'] ) {
			$file->error = $this->get_error_message( 'min_file_size' );

			return false;
		}

		/*
		 if (is_int($this->options['max_number_of_files']) && ($this->count_file_objects() >= $this->options['max_number_of_files'])) {
		 $file->error = $this->get_error_message('max_number_of_files');
		 return false;
		 }*/

		return true;
	}


	protected function upcount_name( $name ) {
		return preg_replace_callback( '/(?:(?: \(([\d]+)\))?(\.[^.]+))?$/', function ( $matches ) {
			$index = isset( $matches[1] ) ? intval( $matches[1] ) + 1 : 1;
			$ext   = isset( $matches[2] ) ? $matches[2] : '';

			return ' (' . $index . ')' . $ext;
		}, $name, 1 );
	}

	protected function get_unique_filename( $name, $type, $index, $content_range ) {
		while ( is_dir( $this->get_upload_path( $name ) ) ) {
			$name = $this->upcount_name( $name );
		}
		// Keep an existing filename if this is part of a chunked upload:
		$uploaded_bytes = $this->fix_integer_overflow( intval( $content_range[0] ) );
		while ( is_file( $this->get_upload_path( $name ) ) ) {
			if ( $uploaded_bytes == $this->get_file_size( $this->get_upload_path( $name ) ) ) {
				break;
			}

			$name = $this->upcount_name( $name );

		}

		return $name;
	}

	protected function trim_file_name( $name, $type, $index, $content_range ) {
		// Remove path information and dots around the filename, to prevent uploading
		// into different directories or replacing hidden system files.
		// Also remove control characters and spaces (\x00..\x20) around the filename:
		$name = trim( basename( stripslashes( $name ) ), ".\x00..\x20" );
		// Use a timestamp for empty filenames:
		if ( ! $name ) {
			$name = str_replace( '.', '-', microtime( true ) );
		}
		// Add missing file extension for known image types:
		if ( strpos( $name, '.' ) === false && preg_match( '/^image\/(gif|jpe?g|png)/', $type, $matches ) ) {
			$name .= '.' . $matches[1];
		}

		return $name;
	}

	protected function get_file_name( $name, $type, $index, $content_range ) {

		return $this->get_unique_filename( $this->trim_file_name( $name, $type, $index, $content_range ), $type, $index, $content_range );
	}

	protected function handle_form_data( $file, $index ) {
		// Handle form data, e.g. $_REQUEST['description'][$index]
	}

	protected function handle_file_upload( $uploaded_file, $name, $file_id, $parentId, $size, $type, $error, $index = null, $content_range = null ) {

		$file           = new stdClass();
		$file->id       = $file_id;
		$file->realName = $name;
		//$file->name = $this->get_file_name($name, $type, $index, $content_range);
		if ( ! empty( $file_id ) ) {
			$tmp_name = $file_id;
		} else {
			$tmp_name = $name;
		}
		$tmp_name       = md5( $this->currentUser['id'] . $parentId . $tmp_name ) . '.file';
		$file->name     = $this->get_file_name( $tmp_name, $type, $index, $content_range );
		$file->size     = $this->fix_integer_overflow( intval( $size ) );
		$file->type     = $type;
		$file->parentId = $parentId;
		if ( $this->validate_upload_file( $uploaded_file, $file, $error, $index ) ) {
			$this->handle_form_data( $file, $index );
			$upload_dir = $this->get_upload_path();
			if ( ! is_dir( $upload_dir ) ) {
				mkdir( $upload_dir, $this->options['mkdir_mode'], true );
			}
			$file_path   = $this->get_upload_path( $file->name );
			$append_file = $content_range && is_file( $file_path ) && $file->size > $this->get_file_size( $file_path );
			if ( $uploaded_file && is_uploaded_file( $uploaded_file ) ) {
				// multipart/formdata uploads (POST method uploads)
				if ( $append_file ) {
					file_put_contents( $file_path, fopen( $uploaded_file, 'r' ), FILE_APPEND );
				} else {
					move_uploaded_file( $uploaded_file, $file_path );
				}
			}
			$file_size = $this->get_file_size( $file_path, $append_file );
			if ( $file_size === $file->size ) {
				//upload complete
				$file->code = $file_id;
				$this->File->create();
				$this->File->set( 'file_name', $file->realName );
				$this->File->set( 'file_code', $file->name );
				$this->File->set( 'file_size', $file->size );
				$this->File->set( 'file_create_time', time() );
				$this->File->set( 'file_downloads', 0 );
				$this->File->set( 'folder_id', $file->parentId );
				$this->File->set( 'user_id', $this->currentUser['id'] );

				if ( $this->File->save() ) {
					$file->id = $this->File->id;
				}
			} else if ( ! $content_range ) {
				//Upload error
				unlink( $file_path );
				$file->error = 'abort';
			}
			$file->size = $file_size;
		} else {

		}

		return $file;
	}


	protected function create_headers() {
		$headers = array(
			'Pragma: no-cache',
			'Cache-Control: no-store, no-cache, must-revalidate',
			'Content-Disposition: inline; filename="files.json"',
			'X-Content-Type-Options: nosniff'
		);

		if ( $this->options['access_control_allow_origin'] ) {
			$headers = array_merge( $headers, array(
				'Access-Control-Allow-Origin'      => $this->options['access_control_allow_origin'],
				'Access-Control-Allow-Credentials' => ( $this->options['access_control_allow_credentials'] ? 'true' : 'false' ),
				'Access-Control-Allow-Methods'     => implode( ', ', $this->options['access_control_allow_methods'] ),
				'Access-Control-Allow-Headers'     => implode( ', ', $this->options['access_control_allow_headers'] ),

			) );
		}
		$headers[] = 'Vary: Accept';

		if ( isset( $_SERVER['HTTP_ACCEPT'] ) && ( strpos( $_SERVER['HTTP_ACCEPT'], 'application/json' ) !== false ) ) {
			$headers[] = 'Content-type: application/json';
		} else {
			$headers[] = 'Content-type: text/plain';
		}
		$this->response->header( $headers );
	}
}