<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $webroot;
    public $currentUser;
    public $currentTime;
    public $controller;
    public $action;
    var $helpers = array('Html');
    public static $uploadPath = 'img/uploads/';
    public static $imgExts = array('jpg', 'png');
    public $components = array(
        'CheckPermission',
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'admin', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'index')
        ),
        'CSV',
        'Common'
    );
    public $notifyLink = array();
    public $notifyMessage = array();
    public $notifications;

    public function beforeFilter() {
        $this->Auth->authenticate = array('Custom');
        $this->currentUser = $this->Session->read('Auth.User');
        $this->set('currentUser', $this->currentUser);
        $this->getNotify();
        $this->getNotifyDataType();
        $this->set('notifyLink', $this->notifyLink);
        $this->set('notifyMessage', $this->notifyMessage);
        return true;
        if (!$this->CheckPermission->checkPermission($this->currentUser['id'], $this->params['controller'], $this->params['action'])) {
            $this->redirect(array('controller' => 'home', 'action' => 'denied'));
        }
    }

    function beforeRender() {
        $this->Auth->authenticate = array('Custom');
        $this->webroot = Router::url('/', true);
        $this->set('webroot', $this->webroot);
        $this->currentUser = $this->Session->read('Auth.User');
        $this->set('currentUser', $this->currentUser);
        $this->currentTime = gmdate('Y-m-d H:i:s');
        $this->set('currentTime', $this->currentTime);
        $this->controller = $this->params['controller'];
        $this->set('controller', $this->params['controller']);
        $this->action = $this->params['action'];
        $this->set('action', $this->params['action']);
        if ($this->name == 'CakeError') {
            $this->layout = 'error';
        }
    }
    
    function getNotifyDataType() {
        $this->loadModel('NotificationType');
        $notiesLink = $this->NotificationType->find('all');
        foreach ($notiesLink as $data){
            $this->notifyMessage[$data['NotificationType']['id']] = $data['NotificationType']['message'];
            $this->notifyLink[$data['NotificationType']['id']] = $data['NotificationType']['controller'].'/'.$data['NotificationType']['action'];
        }
    }

    function getNotify() {
        $this->loadModel('Notification');
        $this->loadModel('UsersNotification');
        $options = array(
            'conditions' => array(
                'user_id' => $this->currentUser['id'],
            ),
        );
        $usersNotifications = $this->UsersNotification->find('all', $options);
        $notifications = array();
        $notificationsUnread = array();
        foreach ($usersNotifications as $key => $usersNotification) {
            $options = array(
                'joins' => array(
                    array('table' => 'users', 'alias' => 'User', 'type' => 'inner',
                        'conditions' => array('User.id = Notification.user_create')),
                ),
                'conditions' => array(
                    'Notification.id' => $usersNotification['UsersNotification']['notification_id'],
                ),
                'order' => "Notification.date_create DESC",
                'fields' => array('Notification.id', 'Notification.content', 'Notification.date_create',
                    'Notification.type', 'Notification.status', 'User.first_name', 'User.last_name', 'User.id')
            );
            $notifications[] = $this->Notification->find('first', $options);
            $options = array(
                'joins' => array(
                    array('table' => 'users', 'alias' => 'User', 'type' => 'inner',
                        'conditions' => array('User.id = Notification.user_create')),
                ),
                'conditions' => array(
                    'Notification.id' => $usersNotification['UsersNotification']['notification_id'],
                    'Notification.status' => 0,
                ),
                'order' => "Notification.date_create DESC",
                'fields' => array('Notification.id', 'Notification.content', 'Notification.date_create',
                    'Notification.type', 'Notification.status', 'User.first_name', 'User.last_name', 'User.id')
            );
            $notificationUnread = $this->Notification->find('first', $options);
            if(count($notificationUnread) > 0){
                $notificationsUnread[] = $notificationUnread;
            }
        }
        $this->notifications = $notifications;
        $this->set('notifications', $notifications);
        $this->set('newCount', count($notificationsUnread));
    }

}
