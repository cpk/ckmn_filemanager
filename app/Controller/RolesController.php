<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');


/**
 * CakePHP RolesController
 * @author Khoa
 */
class RolesController extends AppController {
    // public $components = array('FlashMessage');
   
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    
    public function index() {
        $this->layout = 'admin';
        $this->set('heading', 'List Roles');
        $this->set('subHeading', '');
        $this->loadModel('Role');
        $this->loadModel('RolesPermission');
        $this->loadModel('Permission');
        $roles = $this->Role->find('all');
        foreach ($roles as $key => $role) {
            $options = array(
                'conditions' => array('RolesPermission.role_id' => $role['Role']['id'])
            );
            $rolesPermissions = $this->RolesPermission->find('all', $options);
            $permissions = array();
            foreach ($rolesPermissions as $rolesPermission) {
                $options = array(
                    'conditions' => array('id' => $rolesPermission['RolesPermission']['permission_id']),
                    'fields' => array('id', 'name', 'description'),
                );
                $permissions[] = $this->Permission->find('first', $options);
            }
            $role['Role']['Permission'] = $permissions;
            $roles[$key] = $role;
        }
//        var_dump($roles);die();
        $this->set('roles', $roles);
    }
    
    
    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function show($id = null) {
        $this->layout = 'admin';
        $this->set('heading', 'View Roles');
        $this->set('subHeading', '');
        $this->loadModel('Role');
        
         if (!$this->Role->exists($id)) {
            throw new NotFoundException(__('Invalid Role'));
        }
        
        $this->Role->id = $id;
        
          // Get data
       $role = $this->Role->find('first', array(
            'conditions' => array('Role.id' => $id), 
        ));
        
         if ($role != NULL) {
            $this->set('role', $role);
        } else
            throw new NotFoundException(__('Invalid Role'));
    }
    
     public function edit($id = null) {
        $this->layout = 'admin';
        $this->loadModel('Role');
        if (!$this->Role->exists($id)) {
            throw new NotFoundException(__('Invalid Role'));
        }

        $role = $this->Role->find('first', array(
            'conditions' => array('Role.id' => $id), 
        ));
        
        $this->request->data = $role;
        $this->request->data['Role']['name'] = $role['Role']['name'];
        $this->request->data['Role']['level'] = $role['Role']['level'];
        $this->request->data['Role']['description'] = $role['Role']['description'];
        $this->request->data['Role']['actived'] = $role['Role']['description'];
        $this->set('id', $id);
        $activeds =  array(1=>'Actived',0=>'InActived');
        $this->set('activeds',$activeds);
    }
    
    
     public function add() {
        $this->layout = 'admin';
        $this->loadModel('Role');
        $activeds =  array(1=>'Actived',0=>'InActived');
        $this->set('activeds',$activeds);
    }
    
    
     public function update($id) {
         
        $this->Role->id = $id;
        if (!$this->Role->exists()) {
            throw new NotFoundException(__('Invalid Role'));
        }

        $this->layout = 'ajax';
        $this->autoRender = false;
        
        if ($this->request->is('post')|| $this->request->is('put')) {
            $this->loadModel('Role');
            $options = array('conditions' => array('Role.id' => $id));
            $role = $this->Role->find('first', $options);

          
            $this->Role->id = $role['Role']['id'];
            $this->Role->saveField('name', $this->request->data['Role']['name']);
            $this->Role->saveField('level', $this->request->data['Role']['level']);
            $this->Role->saveField('description', $this->request->data['Role']['description']);
            $this->Role->saveField('actived',$this->request->data['Role']['actived']);
            
            if ($this->Role->save($this->request->data)) {
                //$this->FlashMessage->success(__('The Role has been saved'));
                $this->redirect(array('action' => 'show', $this->Role->id));
            } else {
               // $this->FlashMessage->error(__('The Role could not be saved. Please, try again.'));
            }
        }
    }
    
     public function create() {
        $this->layout = 'ajax';
        $this->autoRender = false;

        if ($this->request->is('post') || $this->request->is('put')) {
         
            $this->Role->create();
            $this->request->data['Role']['name'] = $this->request->data['Role']['name'];
            $this->request->data['Role']['level'] = $this->request->data['Role']['level'];
            $this->request->data['Role']['description'] = $this->request->data['Role']['description'];

            if ($this->Role->save($this->request->data)) {
                //$this->FlashMessage->success(__('The Role has been saved'));
                $this->redirect(array('action' => 'show', $this->Role->id));
            } else {
               // $this->FlashMessage->error(__('The Role could not be saved. Please, try again.'));
            }
        }
    }
    
      public function delete($id = null) {
        $this->loadModel('Role');

        $this->Role->id = $id;
        if (!$this->Role->exists()) {
            throw new NotFoundException(__('Invalid role'));
        }
        
        $options = array('conditions' => array('Role.id' => $id));
        $role = $this->Role->find('first', $options);

      
        $this->Role->id = $role['Role']['id'];
        $this->Role->saveField('actived', 0);

        if ($this->Role->save()) {
            //$this->FlashMessage->success(__('The Role has been saved'));
             $this->redirect(array('action' => 'index'));
        } else {
           // $this->FlashMessage->error(__('The Role could not be saved. Please, try again.'));
        }
        //$this->FlashMessage->error(__('Role was not deleted.'));
        $this->redirect(array('action' => 'index'));
    }

}
