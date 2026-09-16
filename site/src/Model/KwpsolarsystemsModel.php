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

namespace Joomla\Component\Kwpsolarsystem\Site\Model;

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;
//use Joomla\Component\Kwpsolarsystem\Administrator\Helper\FormHelper;
use Joomla\Component\Kwpsolarsystem\Site\Helper\DatabaseHelper;
use Joomla\CMS\Form\Form;

/**
 * Kwpsolarsystem list model
 */
class KwpsolarsystemsModel extends ListModel
{
    /**
     * @param    array          $config     An optional associative array of configuration settings
     *
     * @see      JController
     * @since    1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
				'created_by', 'a.created_by',
				'state', 'a.state',
				'ordering', 'a.ordering',
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state
     *
     * Note. Calling getState in this method will result in recursion
     *
     * @param string $ordering An optional ordering field
     * @param string $direction An optional direction (asc|desc)
     *
     * @return void
     *
     * @throws Exception
     * @since   1.6
     */
    protected function populateState($ordering = null, $direction = null)
    {
        $app = Factory::getApplication();
        $input = $app->input;

        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        // Load the list state
        $this->setState('list.start', $input->get('limitstart', 0, 'uint'));
        $this->setState('list.limit', $input->get('limit', $app->get('list_limit', 20), 'uint'));

        // List state information
        parent::populateState($ordering, $direction);
    }

    /**
     * Build an SQL query to load the list data
     *
     * @return    DatabaseQuery
     * @since    1.6
     */
    protected function getListQuery()
    {
        $query = $this->_db->getQuery(true);

        $query->select('a.id, a.state, a.ordering');

        $query->from('`#__kwpsolarsystem` AS a');

        $query->select('b.name AS `created_by`');
		$query->leftJoin($this->_db->qn('#__users') . ' AS `b` ON b.id = a.created_by');

        $query->where('a.state = 1');

        // Search for this word
        $searchWord = $this->getState('filter.search');

        // Search in these columns
        $searchColumns = [
            'b.name',
        ];

        if (!empty($searchWord)) {
            if (stripos($searchWord, 'id:') === 0)
            {
                // Build the ID search
                $idPart = (int) substr($searchWord, 3);
                $query->where($this->_db->qn('a.id') . ' = ' . $this->_db->q($idPart));
            } else {
                $query = DatabaseHelper::buildSearchQuery($searchWord, $searchColumns, $query);
            }
        }

        $query->group($this->_db->qn('a.id'));

        // Add the list ordering clause
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');

        if ($orderCol && $orderDirn) {
            $query->order($this->_db->escape($orderCol . ' ' . $orderDirn));
        } else {
            $query->order('a.ordering');
        }

        return $query;
    }

    /**
     * Method to get an array of data items
     *
     * @return  mixed An array of data on success, false on failure.
     */
   /* public function getItems()
    {
        Form::addFormPath(JPATH_ADMINISTRATOR . '/components/com_kwpsolarsystem/forms');
        $form = $this->loadForm('com_kwpsolarsystem.kwpsolarsystem', 'kwpsolarsystem', [
            'control' => 'jform',
            'load_data' => true
        ]);
        $formHelper = new FormHelper($form);
        return $formHelper->appendFieldOptions(parent::getItems())->getAll();
		return parent::getItems();
    }*/
}
