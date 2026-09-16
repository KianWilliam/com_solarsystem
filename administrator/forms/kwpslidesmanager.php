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

defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

//require_once JPATH_ADMINISTRATOR . '/components/com_kwpsolarsystem/src/helper/KwpFramework.php';
require_once JPATH_ADMINISTRATOR . '/components/com_kwpsolarsystem/forms/helper.php';

//Carouselck\CKFramework::load();
//KwpFramework::load();
KWPSolarsystemHelper::loadKwpbox();
/*
\Joomla\CMS\Language\Text::script('CAROUSELCK_ADDSLIDE');
\Joomla\CMS\Language\Text::script('CAROUSELCK_SELECTIMAGE');
\Joomla\CMS\Language\Text::script('CAROUSELCK_SELECT_LINK');
\Joomla\CMS\Language\Text::script('CAROUSELCK_REMOVE2');
\Joomla\CMS\Language\Text::script('CAROUSELCK_SELECT');
\Joomla\CMS\Language\Text::script('CAROUSELCK_CAPTION');
\Joomla\CMS\Language\Text::script('CAROUSELCK_USETOSHOW');
\Joomla\CMS\Language\Text::script('CAROUSELCK_IMAGE');
\Joomla\CMS\Language\Text::script('CAROUSELCK_VIDEO');
\Joomla\CMS\Language\Text::script('CAROUSELCK_TEXTOPTIONS');
\Joomla\CMS\Language\Text::script('CAROUSELCK_IMAGEOPTIONS');
\Joomla\CMS\Language\Text::script('CAROUSELCK_LINKOPTIONS');
\Joomla\CMS\Language\Text::script('CAROUSELCK_VIDEOOPTIONS');
\Joomla\CMS\Language\Text::script('CAROUSELCK_ALIGNEMENT_LABEL');
\Joomla\CMS\Language\Text::script('CAROUSELCK_TOPLEFT');
\Joomla\CMS\Language\Text::script('CAROUSELCK_TOPCENTER');
\Joomla\CMS\Language\Text::script('CAROUSELCK_TOPRIGHT');
\Joomla\CMS\Language\Text::script('CAROUSELCK_MIDDLELEFT');
\Joomla\CMS\Language\Text::script('CAROUSELCK_CENTER');
\Joomla\CMS\Language\Text::script('CAROUSELCK_MIDDLERIGHT');
\Joomla\CMS\Language\Text::script('CAROUSELCK_BOTTOMLEFT');
\Joomla\CMS\Language\Text::script('CAROUSELCK_BOTTOMCENTER');
\Joomla\CMS\Language\Text::script('CAROUSELCK_BOTTOMRIGHT');
\Joomla\CMS\Language\Text::script('CAROUSELCK_LINK');
\Joomla\CMS\Language\Text::script('CAROUSELCK_TARGET');
\Joomla\CMS\Language\Text::script('CAROUSELCK_SAMEWINDOW');
\Joomla\CMS\Language\Text::script('CAROUSELCK_NEWWINDOW');
\Joomla\CMS\Language\Text::script('CAROUSELCK_VIDEOURL');
\Joomla\CMS\Language\Text::script('CAROUSELCK_REMOVE');
\Joomla\CMS\Language\Text::script('CAROUSELCK_IMPORTFROMFOLDER');
\Joomla\CMS\Language\Text::script('CAROUSELCK_ARTICLEOPTIONS');
\Joomla\CMS\Language\Text::script('CAROUSELCK_SLIDETIME');
\Joomla\CMS\Language\Text::script('CAROUSELCK_CLEAR');
\Joomla\CMS\Language\Text::script('CAROUSELCK_SELECT');
\Joomla\CMS\Language\Text::script('CAROUSELCK_TITLE');
\Joomla\CMS\Language\Text::script('CAROUSELCK_STARTDATE');
\Joomla\CMS\Language\Text::script('CAROUSELCK_ENDDATE');
\Joomla\CMS\Language\Text::script('CAROUSELCK_SAVE');
\Joomla\CMS\Language\Text::script('CAROUSELCK_TEXT_CUSTOM');
\Joomla\CMS\Language\Text::script('CAROUSELCK_ARTICLE');
\Joomla\CMS\Language\Text::script('CAROUSELCK_TEXT');
*/


class JFormFieldKwpslidesmanager extends FormField {

	protected $type = 'kwpslidesmanager';

	protected function getInput() {

		// loads the language files from the frontend
		$lang	= Factory::getLanguage();
		$lang->load('com_kwpsolarsystem', JPATH_SITE . '/components/com_kwpsolarsystem', $lang->getTag(), false);
		$lang->load('com_kwpsolarsystem', JPATH_SITE, $lang->getTag(), false);
		$path = Uri::Base();
		$p = explode("administrator", $path);
		$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
		$rootvars="
		var KWPuri;
		var KWPSOLARSYSTEMTOKEN;
		var URIBASE;
		var BASEURL;
		var SITEROOT;
		KWPuri = '".Uri::Base()."';
			KWPSOLARSYSTEMTOKEN = '".Factory::getSession()->getFormToken()."=1';
		    URIBASE = '".Uri::base()."';
		    BASEURL = '".Uri::base()."index.php?option=com_kwpsolarsystem';
		    URIROOT = '".Uri::root()."';
		    SITEROOT = '".$p[0]."';
		";

		$wa->addInlineScript($rootvars);

	//	require_once(JPATH_ROOT . '/administrator/components/com_carouselck/helpers/defines.js.php');
		$path = Uri::Base().'components/com_kwpsolarsystem/assets/js/';
				$csspath = Uri::Base().'components/com_kwpsolarsystem/assets/css/';

		HTMLHelper::_('jquery.framework');
		 //HTMLHelper::_('jquery.ui', array('core', 'sortable'));
		HTMLHelper::_('script', $path.'jquery-uikwp-custom.js');
		HTMLHelper::_('script', $path.'admin.js');
		HTMLHelper::_('script', $path . 'kwpslidesmanager.js');
	/*	if (\Carouselck\CKFof::isSite()) {
			\Joomla\CMS\HTML\HTMLHelper::_('stylesheet', 'media/com_carouselck/assets/front-edition.css');
		}*/
		
	//	HTMLHelper::_('stylesheet', $csspath.'jquery-ui.min.css');
		HTMLHelper::_('stylesheet', $csspath . 'kwpslidesmanager.css');

		$html = '<input name="' . $this->name . '" id="kwpslides" type="hidden" value="' . $this->value . '" />'
				. '<div class="kwpaddslide kwpbutton kwpbutton-success" onclick="javascript:kwpAddSlide();"><i class="far fa-plus-square"></i> ' . Text::_('ADDSLIDE') . '</div>'
				. '<ul id="kwpslideslist" class="kwpinterface" style="clear:both;"></ul>'
				. '<div class="kwpaddslide kwpbutton kwpbutton-success" onclick="javascript:kwpAddSlide();"><i class="far fa-plus-square"></i> ' . Text::_('ADDSLIDE') . '</div>';

		return $html;
	}

	protected function getLabel() {

		return '';
	}

//	protected function getArticlesList() {
//		$db = & \Joomla\CMS\Factory::getDBO();
//
//		$query = "SELECT id, title FROM #__content WHERE state = 1 LIMIT 2;";
//		$db->setQuery($query);
//		$row = $db->loadObjectList('id');
//		var_dump($row);
//		return json_encode($row);
//	}

}

