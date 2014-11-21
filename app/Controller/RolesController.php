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

}
