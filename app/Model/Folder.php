<?php

App::uses( 'AppModel', 'Model' );
App::uses( 'File', 'Model' );

class Folder extends AppModel {

	public function getFolders( $user_id = null ) {
		if ( $user_id === null ) {
			$user_id = $this->user_id;
		}

		$folders = $this->find( 'all', array(
			'conditions' => array(
				'Folder.user_id' => $user_id
			)
		) );

		foreach ( $folders as $k => $folder ) {
			$folders[ $k ] = $folder['Folder'];
		}

		return $folders;
	}

	public function cacheFolderTree() {
		$folders = $this->getFolders();
		$data    = array();
		foreach ( $folders as $item ) {
			$item['folder_name'] = htmlspecialchars( $item['folder_name'] );
			$data[]              = $item;
		}
		$tree = new Tree();
		$tree->setData( $data );
		$tree->parent_item_field = 'folder_id';
		$tree->item_id_field     = 'id';
		$tree->item_info_fields  = array( 'id', 'folder_id', 'folder_name' );
		$tree->sub_items_string  = 'sub_folders';

		$tree_result = $tree->getChildrensTree( '0' );

		Cache::write( 'folder_tree_' . $this->user_id, $tree_result );

	}

	public function subFolders( $id ) {
		$folders = $this->getFolders();

		$tree = new Tree();
		$tree->setData( $folders );
		$tree->parent_item_field = 'folder_id';
		$tree->item_id_field     = 'id';

		return $tree->getChildrens( $id . '' );
	}


	public function deleteFolders( $ids, $upload_path = '' ) {
		$ids = ArrayHelper::toArray( $ids );
		foreach ( $ids as $k => $v ) {
			if ( ! is_numeric( $v ) ) {
				unset( $ids[ $k ] );
			}
		}

		if ( empty( $ids ) ) {
			return array();
		}

		$folders = $this->getFolders();

		$tree = new Tree();
		$tree->setData( $folders );
		$tree->parent_item_field = 'folder_id';
		$tree->item_id_field     = 'id';

		$deletes = array();

		foreach ( $ids as $id ) {
			$deletes[] = $id;
			$subs      = $tree->getChildrens( $id . '' );
			$deletes   = array_merge( $deletes, ArrayHelper::getColumns( $subs, 'id', true ) );
		}
		$deletes = array_unique( $deletes );



		$file_model          = new File();
		$file_model->user_id = $this->user_id;

		$files = $file_model->folderFiles( $deletes );

		$this->deleteAll( array(
			'Folder.user_id' => $this->user_id,
			'Folder.id'      => $deletes,
		) );

		$this->cacheFolderTree();

		return $file_model->deleteFiles( ArrayHelper::getColumns( $files, array( 'id' ), true ), $upload_path );
	}
} 