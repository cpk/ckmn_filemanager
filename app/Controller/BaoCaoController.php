<?php
App::uses( 'AppController', 'Controller' );
class BaoCaoController  extends AppController {

	public function index(){
		$this->layout = 'admin2';
		$this->set('heading', 'Báo cáo');
	}

	public function read() {
		$this->layout = 'admin2';
		$this->set('heading', 'Báo cáo Lorem ipsum dolor sit amet, consectetuer adipiscing elit');
	}
} 