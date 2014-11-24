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
        $this->loadModel('RolesPermission');
        $this->loadModel('Permission');
        
         if (!$this->Role->exists($id)) {
            throw new NotFoundException(__('Invalid Role'));
        }
        
        $this->Role->id = $id;
        
          // Get data
       $role = $this->Role->find('first', array(
            'conditions' => array('Role.id' => $id), 
        ));
        
        if ($role == NULL) {
            $this->redirect(array('controller' => 'roles', 'action' => 'index'));
        }
        
        $permissions = array();
        $options = array(
            'conditions' => array('RolesPermission.role_id' => $role['Role']['id'])
        );
        $rolesPermissions = $this->RolesPermission->find('all', $options);
        foreach ($rolesPermissions as $rolesPermission) {
            $options = array(
                'conditions' => array('id' => $rolesPermission['RolesPermission']['permission_id']),
                'fields' => array('id', 'name', 'description'),
            );
            $permission = $this->Permission->find('first', $options);
            $permissions[] = $permission['Permission'];
        }
        $permissions = $this->Common->subval_sort($permissions, 'name');
        
        $this->set('id', $id);
        $this->set('role', $role);
         $this->request->data =$role;
        $this->set('permissions', $permissions);
        $activeds =  array(1=>'Actived',0=>'InActived');
        $this->set('activeds',$activeds);
    }
    
     public function edit($id) {
         $this->layout = 'admin';
        $this->set('heading', 'Edit Role');
        $this->set('subHeading', '');
        $this->loadModel('User');
        $this->loadModel('UsersRole');
        $this->loadModel('Role');
        $this->loadModel('RolesPermission');
        $this->loadModel('Permission');
        $this->loadModel('UsersPermission');

        $this->Role->id = $id;
        
         //save data
        if ($this->request->is('post') || $this->request->is('put')) {
            $options = array('conditions' => array('Role.id' => $id));
            $role = $this->Role->find('first', $options);
            $now = new DateTime();
          
            $a = $role['Role']['id'];
            $this->Role->saveField('name', $this->request->data['Role']['name']);
            $this->Role->saveField('level', $this->request->data['Role']['level']);
            $this->Role->saveField('description', $this->request->data['Role']['description']);
            $this->Role->saveField('actived',$this->request->data['Role']['actived']);
            $this->Role->saveField('modified',$now->format('Y-m-d H:i:s'));
            
            if ($this->Role->save()) {
                $this->RolesPermission->deleteAll(array('RolesPermission.role_id'=>$id,false));
                $role_id= $id;
                $request = $this->request->data;
                foreach ($request as $item => $data){
                     if($item !="Role"){
                         foreach ($data as $key=>$value){
                             if($value != 0){
                                 $this->RolesPermission->create();
                                 $info = array();
                                 $now = new DateTime();
                                 $info['RolesPermission']['role_id'] = $role_id;
                                 $info['RolesPermission']['permission_id'] = $value;
                                 $info['RolesPermission']['created'] = $now->format('Y-m-d H:i:s'); 
                                 $info['RolesPermission']['modified'] = $now->format('Y-m-d H:i:s'); 
                                 $this->RolesPermission->save($info['RolesPermission']);
                             }
                         }
                     }
                }
                //$this->FlashMessage->success(__('The Role has been saved'));
                $this->redirect(array('action' => 'show', $this->Role->id));
            } else {
               // $this->FlashMessage->error(__('The Role could not be saved. Please, try again.'));
            }
        }
        
        
        // Get data
        $role = $this->Role->find('first', array(
            'conditions' => array('Role.id' => $id),
        ));
        if ($role == NULL) {
            $this->redirect(array('controller' => 'roles', 'action' => 'index'));
        }
        $permissions = array();
        
        $options = array(
            'conditions' => array('RolesPermission.role_id' => $role['Role']['id'])
        );
        $rolesPermissions = $this->RolesPermission->find('all', $options);
        foreach ($rolesPermissions as $rolesPermission) {
            $options = array(
                'conditions' => array('id' => $rolesPermission['RolesPermission']['permission_id']),
                'fields' => array('id', 'name', 'description'),
            );
            $permission = $this->Permission->find('first', $options);
            $permissions[] = $permission['Permission'];
        }
        $permissions = $this->Common->subval_sort($permissions, 'name');
        $allPermissions = $this->Permission->find('all',array('order' => "name ASC"));
        foreach ($allPermissions as $key => $permission) {
            $permission['Permission']['allow'] = 0;
            foreach ($permissions as $key1 => $permissionAllow) {
                if($permission['Permission']['id'] == $permissionAllow['id']){
                    $permission['Permission']['allow'] = 1;
                    break;
                }
            }
            $allPermissions[$key] = $permission;
        }
        $this->set('id', $id);
        $this->set('role', $role);
         $this->request->data =$role;
        $this->set('permissions', $allPermissions);
        $activeds =  array(1=>'Actived',0=>'InActived');
        $this->set('activeds',$activeds);
        
    }
    
    
//     public function add() {
//        $this->layout = 'admin';
//        $this->loadModel('Role');
//        $activeds =  array(1=>'Actived',0=>'InActived');
//        $this->set('activeds',$activeds);
//    }
//    
//    
//     public function update($id) {
//         
//        $this->Role->id = $id;
//        if (!$this->Role->exists()) {
//            throw new NotFoundException(__('Invalid Role'));
//        }
//
//        $this->layout = 'ajax';
//        $this->autoRender = false;
//        
//        if ($this->request->is('post')|| $this->request->is('put')) {
//            $this->loadModel('Role');
//            $options = array('conditions' => array('Role.id' => $id));
//            $role = $this->Role->find('first', $options);
//
//          
//            $this->Role->id = $role['Role']['id'];
//            $this->Role->saveField('name', $this->request->data['Role']['name']);
//            $this->Role->saveField('level', $this->request->data['Role']['level']);
//            $this->Role->saveField('description', $this->request->data['Role']['description']);
//            $this->Role->saveField('actived',$this->request->data['Role']['actived']);
//            
//            if ($this->Role->save($this->request->data)) {
//                //$this->FlashMessage->success(__('The Role has been saved'));
//                $this->redirect(array('action' => 'show', $this->Role->id));
//            } else {
//               // $this->FlashMessage->error(__('The Role could not be saved. Please, try again.'));
//            }
//        }
//    }
    
     public function create($id=null) {
         $this->layout = 'admin';
        $this->set('heading', 'Create role');
        $this->set('subHeading', '');
        $this->loadModel('Role');
        $this->loadModel('Permission');
        $this->loadModel('RolesPermission');
        $activeds =  array(1=>'Actived',0=>'InActived');
        
        //save data
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Role->create();
            if ($this->Role->save($this->request->data['Role'])) {
                //insert permission
                $role_id= $this->Role->id;
                $request = $this->request->data;
                foreach ($request as $item => $data){
                     if($item !="Role"){
                         foreach ($data as $key=>$value){
                             if($value != 0){
                                 $this->RolesPermission->create();
                                 $info = array();
                                 $now = new DateTime();
                                 $info['RolesPermission']['role_id'] = $role_id;
                                 $info['RolesPermission']['permission_id'] = $value;
                                 $info['RolesPermission']['created'] = $now->format('Y-m-d H:i:s'); 
                                 $info['RolesPermission']['modified'] = $now->format('Y-m-d H:i:s'); 
                                 $this->RolesPermission->save($info['RolesPermission']);
                             }
                         }
                     }
                }
                //$this->FlashMessage->success(__('The Role has been saved'));
                $this->redirect(array('action' => 'show', $this->Role->id));
            } else {
               // $this->FlashMessage->error(__('The Role could not be saved. Please, try again.'));
            }
        }
        
        //create
        $this->set('activeds',$activeds);
        $allPermissions = $this->Permission->find('all',array('order' => "name ASC"));
        $this->set('permissions', $allPermissions);
        /*$this->layout = 'ajax';
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
         * */
         
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
