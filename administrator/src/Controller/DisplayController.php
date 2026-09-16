<?php 
/*
  * @package component kwpsolarsystem for Joomla! 5.x 6.x
 * @version $Id: kwpsolarsystem 1.0.0 2026-05-05 01:10:10Z $
 * @author KWProductions Co.
 * @copyright (C) 2022- KWProductions Co.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 
 This file is part of kwpsolarsystem.
    kwpsolarsystem is free software: you can redistribute it and/or adify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    kwpsolarsystem is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for are details.
    You should have received a copy of the GNU General Public License
    along with kwpsolarsystem.  If not, see <http://www.gnu.org/licenses/>.
 
*/

?>
<?php
/**
 * @package     com_kwpsolarsystem
 * @version     1.0.0
 * @copyright   Copyright (C) 2025. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      KWProductions Co. <webarchitect@kwproductions121.ir> - https://componentgenerator.com
 */

namespace Joomla\Component\Kwpsolarsystem\Administrator\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Router\Route;
use Joomla\Component\Kwpsolarsystem\Administrator\Helper\KwpbrowseHelper;
use Joomla\Component\Kwpsolarsystem\Administrator\Helper\KwpfofHelper;




/**
 * Base controller class
 *
 * @since  2.5
 */
class DisplayController extends BaseController
{
	/**
	 * The default view.
	 *
	 * @var    string
	 * @since  2.5
	 */
	protected $default_view = 'kwpsolarsystems';
	//	protected $default_view = 'browse';


    /**
     * Method to display a view.
     *
     * @param boolean $cachable If true, the view output will be cached
     * @param array $urlparams An array of safe URL parameters and their variable types, for valid values see {@link \JFilterInput::clean()}.
     *
     * @return bool|\JControllerLegacy|BaseController A Controller object to support chaining.
     *
     * @throws \Exception
     * @since    2.5
     */
	public function display($cachable = false, $urlparams = array())
	{
		$view   = $this->input->get('view', $this->default_view);
		$layout = $this->input->get('layout', 'default');
		$id     = $this->input->getInt('id');
	//	var_dump($view);
		//exit();
		
		// Check for edit form.
		if ((string)$view === 'kwpsolarsystem' && (string)$layout === 'edit' && !$this->checkEditId('com_kwpsolarsystem.edit.kwpsolarsystem', $id))
		{
			// Somehow the person just went to the form - we don't allow that.
			$this->setMessage(Text::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id), 'error');
			$this->setRedirect(Route::_('index.php?option=com_kwpsolarsystem&view=kwpsolarsystems', false));

			return false;
		}

		return parent::display();
	}
	
	// backend extension worked perfect without below functions. 
	
	public function ajaxAddPicture() {
		//require_once CAROUSELCK_PATH . '/helpers/ckbrowse.php';
		KwpbrowseHelper::ajaxAddPicture();
	}
		
	public function ajaxCreateFolder() {
	
		// security check
	if (! KwpfofHelper::checkAjaxToken()) {
			exit();
		}
		
		//	var_dump("Apres");
		//exit();

		if (KwpfofHelper::userCan('create', 'com_media')) {
			$input = KwpfofHelper::getInput();
			$path = $input->get('path', '', 'string');
			$name = $input->get('name', '', 'string');

			//require_once CAROUSELCK_PATH . '/helpers/ckbrowse.php';
			if ($result = KwpbrowseHelper::createFolder($path, $name)) {
				$msg = Text::_('KWP_FOLDER_CREATED_SUCCESS');
			} else {
				$msg = Text::_('KWP_FOLDER_CREATED_ERROR');
			}

			echo '{"status" : "' . ($result == false ? '0' : '1') . '", "message" : "' . $msg . '"}';
		} else {
			echo '{"status" : "2", "message" : "' . Text::_('KWP_ERROR_USER_NO_AUTH') . '"}';
		}
		//exit;
	}
	
}
