<?php
App::uses( 'Controller', 'Controller' );
App::uses( 'Tree', 'Lib' );

class AdminController extends Controller {
	public $layout = 'Sentir';

	public function beforeFilter() {
		$tree = new Tree();
		$tree->setData( $this->getMenus() );
		$tree->parent_item_field = 'parent_id';
		$tree->item_id_field     = 'id';

		$this->set('slidebar_left_tree', $tree->getChildrensTree(null, 2));
	}

	protected function getMenus() {
		$data = array(
			array( 'title' => 'A', 'url' => '#', 'content' => '', 'icon' => 'leaf', 'id' => 1, 'parent_id' => null ),
			array( 'title' => 'B', 'url' => '#', 'content' => '', 'icon' => 'leaf', 'id' => 2, 'parent_id' => 1 ),
			array( 'title' => 'C', 'url' => '#', 'content' => '', 'icon' => 'leaf', 'id' => 3, 'parent_id' => 1 ),
			array( 'title' => 'D', 'url' => '#', 'content' => '', 'icon' => 'leaf', 'id' => 4, 'parent_id' => 1 ),
			array( 'title' => 'E', 'url' => '#', 'content' => '', 'icon' => 'leaf', 'id' => 5, 'parent_id' => 1 ),
			array( 'title' => 'F', 'url' => '#', 'content' => '', 'icon' => 'leaf', 'id' => 6, 'parent_id' => null ),
			array( 'title' => 'G', 'url' => '#', 'content' => '', 'icon' => 'leaf', 'id' => 7, 'parent_id' => 6 ),
			array( 'title' => 'H', 'url' => '#', 'content' => '', 'icon' => 'leaf', 'id' => 8, 'parent_id' => 6 ),
			array( 'title' => 'I', 'url' => '#', 'content' => '', 'icon' => 'leaf', 'id' => 9, 'parent_id' => 6 ),
			array( 'title' => 'J', 'url' => '#', 'content' => '', 'icon' => 'leaf', 'id' => 10, 'parent_id' => 6 ),
			array( 'title' => 'K', 'url' => '#', 'content' => '', 'icon' => 'leaf', 'id' => 11, 'parent_id' => 10 ),
			array( 'title' => 'L', 'url' => '#', 'content' => '', 'icon' => 'leaf', 'id' => 12, 'parent_id' => 10 ),
			array( 'title' => 'M', 'url' => '#', 'content' => '', 'icon' => 'leaf', 'id' => 13, 'parent_id' => 10 ),
			array( 'title' => 'N', 'url' => '#', 'content' => '', 'icon' => 'leaf', 'id' => 14, 'parent_id' => 10 )

		);
		return $data;
	}
}