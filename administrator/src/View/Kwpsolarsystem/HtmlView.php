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

namespace Joomla\Component\Kwpsolarsystem\Administrator\View\Kwpsolarsystem;

// No direct access
defined('_JEXEC') or die;

//use Exception;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;
use Joomla\Component\Kwpsolarsystem\Administrator\Helper\KwpsolarsystemHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Component\ComponentHelper;


/**
 * Kwpsolarsystem detail view
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * The Form object
	 *
	 * @var    Form
	 * @since  1.5
	 */
	protected $form;

	/**
	 * The active item
	 *
	 * @var    object
	 * @since  1.5
	 */
	protected $item;

	/**
	 * The model state
	 *
	 * @var    object
	 * @since  1.5
	 */
	protected $state;

	/**
	 * Display the view
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
	/*	$model       = $this->getModel();
		$this->form  = $model->getForm();
		$this->item  = $model->getItem();
		$this->state = $model->getState();*/
		
		
			$this->form  = $this->get("Form");
		$this->item  = $this->get("Item");
		$this->state = $this->get("State");
		
	//$params = ComponentHelper::getParams('com_kwpsolarsystem');
//var_dump($params);
//exit();
		if (count($errors = $this->get('Errors')))
		{
            throw new Exception(implode("\n", $errors));
		}

        $document = Factory::getDocument();
		$wa = $document->getWebAssetManager();
		
//$wa->registerAndUseStyle('kwpframework','components/com_kwpsolarsystem/assets/css/kwpframework.css' );
//$wa->registerAndUseStyle('kwpbrowse', 'components/com_kwpsolarsystem/assets/css/kwpbrowse.css');
$wa->registerAndUseStyle('mystyle', 'components/com_kwpsolarsystem/assets/css/kwpsolarsystem.css');
		//$wa->registerAndUseScript('my-script', 'components/com_kwpsolarsystem/assets/js/detail.js');
		$this->addToolbar();

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar()
	{
		Factory::getApplication()->input->set('hidemainmenu', true);

		$user		= Factory::getUser();
		$isNew		= ($this->item->id == 0);

        if (isset($this->item->checked_out))
		{
		    $checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
        }
		else
		{
            $checkedOut = false;
        }

		$canDo = KwpsolarsystemHelper::getActions();

		$title = Text::_('SolarSystem');
		$icon = 'fa fa-file-alt';

		$layout = new FileLayout('joomla.toolbar.title');
		$html = $layout->render([
			'title' => $title,
			'icon' => $icon
		]);

		$app = Factory::getApplication();
		$app->JComponentTitle = str_replace('icon-', '', $html);
		$title = strip_tags($title) . ' - ' . $app->get('sitename') . ' - ' . Text::_('JADMINISTRATION');
		Factory::getDocument()->setTitle($title);

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo['core.edit'] || ($canDo['core.create'])))
		{
			ToolbarHelper::apply('kwpsolarsystem.apply', 'JTOOLBAR_APPLY');
			ToolbarHelper::save('kwpsolarsystem.save', 'JTOOLBAR_SAVE');
		}
/*
		if (!$checkedOut && ($canDo['core.create']))
		{
			ToolbarHelper::custom('kwpsolarsystem.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo['core.create'])
		{
			ToolbarHelper::custom('kwpsolarsystem.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
		}
*/
		if (empty($this->item->id))
		{
			ToolbarHelper::cancel('kwpsolarsystem.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			ToolbarHelper::cancel('kwpsolarsystem.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
