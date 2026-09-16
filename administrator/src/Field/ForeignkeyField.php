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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Exception;

/**
 * The form field implementation
 */
class ForeignkeyField extends ListField
{
    private const STATE_PUBLISHED = 1;

    /**
     * The form field type
     *
     * @var		string
     * @since	1.6
     */
    protected $type = 'foreignkey';

    /**
     * Method to get the field input markup
     *
     * @return string    The field input markup
     * @throws Exception
     * @since 1.6
     */
    protected function getInput()
    {
        $db = Factory::getDbo();

        // Define the attributes to load
        $attributesToLoad = ['table', 'key', 'value', 'sql_where', 'sql_group', 'sql_order'];

        $attributes = [];
        foreach ($attributesToLoad as $attributeKey) {
            $attributes[$attributeKey] = (string) $this->getAttribute($attributeKey);
        }

        $query = $db->getQuery(true)
            ->select($db->qn([$attributes['key'], $attributes['value']]))
            ->from($db->qn($attributes['table']));

        if ($attributes['sql_where']) {
            $query->where($attributes['sql_where']);
        } else {
            $query->where($db->qn('state') . ' = ' . self::STATE_PUBLISHED);
        }

        if ($attributes['sql_group']) {
            $query->group($attributes['sql_group']);
        } else {
            $query->group($db->qn($attributes['value']));
        }

        if ($attributes['sql_order']) {
            $query->order($attributes['sql_order']);
        } else {
            $query->order($db->qn($attributes['value']));
        }

        $db->setQuery($query);
        $rows = $db->loadAssocList();

        $options = [];
	    $options[0] = HTMLHelper::_('select.option','',Text::_('JGLOBAL_SELECT_AN_OPTION'));

        if (!empty($rows)) {
            foreach ($rows as $row) {
                // Add each select option
                $options[] = HTMLHelper::_('select.option', $row[$attributes['key']], $row[$attributes['value']]);
            }
        }

        $key = $this->value;
        if (!Factory::getApplication()->isClient('administrator')) {
            $query = $db->getQuery(true)
                ->select($db->qn($attributes['key']))
                ->from($db->qn($attributes['table']))
                ->where($db->qn('state') . ' = ' . self::STATE_PUBLISHED)
                ->where($db->qn($attributes['value']) . ' = ' . $db->q($this->value));
            $db->setQuery($query);
            $key = $db->loadResult();
        }

        return HTMLHelper::_('select.genericlist', $options, $this->name, 'class="custom-select"', 'value', 'text', $key);;
    }
}
