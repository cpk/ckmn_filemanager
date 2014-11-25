<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('CakeEmail', 'Network/Email');
App::uses('AppController', 'Controller');

/**
 * CakePHP PermissionsController
 * @author Khoa
 */
class PermissionsController extends AppController {

    var $fullAccess = array('users.login', 'users.logout');
    
    public function beforeFilter() {
        if (!$this->CheckPermission->checkAccessFull($this->fullAccess, $this->params['controller'], $this->params['action'])) {
            parent::beforeFilter();
        }
    }
    
    public function index() {
        $this->layout = 'admin';
        $this->set('heading', 'List Permissions');
        $this->set('subHeading', '');
        $this->loadModel('Permission');
        $permissions = $this->Permission->find('all',array('order' => "id ASC"));
        $this->set('permissions', $permissions);
    }
    
    public function show($id = null) {
        $this->layout = 'admin';
        $this->set('heading', 'View Permission');
        $this->set('subHeading', '');
        $this->loadModel('Permission');
        
        if (!$this->Permission->exists($id)) {
            throw new NotFoundException(__('Invalid Permission'));
        }

        $this->Permission->id = $id;
        
        // Get data
        $permission = $this->Permission->find('first', array(
            'conditions' => array('Permission.id' => $id),
        ));
        
        if ($permission == NULL) {
            $this->redirect(array('controller' => '$permission', 'action' => 'index'));
        }else {        
            $this->set('permission', $permission);
        }
    }

    public function create($id = null) {
        $this->layout = 'admin';
        $this->set('heading', 'Create Permission');
        $this->set('subHeading', '');
        $this->loadModel('Permission');
        $activeds =  array(1=>'Activated',0=>'Inactivated');
        $this->set('activeds',$activeds);
        $allPermissions = $this->Permission->find('all',array('order' => "id ASC"));
        $this->set('permissions', $allPermissions);
        
        //save data
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Permission->create();
            $this->Permission->save($this->request->data['Permission']);
            $this->redirect(array('action' => 'show', $this->Permission->id));         
        } else {
            //$this->FlashMessage->error(__('The Role could not be saved. Please, try again.'));
        }
    }

    public function edit($id = null) {
        $this->layout = 'admin';
        $this->set('heading', 'Edit Permission');
        $this->set('subHeading', '');
        $this->loadModel('Permission');

        $this->Permission->id = $id;
        
        //save data
        if ($this->request->is('post') || $this->request->is('put')) {
            $options = array('conditions' => array('Permission.id' => $id));
            $permission = $this->Permission->find('first', $options);
            $now = new DateTime();
          
            $a = $permission['Permission']['id'];
            $this->Permission->saveField('name', $this->request->data['Permission']['name']);
            $this->Permission->saveField('description', $this->request->data['Permission']['description']);
            $this->Permission->saveField('section', $this->request->data['Permission']['section']);
            $this->Permission->saveField('module', $this->request->data['Permission']['module']);
            $this->Permission->saveField('actived',$this->request->data['Permission']['actived']);
            $this->Permission->saveField('modified',$now->format('Y-m-d H:i:s'));
            $this->redirect(array('action' => 'show', $this->Permission->id));
        } else {
            // $this->FlashMessage->error(__('The Role could not be saved. Please, try again.'));
        }
                
        // Get data
        $permissions = $this->Permission->find('first', array(
            'conditions' => array('Permission.id' => $id),
        ));
        if ($permissions == NULL) {
            $this->redirect(array('controller' => 'permissions', 'action' => 'index'));
        }
        
        $this->set('permission', $permissions);
        $activeds =  array(1=>'Actived',0=>'InActived');
        $this->set('activeds',$activeds);
    }
    
    public function delete($id = null) {
        $this->loadModel('Permission');

        $this->Permission->id = $id;
        if (!$this->Permission->exists()) {
            throw new NotFoundException(__('Invalid permission'));
        }
        
        $options = array('conditions' => array('Permission.id' => $id));
        $permission = $this->Permission->find('first', $options);

      
        $this->Permission->id = $permission['Permission']['id'];
        $this->Permission->saveField('actived', 0);

        if ($this->Permission->save()) {
            //$this->FlashMessage->success(__('The Role has been saved'));
             $this->redirect(array('action' => 'index'));
        } else {
           // $this->FlashMessage->error(__('The Role could not be saved. Please, try again.'));
        }
        //$this->FlashMessage->error(__('Role was not deleted.'));
        $this->redirect(array('action' => 'index'));
    }
    
    public function export() {
        $this->autoLayout = false;
        $this->autoRender = false;
        $this->response->download("permission.csv");
        $this->loadModel('Permission');
        $permissions = $this->Permission->find('all');

        $cols = array(
            'id' => 'ID', 'name' => 'Name', 'description' => 'Description',
            'section' => 'Section', 'module' => 'Module', 'actived' => 'Status'
        );

        header("Content-type:text/octect-stream");
        header("Content-Disposition:attachment;filename=Users.csv");

        // Generate headers
        print '"' . stripslashes(implode('","', $cols)) . "\"\n";

        // Generate rows
        for ($i = 0; $i < count($permissions); $i++) {
            $row = array();
            $row[] = $permissions[$i]['Permission']['id'];
            $row[] = $permissions[$i]['Permission']['name'];
            $row[] = $permissions[$i]['Permission']['description'];
            $row[] = $permissions[$i]['Permission']['section'];
            $row[] = $permissions[$i]['Permission']['module'];
            $row[] = $permissions[$i]['Permission']['actived'];
            print '"' . stripslashes(implode('","', $row)) . "\"\n";
        }
    }

}
