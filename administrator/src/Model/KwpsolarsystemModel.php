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

namespace Joomla\Component\Kwpsolarsystem\Administrator\Model;

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Factory;
use Joomla\CMS\UCM\UCMType;
use Joomla\Component\Kwpsolarsystem\Administrator\Helper\KwpsolarsystemHelper;
use Joomla\Registry\Registry;
use Joomla\CMS\Table\Table;
//use Joomla\Component\Kwpsolarsystem\Administrator\Table\Kwpsolarsystem;



/**
 * Kwpsolarsystem model
 */
class KwpsolarsystemModel extends AdminModel
{
	/**
	 * @var		string	The prefix to use with controller messages
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_KWPSOLARSYSTEM';
	// I added myself
	    public $typeAlias = 'com_kwpsolarsystem.kwpsolarsystem';
		    protected $formName = 'kwpsolarsystem';



	/**
	 * Method to get the record form.
	 *
	 * @param    array $data An optional array of data for the form to interogate
	 * @param bool $loadData
	 *
	 * @return bool A JForm object on success, false on failure
     * @throws \Exception
	 * @since    1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
	//	var_dump("quuuuuuuuuuuuuuuny, au ... haha");
		//        Form::addFieldPath(JPATH_ADMINISTRATOR . 'components/com_scheduler/src/Field');

		
		// Get the form
		$form = $this->loadForm('com_kwpsolarsystem.'.$this->formName, 'kwpsolarsystem', array('control' => 'jform', 'load_data' => $loadData));
	//	var_dump("stable between your ugly legs, haha");
		//exit();
		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form
	 *
	 * @return	mixed	The data for the form
     * @throws  \Exception
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		//var_dump("cow, pig, mule, donkey out of the stable between your legs, haha");
		
		// Check the session for previously entered form data
		$data = Factory::getApplication()->getUserState('com_kwpsolarsystem.edit.kwpsolarsystem.data', array());
      //  var_dump("reeedam between your legs, haha");
		//var_dump($data);
		
		if (empty($data))
		{
			$data = $this->getItem();
			//var_dump($data);
			//exit();
		}

        return $data;
	}
	/*
	 protected function populateState()
    {
        $table = $this->getTable();
        $key   = $table->getKeyName();
		var_dump($table);
		var_dump($key);
		var_dump("you anal, haha, au pouvoir on a des anal. haha");
		exit();

        // Get the pk of the record from the request.
        $pk = Factory::getApplication()->getInput()->getInt($key);
		
        $this->setState($this->getName() . '.id', $pk);
	
	}*/


    public function getItem($pk = null){
		//var_dump("boolup, your favorite drink, je bayad, haha.");
		//exit();
		$item = parent::getItem($pk);
	//	var_dump($item);
		//exit();
		
		if(property_exists($item, "visual") && is_array($item->visual) == false){
			$registry = new Registry();
			$registry->loadString($item->visual, 'JSON');
			$item->visual= $registry->toArray();						
		}
	//	var_dump($item);
		//exit();
		
		return($item);
	}

	/**
	 * Prepare and sanitise the table prior to saving
	 *
	 * @since	1.6
	 */
	protected function prepareTable($table)
	{
	//	jimport('joomla.filter.output');

		if (empty($table->id))
		{
			// Set ordering to the last item if not set
			if (@$table->ordering === '') {
				$db = Factory::getDbo();
                $query = $db->getQuery(true)
                    ->select('MAX(ordering)')
                    ->from($db->qn('#__kwpsolarsystem'));
				$db->setQuery($query);
				$max = $db->loadResult();
				$table->ordering = $max+1;
			}
		}
	}

	/**
	 * Method to initialize member variables used by batch methods and other methods like saveorder()
	 *
	 * @return  void
	 *
     * @throws \Exception
	 * @since   3.8.2
	 */
	 
	 /*
	public function initBatch()
	{
		if ($this->batchSet === null)
		{
			$this->batchSet = true;

			// Get current user
			$this->user = Factory::getUser();

			// Get table
			$this->table = $this->getTable();

			// Get table class name
			$tc = explode('\\', \get_class($this->table));
			$this->tableClassName = end($tc);

			if ($this->typeAlias === null) {
				$this->typeAlias = '';
			}

			// Get UCM Type data
			$this->contentType = new UCMType;
			$this->type = $this->contentType->getTypeByTable($this->tableClassName)
				?: $this->contentType->getTypeByAlias($this->typeAlias);
		}
	}
	*/

    /**
     * @param $data
     * @return bool
     * @throws \Exception
     */
	 
    public function save($data)
    {
       /*foreach ($this->getForm()->getFieldset() as $field) {
            if ($field->type === 'Calendar') {
                if ($data[$field->fieldname] === '') {
                    $data[$field->fieldname] = null;
                } else if ($field->getAttribute('format') !== '%Y-%m-%d') {
                    $data[$field->fieldname] = \DateTime::createFromFormat(
                        KwpsolarsystemHelper::convertStrftimeToDateTimeFormat($field->getAttribute('format')), $data[$field->fieldname]
                    )->format('Y-m-d');
                }
            }
            if ($field->type === 'Tag' && isset($data[$field->fieldname]) && is_array($data[$field->fieldname])) {
                $data[$field->fieldname] = implode(',', $data[$field->fieldname]);
            }
        }*/
        return parent::save($data);
    }
}
