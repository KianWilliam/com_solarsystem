<?php 
/*
  * @package component kwpanorama for Joomla! 5.x 6.x
 * @version $Id: kwpsolarsystem 1.0.0 2025-01-01 01:10:10Z $
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
 * @package     com_kwpanorama
 * @version     1.0.0
 * @copyright   Copyright (C) 2025. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      KWProductions Co. <webarchitect@kwproductions121.ir> - https://componentgenerator.com
 */

namespace Joomla\Component\Kwpanorama\Administrator\Helper;

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

class FormHelper
{
    protected $form;
    protected $items = [];
    protected $fieldOptionKeys = [];

    /**
     * @param $form
     */
    public function __construct($form)
    {
        $this->form = $form;
    }

    /**
     * Get the field options from the form fields
     *
     * @return  array   $fieldOptions   An array with the field options
     */
    public function getFieldOptions()
    {
		//var_dump($this->form->getXml()->fieldset->children());
        $fieldOptions = [];
        foreach ($this->form->getXml()->fieldset->children() as $field) {
            $fieldColumn = (string)$field['name'];
            foreach ($field->children() as $option) {
                $key = (string) $option['value'];
                $value = (string) $option;
                if (!in_array($key, $this->fieldOptionKeys, true)) {
                    $this->fieldOptionKeys[] = $key;
                }
                $fieldOptions[$fieldColumn][$key] = $value;
            }
        }

        return $fieldOptions;
    }

    /**
     * Append options from the form to the items
     *
     * @param $items
     *
     * @return self
     */
    public function appendFieldOptions($items)
    {
        $this->items = $items;
        $fieldOptions = $this->getFieldOptions();
        foreach ($this->items as $i => $item) {
            if (empty($item)) {
                continue;
            }
            foreach ($item as $key => $value) {
                if ((string)$key === 'state') {
                    continue;
                }
                if (!in_array($item->{$key}, $this->fieldOptionKeys, true)) {
                    continue;
                }
                // If this field has options
                if (!isset($fieldOptions[$key][$value])) {
                    continue;
                }
                // Update the item key with the field option
                $item->{$key} = Text::_($fieldOptions[$key][$value]);
            }

            $this->items[$i] = $item;
        }

        return $this;
    }

    /**
     * Get one item
     *
     * @return null
     */
    public function getOne()
    {
        return $this->items[0] ?? null;
    }

    /**
     * Get all the items
     *
     * @return mixed
     */
    public function getAll()
    {
        return $this->items;
    }
}
