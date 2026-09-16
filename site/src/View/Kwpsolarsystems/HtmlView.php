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

namespace Joomla\Component\Kwpsolarsystem\Site\View\Kwpsolarsystems;

// No direct access
defined('_JEXEC') or die;

use Exception;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Pagination\Pagination;

/**
 * Kwpsolarsystem list view
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * An array of items
	 *
	 * @var    array
	 * @since  1.6
	 */
	protected $items = [];

    /**
     * The access helper
     *
     * @var    AccessHelper
     */
    protected $access;

    /**
     * The authorization status
     *
     * @var    array
     */
    protected $authorised;

	/**
	 * The pagination object
	 *
	 * @var    Pagination
	 * @since  1.6
	 */
	protected $pagination;

	/**
	 * The model state
	 *
	 * @var    object
	 * @since  1.6
	 */
	protected $state;

	/**
	 * The component params
	 */
	protected $params;

	/**
	 * The ID of the item
	 */
    protected $item_id;

	/**
	 * @param null $tpl
	 *
	 * @throws \Exception
	 */
	public function display($tpl = null)
	{
        $app = Factory::getApplication();
        $user = Factory::getUser();

        $this->params = $app->getParams('com_kwpsolarsystem');
        $this->item_id = $app->input->getInt('Itemid');
        
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');

        $this->authorised = [
            'create' => $user->authorise('core.create', 'com_kwpsolarsystem'),
            'edit' => $user->authorise('core.edit', 'com_kwpsolarsystem')
        ];

        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        $this->setupDocument();

        parent::display($tpl);
	}

    /**
     * @return  void
     * @throws \Exception
     */
    protected function setupDocument()
    {
        $document = Factory::getDocument();
        if ($document === null) {
            return;
        }
	    $wa = $document->getWebAssetManager();
	    $wa->registerAndUseStyle('my-style', 'components/com_kwpsolarsystem/assets/css/kwpsolarsystem.css');
	    $wa->registerAndUseScript('my-script', 'components/com_kwpsolarsystem/assets/js/list.js');

        $app = Factory::getApplication();
        if ($app === null) {
            return;
        }
        $menus = $app->getMenu();
        if ($menus === null) {
            return;
        }

        $menu = $menus->getActive();
        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', Text::_('JGLOBAL_ARTICLES'));
        }

        $title = $this->params->get('page_title', '');

        if (empty($title)) {
            $title = $app->get('sitename');
        } elseif ((int)$app->get('sitename_pagetitles', 0) === 1) {
            $title = Text::sprintf('JPAGETITLE', $app->get('sitename'), $title);
        } elseif ((int)$app->get('sitename_pagetitles', 0) === 2) {
            $title = Text::sprintf('JPAGETITLE', $title, $app->get('sitename'));
        }

        $this->document->setTitle($title);

        if ($this->params->get('menu-meta_description')) {
            $this->document->setDescription($this->params->get('menu-meta_description'));
        }

        if ($this->params->get('menu-meta_keywords')) {
            $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        }

        if ($this->params->get('robots')) {
            $this->document->setMetadata('robots', $this->params->get('robots'));
        }
    }
}
