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
        $this->set('heading', 'Trang chủ');
        $this->set('subHeading', '');
        
        $this->Session->setFlash(('warning nay.'),  'warning', array(), 'warning');
        $this->Session->setFlash(('success nay.'),  'success', array(), 'success');
        $this->Session->setFlash(('error nay.'),  'error', array(), 'error');
        $this->Session->setFlash(('notice nay.'),  'notice', array(), 'notice');

        
    }

    public function update() {
        
    }

}
