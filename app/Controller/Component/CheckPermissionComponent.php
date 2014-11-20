<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CheckPermissionComponent extends Component {

    public function getRole($userId = null) {
        $usersModel = ClassRegistry::init('users');
        $rolesModel = ClassRegistry::init('roles');
        $usersRolesModel = ClassRegistry::init('users_roles');
        if ($userId == null) {
            return null;
        }
        $options = array(
            'joins' => array(
                array('table' => 'users_roles', 'alias' => 'RoleUser', 'type' => 'right',
                    'conditions' => array(
                        'roles.id = RoleUser.user_id',
                        'RoleUser.user_id' => $userId,
                    )
                ),
            ),
            'fields' => array('roles.id', 'roles.name'),
        );
        $roles = $rolesModel->find('all', $options);
        return $roles;
    }

    public function getPermissionFromUserId($userId = null) {
        $usersModel = ClassRegistry::init('users');
        $permissionsModel = ClassRegistry::init('permissions');
        $usersPermissionsModel = ClassRegistry::init('users_permissions');
        if ($userId == null) {
            return null;
        }
        $options = array(
            'joins' => array(
                array('table' => 'users_permissions', 'alias' => 'UserPermission', 'type' => 'right',
                    'conditions' => array(
                        'permissions.id = UserPermission.user_id',
                        'UserPermission.user_id' => $userId,
                        )
                ),
            ),
            'fields' => array('permissions.id', 'permissions.name'),
        );
        $permissions = $permissionsModel->find('all', $options);
        return $permissions;
    }

    public function getPermissionFromRoleId($rolesId = null) {
        $rolesModel = ClassRegistry::init('roles');
        $permissionsModel = ClassRegistry::init('permissions');
        $rolesPermissionsModel = ClassRegistry::init('roles_permissions');
        if ($rolesId == null) {
            return null;
        }
        $options = array(
            'joins' => array(
                array('table' => 'roles_permissions', 'alias' => 'RolePermission', 'type' => 'right',
                    'conditions' => array(
                        'permissions.id = RolePermission.permission_id',
                        'RolePermission.role_id' => $rolesId,
                        )
                ),
            ),
            'fields' => array('permissions.id', 'permissions.name'),
        );
        $permissions = $permissionsModel->find('all', $options);
        return $permissions;
    }
    
    public function checkPermission($userId = null, $controller, $action){
        if ($userId == null) {
            $user = $this->currentUser;
            $userId = $user['id'];
        }
        $permissions = $this->getPermissionFromUserId($userId);
        $roles = $this->getRole($userId);
        for($i=0; $i<count($roles); $i++){
            $permissions = array_merge($permissions, $this->getPermissionFromRoleId($roles[$i]['roles']['id']));
        }
        foreach($permissions as $permission){
            $permissionName = $controller.'.'.$action;
            if($permission['permissions']['name'] == $permissionName){
                return true;
            }
        }
        return false;
    }

    public function checkAccessFull($fullAccess, $controller, $action){
        $access = false;
        foreach($fullAccess as $permission){
            $permissionName = $controller.'.'.$action;
            if($permissionName == $permission){
                $access = true;
            }
        }
        return $access;
    }
}
