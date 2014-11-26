<?php

App::uses( 'AppModel', 'Model' );
App::uses( 'ArrayHelper', 'Lib' );

class File extends AppModel {

	public function folderFiles( $ids = array() ) {
		if ( ! is_numeric( $this->user_id ) ) {
			return array();
		}
		$conditions = array(
			'File.user_id' => $this->user_id,
			'File.status !=' => "'deleted'",
		);
		$ids = ArrayHelper::toArray( $ids );
		foreach ( $ids as $k => $v ) {
			if ( ! is_numeric( $v ) ) {
				unset( $ids[ $k ] );
			}
		}

		if(!empty($ids)){
			$conditions['File.folder_id'] = $ids;
		}

		$files = $this->find( 'all', array(
			'conditions' => $conditions,
		) );

		foreach ( $files as $k => $v ) {
			$files[ $k ] = $v['File'];
		}

		return $files;
	}


	public function deleteFiles( $ids, $uploaded_path ) {

		$ids = ArrayHelper::toArray( $ids );
		foreach ( $ids as $k => $v ) {
			if ( ! is_numeric( $v ) ) {
				unset( $ids[ $k ] );
			}
		}
		if ( ! is_numeric( $this->user_id ) ) {
			return false;
		}
		$files = $this->find( 'all', array(
			'conditions' => array(
				'File.id'      => $ids,
				'File.user_id' => $this->user_id
			)
		) );

		$deleted = array();
		if ( $files ) {
			foreach ( $files as $file ) {
				$file      = $file['File'];
				$deleted[] = $file['id'];
				if ( is_file( $uploaded_path . DIRECTORY_SEPARATOR . $file['file_code'] ) ) {
					unlink( $uploaded_path . DIRECTORY_SEPARATOR . $file['file_code'] );
				}
			}
		}
		$this->updateAll( array(
			"File.status" => "'deleted'",
			'File.file_modified_time' => time(),
		), array(
			'File.user_id' => $this->user_id,
			'File.id'      => $deleted
		) );
		return true;
	}
}