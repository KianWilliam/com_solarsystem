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

namespace Joomla\Component\Kwpsolarsystem\Administrator\View\Browse;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\Component\Kwpsolarsystem\Administrator\Helper\KwpbrowseHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
//use Joomla\Component\Kwpsolarsystem\Administrator\Helper\KwpframeworkHelper;

//use Kwpsolarsystem\Helper\KwpBrowse;

use Joomla\Component\Kwpsolarsystem\Administrator\Controller\Browse;

// No direct access
defined('_JEXEC') or die;

/**
 * Kwpsolarsystem list view
 */
class HtmlView extends BaseHtmlView
{
	protected $items;
	public function display($tpl = null)
	{
	   $input = Factory::getApplication()->input;
	   $user = Factory::getUser();
	   
	   	$authorised = ($user->authorise('core.edit', 'com_kwpsolarsystem') || (count($user->getAuthorisedCategories('com_kwpsolarsystem', 'core.create'))));

		if ($authorised !== true)
		{
			throw new Exception(Text::_('JERROR_ALERTNOAUTHOR'), 403);
			return false;
		}
//var_dump("haaaaaaaaaaaaaaaaaaaaaaaaaaaamid");
//exit();
		// load the items
	//	require_once JPATH_ADMINISTRATOR . '/components/com_kwpsolarsystem/src/Helper/KwpBrowse.php';
				// load the items
	//	require_once Uri::Base() . 'components/com_kwpsolarsystem/src/Helper/KwpBrowse.php';
		//var_dump(Uri::Base(). 'components/com_kwpsolarsystem/src/Helper/KwpBrowse.php');

		$this->items = KwpbrowseHelper::getItemsList();
		HTMLHelper::_('jquery.framework');
//KwpframeworkHelper::loadCss();

$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
//$wa->registerAndUseStyle('kwpframework',  Uri::Base(true).'/components/com_kwpsolarsystem/assets/css/kwpframework.css' );

//$wa->registerAndUseStyle('kwpbrowser', Uri::Base(true).'/components/com_kwpsolarsystem/assets/css/kwpbrowse.css');
$wa->registerAndUseScript('kwpbrowsejs', Uri::Base(true).'/components/com_kwpsolarsystem/assets/js/kwpbrowse.js?ver=2.1.0');

	//	var_dump($tpl);
//exit();
		parent::display($tpl);
//				parent::display('edit');

	}

}
