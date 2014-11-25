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

    var $fullAccess = array('users.login', 'users.logout');

    public function beforeFilter() {
        if (!$this->CheckPermission->checkAccessFull($this->fullAccess, $this->params['controller'], $this->params['action'])) {
            parent::beforeFilter();
                $this->Auth->allow('create',  'ajaxCheckExistence');
        }
    }

    public function index() {
        $this->layout = 'admin';
        $this->set('heading', 'List Users');
        $this->set('subHeading', '');
        $this->loadModel('User');
        $this->loadModel('UsersRole');
        $this->loadModel('Role');
        $users = $this->User->find('all');
        foreach ($users as $key => $user) {
            $options = array(
                'conditions' => array('UsersRole.user_id' => $user['User']['id'])
            );
            $usersRoles = $this->UsersRole->find('all', $options);
            $roles = array();
            foreach ($usersRoles as $usersRole) {
                $options = array(
                    'conditions' => array('id' => $usersRole['UsersRole']['role_id']),
                    'fields' => array('id', 'name', 'description'),
                );
                $roles[] = $this->Role->find('first', $options);
            }
            $user['User']['Role'] = $roles;
            $users[$key] = $user;
        }
        $this->set('users', $users);
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
        $this->set('heading', 'View User');
        $this->set('subHeading', '');
        $this->loadModel('User');
        $this->loadModel('UsersRole');
        $this->loadModel('Role');
        $this->loadModel('RolesPermission');
        $this->loadModel('Permission');
        $this->loadModel('UsersPermission');

        $this->User->id = $id;

        // Get data
        $user = $this->User->find('first', array(
            'conditions' => array('User.id' => $id),
        ));
        if ($user == NULL) {
            $this->redirect(array('controller' => 'users', 'action' => 'index'));
        }
        $options = array(
            'conditions' => array('UsersRole.user_id' => $user['User']['id'])
        );
        $usersRoles = $this->UsersRole->find('all', $options);
        $roles = array();
        foreach ($usersRoles as $usersRole) {
            $options = array(
                'conditions' => array('id' => $usersRole['UsersRole']['role_id']),
                'fields' => array('id', 'name', 'description'),
            );
            $roles[] = $this->Role->find('first', $options);
        }
        $permissions = array();
        foreach ($roles as $key => $role) {
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
        }
        $options = array(
            'conditions' => array('UsersPermission.user_id' => $user['User']['id'])
        );
        $usersPermissions = $this->UsersPermission->find('all', $options);
        foreach ($usersPermissions as $usersPermission) {
            $options = array(
                'conditions' => array('id' => $usersPermission['UsersPermission']['permission_id']),
                'fields' => array('id', 'name', 'description'),
            );
            $permission = $this->Permission->find('first', $options);
            $permissions[] = $permission['Permission'];
        }
        if(is_array($permissions))
            $permissions = $this->Common->subval_sort($permissions, 'name');
        if ($user != NULL) {
            $this->set('user', $user);
            $this->set('roles', $roles);            
            $this->set('permissions', $permissions);
        } else
            throw new NotFoundException(__('Invalid Role'));
    }

    public function edit($id = null) {
        $this->layout = 'admin';
        $this->set('heading', 'Edit User');
        $this->set('subHeading', '');
        $this->loadModel('User');
        $this->loadModel('UsersRole');
        $this->loadModel('Role');
        $this->loadModel('RolesPermission');
        $this->loadModel('Permission');
        $this->loadModel('UsersPermission');

        $this->User->id = $id;
        
        //save data
        if ($this->request->is('post') || $this->request->is('put')) {
            
            $this->User->saveField('first_name', $this->request->data['User']['first_name']);
            $this->User->saveField('last_name', $this->request->data['User']['last_name']);
            $this->User->saveField('actived',$this->request->data['User']['actived']);
            if ($this->request->data['User']['password'] != '') {
                    $this->User->saveField('password', $this->request->data['User']['password']);
                } 
                //cho nay la sao ta @@
            if (!$this->User->save()) {
                //insert permission
                $user_id= $this->User->id;
                $request = $this->request->data;
                
                $this->UsersPermission->deleteAll(array('UsersPermission.user_id'=>$id,false));
                $this->UsersRole->deleteAll(array('UsersRole.user_id'=>$id,false));
               
                foreach ($request as $item => $data){
                   //  if($item !="User"){
                          if($item =="User"){
                            $i=0;
                            foreach ($data as $key=>$value){ 
                                $i++;
                                if($i>7){
                                    if($value != 0){
                                        $this->UsersRole->create();
                                        $info = array();
                                        $now = new DateTime();
                                        $info['UsersRole']['user_id'] = $user_id;
                                        $info['UsersRole']['role_id'] = $value;
                                       // $info['UsersRole']['created'] = $now->format('Y-m-d H:i:s'); 
                                        //$info['UsersRole']['modified'] = $now->format('Y-m-d H:i:s'); 
                                        $this->UsersRole->save($info['UsersRole']);
                                    }
                                }
                             }
                        }  else {
                                foreach ($data as $key=>$value){
                                    if($value != 0){
                                        $this->UsersPermission->create();
                                        $info = array();
                                        $now = new DateTime();
                                        $info['UsersPermission']['user_id'] = $user_id;
                                        $info['UsersPermission']['permission_id'] = $value;
                                        $info['UsersPermission']['created'] = $now->format('Y-m-d H:i:s'); 
                                        $info['UsersPermission']['modified'] = $now->format('Y-m-d H:i:s'); 
                                        $this->UsersPermission->save($info['UsersPermission']);
                                    }
                                }
                           
                        }
                    // }
                }
                //$this->FlashMessage->success(__('The Role has been saved'));
                $this->redirect(array('action' => 'show', $this->User->id));
            } else {
                die('save loi');
               // $this->FlashMessage->error(__('The Role could not be saved. Please, try again.'));
            }
        }
        
        // Get data
        $user = $this->User->find('first', array(
            'conditions' => array('User.id' => $id),
        ));
        if ($user == NULL) {
            $this->redirect(array('controller' => 'users', 'action' => 'index'));
        }
        $options = array(
            'conditions' => array('UsersRole.user_id' => $user['User']['id'])
        );
        $usersRoles = $this->UsersRole->find('all', $options);
        $roles = array();
        foreach ($usersRoles as $usersRole) {
            $options = array(
                'conditions' => array('id' => $usersRole['UsersRole']['role_id']),
                'fields' => array('id', 'name', 'description'),
            );
            $roles[] = $this->Role->find('first', $options);
        }
        $permissions = array();
        foreach ($roles as $key => $role) {
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
        }
        $options = array(
            'conditions' => array('UsersPermission.user_id' => $user['User']['id'])
        );
        $usersPermissions = $this->UsersPermission->find('all', $options);
        foreach ($usersPermissions as $usersPermission) {
            $options = array(
                'conditions' => array('id' => $usersPermission['UsersPermission']['permission_id']),
                'fields' => array('id', 'name', 'description'),
            );
            $permission = $this->Permission->find('first', $options);
            $permissions[] = $permission['Permission'];
        }
        $permissions = $this->Common->subval_sort($permissions, 'name');
        
        $allRoles = $this->Role->find('all');
        $allPermissions = $this->Permission->find('all',array('order' => "name ASC"));
        foreach ($allRoles as $key => $role) {
            $role['Role']['allow'] = 0;
            foreach ($roles as $key1 => $roleAllow) {
                if($role['Role']['id'] == $roleAllow['Role']['id']){
                    $role['Role']['allow'] = 1;
                    break;
                }
            }
            $allRoles[$key] = $role;
        }
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
        $this->set('id',$id);
        $this->set('user', $user);
        $this->set('roles', $allRoles);
        $this->set('permissions', $allPermissions);
        $activeds =  array(1=>'Actived',0=>'InActived');
        $this->set('activeds',$activeds);
        $user['User']['password']="";
        $this->request->data =$user;
    }

    public function create($id = null) {
        $this->layout = 'admin';
        $this->set('heading', 'Create User');
        $this->set('subHeading', '');
        $this->loadModel('User');
        $this->loadModel('UsersRole');
        $this->loadModel('Role');
        $this->loadModel('RolesPermission');
        $this->loadModel('Permission');
        $this->loadModel('UsersPermission');
        $activeds =  array(1=>'Actived',0=>'InActived');
         
        //save data
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->User->create();
            if ($this->User->save($this->request->data['User'])) {
                //insert permission
                $user_id= $this->User->id;
                $request = $this->request->data;
                
                foreach ($request as $item => $data){
                   //  if($item !="User"){
                         //xem lai cho nay @@
                         if($item =="User"){
                             $i=0;
                            foreach ($data as $key=>$value){
                                $i++;
                                if($i>7){
                                    if($value != 0){
                                        $this->UsersRole->create();
                                        $info = array();
                                        $now = new DateTime();
                                        $info['UsersRole']['user_id'] = $user_id;
                                        $info['UsersRole']['role_id'] = $value;
                                       // $info['UsersRole']['created'] = $now->format('Y-m-d H:i:s'); 
                                        //$info['UsersRole']['modified'] = $now->format('Y-m-d H:i:s'); 
                                        $this->UsersRole->save($info['UsersRole']);
                                    }
                                }
                            }
                        }else {
                                foreach ($data as $key=>$value){
                                    if($value != 0){
                                        $this->UsersPermission->create();
                                        $info = array();
                                        $now = new DateTime();
                                        $info['UsersPermission']['user_id'] = $user_id;
                                        $info['UsersPermission']['permission_id'] = $value;
                                        $info['UsersPermission']['created'] = $now->format('Y-m-d H:i:s'); 
                                        $info['UsersPermission']['modified'] = $now->format('Y-m-d H:i:s'); 
                                        $this->UsersPermission->save($info['UsersPermission']);
                                    }
                                }
                           
                        }
                   //  }
                }
                //$this->FlashMessage->success(__('The Role has been saved'));
                $this->redirect(array('action' => 'show', $this->User->id));
            } else {
               // $this->FlashMessage->error(__('The Role could not be saved. Please, try again.'));
            }
        }
        
        //create
        $this->set('activeds',$activeds);
        $allRoles = $this->Role->find('all');
        $allPermissions = $this->Permission->find('all',array('order' => "name ASC"));
        $this->set('roles', $allRoles);
        $this->set('permissions', $allPermissions);
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

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    public function account_setting() {
        $this->layout = 'admin';
        $this->set('heading', 'My Account');
        $this->set('subHeading', '');
    }

    public function change_password() {
        $this->layout = 'admin';
        $this->set('heading', 'Change Password');
        $this->set('subHeading', '');
    }

    public function export() {
        $this->autoLayout = false;
        $this->autoRender = false;
        $this->response->download("users.csv");
        $this->loadModel('User');
        $this->loadModel('UsersRole');
        $this->loadModel('Role');
        $users = $this->User->find('all');
        foreach ($users as $key => $user) {
            $options = array(
                'conditions' => array('UsersRole.user_id' => $user['User']['id'])
            );
            $usersRoles = $this->UsersRole->find('all', $options);
            $roles = array();
            foreach ($usersRoles as $usersRole) {
                $options = array(
                    'conditions' => array('id' => $usersRole['UsersRole']['role_id']),
                    'fields' => array('id', 'name', 'description'),
                );
                $roles[] = $this->Role->find('first', $options);
            }
            $user['User']['Role'] = $roles;
            $users[$key] = $user;
        }

        $cols = array(
            'id' => 'ID', 'first_name' => 'First Name', 'last_name' => 'Last Name',
            'email' => 'Email', 'username' => 'Username', 'Role' => 'Role', 'actived' => 'Status'
        );

        header("Content-type:text/octect-stream");
        header("Content-Disposition:attachment;filename=Users.csv");

        // Generate headers
        print '"' . stripslashes(implode('","', $cols)) . "\"\n";

        // Generate rows
        for ($i = 0; $i < count($users); $i++) {
            $row = array();
            $row[] = $users[$i]['User']['id'];
            $row[] = $users[$i]['User']['first_name'];
            $row[] = $users[$i]['User']['last_name'];
            $row[] = $users[$i]['User']['username'];
            $row[] = $users[$i]['User']['email'];
            $role = array();
            for ($j = 0; $j < count($users[$i]['User']['Role']); $j++) {
                $role[] = $users[$i]['User']['Role'][$j]['Role']['description'];
            }
            $row[] = '(' . stripslashes(implode('","', $role)) . ')';
            $row[] = $users[$i]['User']['actived'];
            print '"' . stripslashes(implode('","', $row)) . "\"\n";
        }
    }

    public function isExistUsername($username) {
        $condition = array(
            'conditions' => array(
                'User.username' => $username,
            )
        );
        $user = $this->User->find('first', $condition);
        return ($user != null);
    }

    public function isExistEmail($email) {
        $condition = array(
            'conditions' => array(
                'User.email' => $email,
            )
        );
        $user = $this->User->find('first', $condition);
        return ($user != null);
    }

    // For ajax check existence: false->exist, true->not exist
    function ajaxCheckExistence() {
         $this->layout = 'ajax';
         $this->autoRender = false;
         $this->loadModel('User');
        if (isset($this->params->data['field']) && isset($this->params->data['value'])) {
           

            $result = 'true'; // not exist

            if ($this->params->data['field'] == 'username') {
                if ($this->isExistUsername($this->params->data['value'])) {
                    $result = 'false';
                }
            } else if ($this->params->data['field'] == 'email') {
                if ($this->isExistEmail($this->params->data['value'])) {
                    $result = 'false';
                }
            }
            echo $result;
        }
         
    }
    
    
}
