<?php

App::uses('AppController', 'Controller');
App::import('Controller', 'App');

class NotificationController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
        $this->layout = 'admin';
        $this->set('heading', 'Thông báo');
    }

    public function read($id) {
        $this->layout = 'admin';
        $this->set('heading', 'Thông báo');        
        $this->loadModel('Notification');

        $this->Notification->id = $this->notifications[$id]['Notification']['id'];
        $this->Notification->saveField('status', 1);
        var_dump($this->Notification->id);
        $this->Notification->save();
        $options = array('conditions' => array('Notification.id' => $this->Notification->id));
        $notification = $this->Notification->find('first', $options);
        
        $this->set('notification', $this->notifications[$id]);
        $this->set('id', $id);
        $this->set('notifications', $this->notifications);
    }

}
