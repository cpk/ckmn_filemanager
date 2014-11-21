<?php

class FlashMessageComponent extends SessionComponent{
    
    public function initialize(&$controller, $settings = array()) {
        $this->controller = $controller;
    }
    
    public function setFlash($message, $key = '', $element = 'default', $param = array()) {
        if($key == '') {
            $key = $this->controller->controller;
        }
        parent::setFlash($message, $element, $param, $key);
    }
    
    public function success($message, $key = '', $element = 'default', $param = array('class' => 'success')) {
        if($key == '') {
            $key = $this->controller->controller . '.' . $this->controller->action;
        }
        parent::setFlash($message, $element, $param, $key);
    }
    
    public function error($message, $key = '', $element = 'default', $param = array('class' => 'error')) {
        if($key == '') {
            $key = $this->controller->controller . '.' . $this->controller->action;
        }
        parent::setFlash($message, $element, $param, $key);
    }

}
