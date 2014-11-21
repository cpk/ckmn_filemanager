<?php

App::uses('AppController', 'Controller');
App::uses('Tree', 'Lib');
class FileManagersController extends AppController{
	public function index() {
		$this->layout = 'admin';

		$items = array(
			array(
				'id'=>123,
				'type'=>'folder',
				'name'=> 'Yahoo.jpg'
			),
			array(
				'id'=>456,
				'type'=>'zip',
				'name'=> 'Haha.jpg'
			),

		);
		$this->set('items', $items);
	}

	public function getFolderTree( $parent_id = null ) {

	}
} 