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

namespace Joomla\Component\Kwpsolarsystem\Administrator\Helper;

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Database\Mysqli\MysqliQuery;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;



/**
 * Kwpsolarsystem helper class
 */
class KwpsolarsystemHelper
{
	/**
	 * Add the submenus
	 *
	 * @param string $name
	 */
	public static function addSubmenu($name = '')
	{
		\JHtmlSidebar::addEntry(
			Text::_('COM_KWPSOLARSYSTEM_TITLE_KWPSOLARSYSTEMS'),
			'index.php?option=com_kwpsolarsystem&view=kwpsolarsystems',
			$name === 'kwpsolarsystems'
		);
	}

	/**
	 * Gets a list of the actions that can be performed
	 *
	 * @return array
	 * @since    1.6
	 */
	public static function getActions() : array
	{
		$user	= Factory::getUser();
		$result	= [];

		$assetName = 'com_kwpsolarsystem';

		$actions = [
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.edit.own', 'core.delete'
		];

		foreach ($actions as $action)
		{
			$result[$action] = $user->authorise($action, $assetName);
		}

		return $result;
	}

	/**
	 * Build the search query from the columns
	 *
	 * @param	string		        $searchPhrase	    Search for this phrase
	 * @param	array		        $searchColumns	    The columns in the DB to look up
	 * @param   MysqliQuery         $query              The query
	 *
	 * @return	MysqliQuery		    $query			    The query (search filters applied)
	 */
	public static function buildSearchQuery(string $searchPhrase, array $searchColumns, MysqliQuery $query) : MysqliQuery
	{
		$db = Factory::getDbo();

		$where = [];

		foreach ($searchColumns as $i => $searchColumn)
		{
			$where[] = $db->qn($searchColumn) . ' LIKE ' . $db->q('%' . $db->escape($searchPhrase, true) . '%');
		}

		if (!empty($where))
		{
			$query->where('(' . implode(' OR ', $where) . ')');
		}

		return $query;
	}

    /**
     * @param string $format
     * @return string
     */
    public static function convertStrftimeToDateTimeFormat(string $format): string
    {
        $replacements = [
            '%a' => 'D', '%A' => 'l', '%d' => 'd', '%e' => 'j', '%j' => 'z',
            '%u' => 'N', '%w' => 'w', '%U' => 'W', '%V' => 'W', '%W' => 'W',
            '%b' => 'M', '%B' => 'F', '%m' => 'm', '%C' => 'y', '%g' => 'y',
            '%G' => 'o', '%y' => 'y', '%Y' => 'Y', '%H' => 'H', '%I' => 'h',
            '%l' => 'g', '%M' => 'i', '%p' => 'A', '%P' => 'a', '%r' => 'h:i:s A',
            '%R' => 'H:i', '%S' => 's', '%T' => 'H:i:s', '%X' => 'H:i:s', '%z' => 'O',
            '%Z' => 'T', '%%' => '%'
        ];

        return strtr($format, $replacements);
    }

    /**
     * @param string $value
     * @param string $strftimeFormat
     * @return string
     */
    public static function convertFromStrftimeFormat(string $value, string $strftimeFormat): string
    {
        $datetime = \DateTime::createFromFormat('Y-m-d', $value);
        if (!$datetime) {
            return '';
        }
        return $datetime->format(self::convertStrftimeToDateTimeFormat($strftimeFormat));
    }
	public static function loadKwpbox() {
		$doc = Factory::getDocument();
		$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
		HTMLHelper::_('jquery.framework', true);
//		$doc->addScript(\Joomla\CMS\Uri\Uri::root(true) . '/media/jui/js/jquery.min.js');
	//	$doc->addStyleSheet(Uri::Base() . 'components/com_kwpsolarsystem/assets/panobox.css');
		    $wa->registerAndUseStyle('panoboxcss', Uri::Base() . 'components/com_kwpsolarsystem/assets/css/panobox.css');

	//	$doc->addScript(Uri::Base() . 'componoents/com_kwpsolarsystem/assets/panobox.js');
		    $wa->registerAndUseScript('panoboxjs', Uri::Base() . 'components/com_kwpsolarsystem/assets/js/panobox.js');

	}
	static function hex2RGB($hexStr, $opacity) {
		$hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
		$rgbArray = array();
		if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
			$colorVal = hexdec($hexStr);
			$rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
			$rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
			$rgbArray['blue'] = 0xFF & $colorVal;
		} elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
			$rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
			$rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
			$rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
		} else {
			return false; //Invalid hex color code
		}
		$rgbacolor = "rgba(" . $rgbArray['red'] . "," . $rgbArray['green'] . "," . $rgbArray['blue'] . "," . ($opacity / 100) . ")";

		return $rgbacolor;
	}
   public static function getProMessage() {
		$html = '<div class="kwpinfo"><i class="fas fa-info"></i><a href="https://www.kwproductions121.ir/components/kwpsolarsystem.html" target="_blank">' . \Joomla\CMS\Language\Text::_('KWProductions Co.  Component Panorama') . '</a></div>';
	
		return $html;
}	
}
