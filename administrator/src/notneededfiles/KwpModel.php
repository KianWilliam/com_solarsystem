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
Namespace Kwpanorama;

defined('_JEXEC') or die;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Pagination\Pagination;
use \Kwpanorama\KWPFof;

class KWPModel {

	var $_item = null;

	private static $instance;

	protected $input;

	protected $table;

	protected $__state_set = null;

	protected $state;

	protected $pagination;

	function __construct() {
		$this->input = KWPFof::getInput();
		$this->state = new CMSObject;
	}

	static function getInstance($name, $prefix, $config) {

		if (is_object(self::$instance))
		{
			return self::$instance;
		}

		$basePath = JPATH_SITE . '/administrator/components/com_kwpanorama';
		// Check for a controller.task command.
		$input = KWPFof::getInput();

		// Define the controller filename and path.
		//$file       = strtolower($name . '.php');
		$file = $name.'.php';
		//$path       = $basePath . '/models/' . $file;
		$path       = $basePath . '/model/' . $file;


		// Get the controller class name.
		//$class = ucfirst($prefix) . 'Model' . ucfirst($name);
		$class = ucfirst($name)  . 'Model' ;


		// Include the class if not present.
		if (!class_exists($class))
		{
			// If the controller file path exists, include it.
			if (file_exists($path))
			{
				require_once $path;
			}
			else
			{
        		throw new \InvalidArgumentException(\Joomla\CMS\Language\Text::sprintf('ERROR_INVALID_MODEL', $type, $format));
			
				return false;
			}
		}

		// Instantiate the class.
	    if (!class_exists($class))
		{
			throw new \InvalidArgumentException(\Joomla\CMS\Language\Text::sprintf('ERROR_INVALID_MODEL_CLASS', $class));
		} 

		// Instantiate the class, store it to the static container, and return it
		return self::$instance = new $class();
	}

	public function save($data) {

	}

	public function delete($id) {
		return KWPFof::dbDelete( $this->table, (int)$id );
	}

	public function setState($property, $value = null)
	{
		return $this->state->set($property, $value);
	}

	public function getState($property = null, $default = null)
	{
		if (!$this->__state_set)
		{
			// Protected method to auto-populate the model state.
			$this->populateState();

			// Set the model state set flag to true.
			$this->__state_set = true;
		}

		return $property === null ? $this->state : $this->state->get($property, $default);
	}

	protected function populateState()
	{
		$this->state->set('filter_order', $this->input->get('filter_order', 'a.id'));
		$this->state->set('filter_order_Dir', $this->input->get('filter_order_Dir', 'asc'));
		$this->state->set('filter_search', $this->input->get('filter_search', ''));
		$this->state->set('limitstart', $this->input->get('limitstart', 0));
		$this->state->set('limit_total', $this->input->get('limittotal', 0));
		$this->state->set('limit', $this->input->get('limit', 20));
	}

	public function getPagination($total = null, $start = null, $limit = null)
	{
		if (!$this->pagination)
		{
			$total = $this->state->get('limit_total', $total);
			$total = $this->getTotal();
			$start = $this->state->get('limitstart', $start);
			$limit = $this->state->get('limit', $limit);

			$this->pagination = new Pagination($total, $start, $limit);
		}

		return $this->pagination;
	}

	public function getTotal($query) {
		$db = KWPFof::getDbo();
		$query = clone $query;
		$query->clear('select')->clear('order')->clear('limit')->clear('offset')->select('COUNT(*)');
		$db->setQuery($query);

		return (int) $db->loadResult();
	}

	public function copy($id) {
		$row = KWPFof::dbLoad($this->table, (int)$id);
		$row->id = 0;
		$row->name = $row->name . ' - copy';

		$newid = KWPFof::dbStore($this->table, $row);

		return $newid;
	}
}