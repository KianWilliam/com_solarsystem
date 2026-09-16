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

namespace Joomla\Component\Kwpsolarsystem\Administrator\Field;

defined('_JEXEC') or die;

use Joomla\CMS\Form\Field\ListField;
use Joomla\CMS\Factory;

/**
 * The form field implementation
 */
class CreatedbyField extends ListField
{
	/**
	 * The form field type
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'createdby';

	/**
	 * Method to get the field input markup
	 *
	 * @return	string	The field input markup
	 * @since	1.6
	 */
	protected function getInput()
	{
		$user = Factory::getUser();

		$userExists = true;

		if ($this->value) {
			$db = Factory::getDbo();
			$query = $db->getQuery(true)
				->select('id')
				->from('#__users')
				->where($db->qn('id') . ' = ' . $db->q($this->value));
			$db->setQuery($query);
			$userId = $db->loadResult();
			if ($userId) {
				$user = Factory::getUser($this->value);
			} else {
				$userExists = false;
				$this->value = $user->id;
			}
		} else {
			$this->value = $user->id;
		}

        $html = '';
		if ($userExists) {
			$html = $user->name . " (" . $user->username . ")";
		}

		$html .= '<input type="hidden" name="' . $this->name . '" value="' . $this->value . '" />';

		return $html;
	}
}
