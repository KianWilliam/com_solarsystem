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
 namespace Joomla\Component\Kwpsolarsystem\Administrator\Controller;

// No direct access
defined('KWP_LOADED') or die;
/*
use \Carouselck\CKController;
use \Carouselck\CKFof;
use \Carouselck\CKText;
*/
use Joomla\CMS\MVC\Controller\BaseController;

//use Joomla\Component\Kwpanorama\Administrator\Helper\KwpfofHelper;

//class CarouselckControllerAjax extends CKController {
class AjaxController extends BaseController {


	function __construct() {
		// security check
	//	if (! KwpfofHelper::checkAjaxToken()) exit;
		
		//parent::__construct();
		
		/*$plugin = $this->input->get('plugin', '', 'cmd');
		$task = $this->input->get('task', '', 'cmd');

		if ($plugin) {
			if (file_exists(CAROUSELCK_PLUGINS_PATH . '/' . $plugin . '/helper/helper_' . $plugin . '.php')) {
				require_once(CAROUSELCK_PLUGINS_PATH . '/' . $plugin . '/helper/helper_' . $plugin . '.php');
				$className = 'CarouselckHelpersource' . ucfirst($plugin);
				//CarouselckHelpersourceArticles
				$class = new $className();
				if (method_exists($class, $task)) {
					$class::$task();
					exit;
				}
			}
		}*/
		//die;
	}
	
}
