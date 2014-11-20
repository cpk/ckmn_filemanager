<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('CakeEmail', 'Network/Email');
App::uses('AppController', 'Controller');


/**
 * CakePHP usersController
 * @author Khoa
 */
class usersController extends AppController {

    public function index() {
        
    }

    public function login() {
        $this->layout = 'login';
        
        if ($this->request->is('post')) {            
            if ($this->Auth->login()) {
                //$this->User->afterLogin(); // Record login action into audit log
                if ($this->Session->read('lastUrl')) {
                    $this->redirect($this->Session->read('lastUrl'));
                    exit;
                } else {
                    // Redirect to default page when login successfully
                    $this->redirect($this->Auth->loginRedirect);
                }
            } else {    
                //$this->FlashMessage->error(__('Invalid username or password, try again'));
            }
        }
    }
    
     public function logout() {;
        $this->redirect($this->Auth->logout());
    }
    

}
