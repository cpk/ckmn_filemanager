<?php
App::uses( 'AppController', 'Controller' );
class ThongBaoController  extends AppController {

	public function index(){
		$this->layout = 'admin2';
		$this->set('heading', 'Thông báo');
	}

	public function read() {
		$this->layout = 'admin2';
		$this->set('heading', 'Thông báo Lorem ipsum dolor sit amet, consectetuer adipiscing elit');
	}
} 