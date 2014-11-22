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

        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid Role'));
        }

        $this->User->id = $id;

        // Get data
        $user = $this->User->find('first', array(
            'conditions' => array('User.id' => $id),
        ));
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
        if (!$this->Role->exists($id)) {
            throw new NotFoundException(__('Invalid Role'));
        }

        $this->User->id = $id;

        // Get data
        $user = $this->User->find('first', array(
            'conditions' => array('User.id' => $id),
        ));
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
            foreach ($roles as $key => $roleAllow) {
                if($role['Role']['id'] == $roleAllow['Role']['id']){
                    $role['Role']['allow'] = 1;
                    break;
                }
            }
            $allRoles[$key] = $role;
        }
        foreach ($allPermissions as $key => $permission) {
            $permission['Permission']['allow'] = 0;
            foreach ($permissions as $key => $permissionAllow) {
                if($permission['Permission']['id'] == $permissionAllow['id']){
                    $permission['Permission']['allow'] = 1;
                    break;
                }
            }
            $allPermissions[$key] = $permission;
        }
        $this->set('user', $user);
        $this->set('roles', $allRoles);
        $this->set('permissions', $allPermissions);
        $activeds =  array(1=>'Actived',0=>'InActived');
        $this->set('activeds',$activeds);
    }

    public function create($id = null) {
        $this->layout = 'admin';
        $this->set('heading', 'Create User');
        $this->set('subHeading', '');
        $this->loadModel('Role');
        $this->loadModel('Permission');
        $activeds =  array(1=>'Actived',0=>'InActived');
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

}
