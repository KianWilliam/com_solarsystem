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

use Joomla\CMS\MVC\Model\FormModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
//use Joomla\Component\Kwpsolarsystem\Administrator\Helper\FormHelper;
use Joomla\Component\Kwpsolarsystem\Site\Helper\DatetimeHelper;

/**
 * Kwpsolarsystem detail model
 */
class KwpsolarsystemModel extends FormModel
{
	/**
	 * The item to hold data
	 *
	 * @return object
	 */
    protected $_item;

    /**
     * @return void
     * @throws \Exception
     */
    private function fetchItem()
    {
	//	var_dump("eh entre tes poitrine, haha");
	//	exit();
        $db = $this->getDbo();
        $query = $db->getQuery(true);

     //   $query->select('a.id, a.state, a.ordering');
		        $query->select('a.*');


        $query->from('#__kwpsolarsystem as a');

       $query->select('b.name AS `created_by`');
		$query->leftJoin($this->_db->qn('#__users') . ' AS `b` ON b.id = a.created_by');

        $query->where($db->qn('a.id') . ' = ' . $db->q($this->getId()));
        $db->setQuery($query);

        try {
            $db->execute();
        } catch (\RuntimeException $e) {
            throw new \Exception($e->getMessage(), 500);
        }

        $this->_item = $db->loadObject();
		return $this->_item;
    }

    /**
     * @return int
     * @throws \Exception
     */
    private function getId(): int
    {
        $app = Factory::getApplication();

        $id = $app->input->getInt('id');
        $params = $app->getParams();

        $paramId = $params->get('id');
        if ($paramId && $id === null) {
            return (int)$paramId;
        }

        return (int)$id;
    }

    /**
     * Get the data
     *
     * @param null $pk
     *
     * @return  object
     *
     * @throws \Exception
     * @since   1.6
     */
	public function getItem($pk = null)
	{
		//var_dump("ugly fat ass");
		//exit();
		if (isset($this->_item)) {
			return $this->_item;
		}

      return  $this->fetchItem();

   /*     Form::addFormPath(JPATH_ADMINISTRATOR . '/components/com_kwpsolarsystem/forms');
        $form = $this->loadForm('com_kwpsolarsystem.kwpsolarsystem', 'kwpsolarsystem', [
            'control' => 'jform',
            'load_data' => true
        ]);
        $formHelper = new FormHelper($form);
        return $formHelper->appendFieldOptions([$this->_item])->getOne();*/
	}

    /**
     * Method to get the form.
     *
     * The base form is loaded from XML
     *
     * @param	array	$data		An optional array of data for the form to interogate.
     * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
     * @return	Form	A JForm object on success, false on failure
     * @throws \Exception
     * @since	1.6
     */
    public function getForm($data = [], $loadData = true)
    {
        Form::addFormPath(JPATH_ADMINISTRATOR . '/components/com_kwpsolarsystem/forms');

        $app = Factory::getApplication();
        $id = $app->input->getInt('id');
        $params = $app->getParams();
        $paramId = $params->get('id');
        if ($paramId && !$id) {
            $id = $paramId;
        }
        if (empty($id)) {
            $loadData = false;
        }

        // Get the form
        $form = $this->loadForm('com_kwpsolarsystem.kwpsolarsystem', 'kwpsolarsystem', ['control' => 'jform', 'load_data' => $loadData]);
        if (empty($form)) {
            return false;
        }

        return $form;
    }
}
