<?php
App::uses( 'AppController', 'Controller' );
class CalendarController  extends AppController {

	public function index(){
		$this->layout = 'admin2';
		$this->set('heading', 'Calendar');
	}


} 