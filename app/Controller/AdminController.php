<?php

App::uses('AppController', 'Controller');
App::uses('Tree', 'Lib');

class AdminController extends AppController {

    public $layout = 'Sentir';

    public function beforeFilter() {
        parent::beforeFilter();
        if ($this->Auth->loggedIn()) {
            $this->layout = 'admin';
        } else {
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
    }

    public function index() {
        $this->redirect(array('controller' => 'admin', 'action' => 'dashboard'));
    }

    public function dashboard() {        
        $this->set('heading', 'Dashboard');
        $this->set('subHeading', '');
    }

    public function update() {
        
    }

}
