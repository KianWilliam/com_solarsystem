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

namespace Joomla\Component\Kwpsolarsystem\Site\Helper;

defined('_JEXEC') or die;

/**
 * Kwpsolarsystem datetime helper
 */
class DatetimeHelper
{
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
}
