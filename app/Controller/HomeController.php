<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP HomeController
 * @author Khoa
 */
class HomeController extends AppController {
    var $layout = 'admin';
    var $fullAccess = array('home.denied');
    
    public function beforeFilter() {
        if ($this->Auth->loggedIn()) {
            $this->layout = 'admin';
        } else {
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
//        var_dump($this->controller);die();
        if(!$this->CheckPermission->checkAccessFull($this->fullAccess, $this->params['controller'], $this->params['action'])){
            parent::beforeFilter();
        }        
    }
    
    public function denied() {
        $this->layout = 'admin';
    }

}
