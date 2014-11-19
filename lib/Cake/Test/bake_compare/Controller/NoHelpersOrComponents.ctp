<?php
App::uses('AppController', 'Controller');
/**
 * Articles Controller
 *
 * @property Article $Article
 * @property PaginatorComponent $Paginator
 */
class ArticlesController extends FileManagers {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

}
