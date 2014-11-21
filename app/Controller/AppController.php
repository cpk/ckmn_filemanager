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
    );
    
    public function beforeFilter() {
        $this->Auth->authenticate = array('Custom');
        $this->currentUser = $this->Session->read('Auth.User');
        $this->set('currentUser', $this->currentUser);
        if(!$this->CheckPermission->checkPermission($this->currentUser['id'], $this->params['controller'], $this->params['action'])){
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
}
