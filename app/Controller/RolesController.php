<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('CakeEmail', 'Network/Email');
App::uses('AppController', 'Controller');

/**
 * CakePHP RolesController
 * @author Khoa
 */
class RolesController extends AppController {

    public function index() {
        $this->layout = 'admin';
        $this->set('heading', 'List Roles');
        $this->set('subHeading', '');
    }

}
