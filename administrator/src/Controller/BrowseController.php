<?php 
/*
  * @package component kwpanorama for Joomla! 5.x 6.x
 * @version $Id: kwpsolarsystem 1.0.0 2026-05-05 01:10:10Z $
 * @author KWProductions Co.
 * @copyright (C) 2022- KWProductions Co.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 
 This file is part of kwpanorama.
    kwpanorama is free software: you can redistribute it and/or adify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    kwpanorama is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for are details.
    You should have received a copy of the GNU General Public License
    along with kwpanorama.  If not, see <http://www.gnu.org/licenses/>.
 
*/

?>
<?php
/**
 * @name		Carousel CK
 * @package		com_carouselck
 * @copyright	Copyright (C) 2019. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.template-creator.com - https://www.joomlack.fr
 */
 namespace Joomla\Component\Kwpsolarsystem\Administrator\Controller;

// No direct access
defined('_JEXEC') or die;
/*
use Carouselck\CKController;
use Carouselck\CKFof;
*/
//use Joomla\CMS\MVC\Controller\AdminController;
//use Joomla\CMS\MVC\Controller\FormController;

use Joomla\CMS\Uri\Uri;

use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;


use Joomla\CMS\Session\Session;
//Use Joomla\CMS\Uri\Uri;
use Joomla\Component\Kwpsolarsystema\Administrator\Helper\KwpbrowseHelper;
use Joomla\Component\Kwpsolarsystem\Administrator\Helper\KwpfofHelper;
define('KWPSOLARSYSTEM_PATH', JPATH_SITE . '/administrator/components/com_kwpsolarsystem');
define('KWPSOLARSYSTEM_ADMIN_URL', Uri::root(true) . '/administrator/index.php?option=com_kwpsolarsystem');

	class BrowseController extends BaseController {
	
	protected $input;

	protected $model;

	protected $name;

	protected $prefix;

	protected $view;

	protected static $instance;

	protected static $views;
	/*
	
	public function __construct() {
		$this->input = KwpfofHelper::getInput();
	}

	 public static function getInstance($prefix, $config=[]) {
		// var_dump("quossssssssssssssssssssssssssss dah, haha");
		// exit();
		 self::$input = KwpfofHelper::getInput();

		if (is_object(self::$instance))
		{
			return self::$instance;
		}
		$basePath = KWPANORAMA_PATH;
		// Check for a controller.task command.
		$input = KwpfofHelper::getInput();

		$cmd = $input->get('task', '', 'cmd');
		if (strpos($cmd, '.') !== false)
		{
			// Explode the controller.task command.
			list ($name, $task) = explode('.', $cmd);

			// Define the controller filename and path.
			$file = self::createFileName('controller', array('name' => $name));
			$path = $basePath . '/controllers/' . $file;
			$backuppath = $basePath . '/controller/' . $file;
			// Reset the task without the controller context.
			$input->set('task', $task);
		}
		else
		{
			// Base controller.
			$name = null;

			// Define the controller filename and path.
			$file       = self::createFileName('controller', array('name' => 'controller'));
			$path       = $basePath . '/' . $file;
		}

		// Get the controller class name.
		$class = ucfirst((string)$prefix) . 'Controller' . ucfirst((string)$name);

		// Include the class if not present.
		if (!class_exists($class))
		{
			// If the controller file path exists, include it.
			if (file_exists($path))
			{
				require_once $path;
			}
			else
			{
				throw new \InvalidArgumentException(\Joomla\CMS\Language\Text::sprintf('ERROR_INVALID_CONTROLLER', $type, $format));
			}
		}

		// Instantiate the class.
		if (!class_exists($class))
		{
			throw new \InvalidArgumentException(\Joomla\CMS\Language\Text::sprintf('ERROR_INVALID_CONTROLLER_CLASS', $class));
		}

		// Instantiate the class, store it to the static container, and return it
		return self::$instance = new $class();
	}

	public static function createFileName($type, $parts = array())
	{
		$filename = '';

		switch ($type)
		{
			case 'controller':

				$filename = strtolower($parts['name'] . '.php');
				break;

			case 'view':

				//$filename = strtolower($parts['name'] . '/view.html.php');
								$filename = strtolower($parts['name'] . '/HtmlView.php');

				break;
		}

		return $filename;
	}

	// public function getModel($base = '\Carouselck\CKModel') {
		// if (empty($this->model)) {
			// $name = $this->getName();
			// require_once(CAROUSELCK_PATH . '/helpers/ckmodel.php');
			// require_once(CAROUSELCK_PATH . '/models/' . strtolower($name) . '.php');
			// $className = ucfirst($base) . ucfirst($name);
			// $this->model = new $className;
		// }
		// return $this->model;
	// }

	public function getView($name = '', $type = 'html', $prefix = '', $config=[])
	{
		// @note We use self so we only access stuff in this class rather than in all classes.
		if (!isset(self::$views))
		{
			self::$views = array();
		}

		if (empty($name))
		{
			$name = $this->getName();
		}

		if (empty($prefix))
		{
			$prefix = $this->getPrefix() . 'View';
		}

		if (empty(self::$views[$name][$type][$prefix]))
		{
			if ($view = $this->createView($name, $prefix))
			{
				self::$views[$name][$type][$prefix] = & $view;
			}
			else
			{
				throw new \Exception(\Joomla\CMS\Language\Text::sprintf('ERROR_VIEW_NOT_FOUND', $name, $type, $prefix), 404);
			}
		}

		return self::$views[$name][$type][$prefix];
	}

	protected function createView($name, $prefix = '', $type='', $config=[])
	{
		// Clean the view name
		$viewName = preg_replace('/[^A-Z0-9_]/i', '', $name);
		$classPrefix = preg_replace('/[^A-Z0-9_]/i', '', $prefix);

		// Build the view class name
		$viewClass = $classPrefix . ucfirst($viewName);

		if (!class_exists($viewClass))
		{
			$path = KWPANORAMA_PATH . '/views/' . $this->createFileName('view', array('name' => $viewName));

			if (!$path)
			{
				return null;
			}

			require_once $path;

			if (!class_exists($viewClass))
			{
				throw new \Exception(\Joomla\CMS\Language\Text::_('ERROR_VIEW_CLASS_NOT_FOUND : ' . $viewClass . ' - ' . $path), 500);
			}
		}

		return new $viewClass();
	}
	
*/
	public function display($cachable=false, $urlparams=[]) {
	//	var_dump("qussssssssssssssssdah");
		//exit();
		$viewName = $this->input->get('view', $this->getName());
		$viewLayout = $this->input->get('layout', 'default', 'string');

		$view = $this->getView($viewName, 'html', '');
		$view->setName($viewName);

		// Get/Create the model
		if ($model = $this->getModel($viewName))
		{
			// Push the model into the view (as default)
			$view->setModel($model);
		}


		$view->display();

		return $this;
	}
/*
	public function getModel($name = '', $prefix = '', $config = array())
	{
		if (empty($name))
		{
			$name = ucfirst($this->getName());
		}

		if (empty($prefix))
		{
			$prefix = ucfirst($this->getPrefix());
		}

		$model = $this->createModel($name, $prefix, $config);

		return $model;
	}

	protected function createModel($name, $prefix = '', $config = array())
	{
		// Clean the model name
		$modelName = preg_replace('/[^A-Z0-9_]/i', '', $name);
		$classPrefix = preg_replace('/[^A-Z0-9_]/i', '', $prefix);

		//return KWPModel::getInstance($modelName, $classPrefix, $config);
				return BrowseModel::getInstance($modelName, $classPrefix, $config);

	}


	public function execute($task) {
		if (! $task) $task = 'display';
		if (is_callable(array($this, $task))) {
			return $this->$task();
		}
		else
		{
			throw new \Exception(\Joomla\CMS\Language\Text::sprintf('ERROR_TASK_NOT_FOUND', $task), 404);
		}

		return;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName()
	{
		if (empty($this->name))
		{
			$r = null;

			if (!preg_match('/Controller(.*)/i', get_class($this), $r))
			{
				throw new \Exception(\CKText::_('Error : Can not get controller name'), 500);
			}

			$this->name = strtolower($r[1]);
		}

		return $this->name;
	}

	public function getPrefix()
	{
		if (empty($this->prefix))
		{
			$r = null;

			if (!preg_match('/(.*)Controller/i', get_class($this), $r))
			{
			//	throw new \Exception(\CKText::_('Error : Can not get controller name'), 500);
			}

			$this->prefix = strtolower($r[1]);
		}

		return $this->prefix;
	}

	public function add() {
		return $this->edit(0);
	}

	public function edit($id = null, $appendUrl = '') {
		$editIds = $this->input->get('cid', $id, 'array');
		if (! empty($editIds)) {
			$editId = (int) $editIds[0];
		} else {
			$editId = (int) $this->input->get('id', $id, 'int');
		}

		// Redirect to the edit screen.
		KwpfofHelper::redirect(CAROUSELCK_ADMIN_URL . '&view=' . $this->getName() . '&layout=edit&id=' . $editId . $appendUrl);
	}

	public function copy() {
		$editIds = $this->input->get('cid', null, 'array');
		if (count($editIds)) {
			$id = (int) $editIds[0];
		} else {
			$id = (int) $this->input->get('id', null, 'int');
		}
		$model = $this->getModel($this->getName());

		if ($model->copy($id)) {
			KwpfofHelper::enqueueMessage('Item copied with success');
		} else {
			KwpfofHelper::enqueueMessage('Error : Item not copied', 'error');
		}

		// Redirect to the edit screen.
		KwpfofHelper::redirect(KWPANORAMA_ADMIN_URL);
	}

	public function delete() {
		$editIds = $this->input->get('cid', null, 'array');
		if (count($editIds)) {
			$id = (int) $editIds[0];
		} else {
			$id = (int) $this->input->get('id', null, 'int');
		}
		$model = $this->getModel($this->getName());
		if ($model->delete($id)) {
			KwpfofHelper::enqueueMessage('Item deleted with success');
		} else {
			KwpfofHelper::enqueueMessage('Error : Item not deleted', 'error');
		}

		// Redirect to the edit screen.
		KwpfofHelper::redirect(KWPANORAMA_ADMIN_URL);
	}
	*/
	public function getFiles() {
		// var_dump("joooooooooooooooooooooooooooooooooohn, masterbate on your goat beard, haha");
		// exit();
		// security check
	//	if (! self::checkAjaxToken()) {
		//	exit();
		//}

		$folder = $this->input->get('folder', '', 'string');
		$type = $this->input->get('type', '', 'string');
		$filetypes = KwpbrowseHelper::getFileTypes($type);
		$files = KwpbrowseHelper::getImagesInFolder(JPATH_SITE . '/' . $folder, implode('|', $filetypes));

		if (empty($files)) {
			echo Text::_('KWP_NO_IMAGE_FOUND');
		} else {
			foreach($files as $file) {
				?>
					<div class="kwpfoldertreefile" data-type="<?php echo $type ?>" onclick="kwpSelectFile(this)" data-path="<?php echo utf8_encode($folder) ?>" data-filename="<?php echo utf8_encode($file) ?>">
						<img src="<?php echo Uri::root(true) . '/' . utf8_encode($folder) . '/' . utf8_encode($file) ?>" title="<?php echo utf8_encode($file); ?>" loading="lazy">
						<div class="kwpimagetitle"><?php echo utf8_encode($file); ?></div>
					</div>
				<?php
			}
		}
		exit;
	}
/*
	public static function checkAjaxToken($json = true) {
		// check the token for security
		if (! Session::checkToken('get')) {
			$msg = "Invalid Token!";
			if ($json === false) {
				jexit($msg);
			}
			echo '{"result": "0", "message": "' . $msg . '"}';
			exit;
		}
		return true;
	}
	*/

}
