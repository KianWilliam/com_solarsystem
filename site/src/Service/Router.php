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

namespace Joomla\Component\Kwpsolarsystem\Site\Service;

defined('_JEXEC') or die;

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Component\Router\RouterView;
use Joomla\CMS\Component\Router\RouterViewConfiguration;
use Joomla\CMS\Component\Router\Rules\MenuRules;
use Joomla\CMS\Component\Router\Rules\NomenuRules;
use Joomla\CMS\Component\Router\Rules\StandardRules;
use Joomla\CMS\Menu\AbstractMenu;

/**
 * Routing class for the com_kwpsolarsystem component
 *
 * @since  3.3
 */
class Router extends RouterView
{
    /**
     * @param   SiteApplication  $app   The application object
     * @param   AbstractMenu     $menu  The menu object to work with
     */
    public function __construct(SiteApplication $app, AbstractMenu $menu)
    {
        $this->registerView(new RouterViewConfiguration('kwpsolarsystems'));
		$this->registerView(new RouterViewConfiguration('kwpsolarsystem'));

        parent::__construct($app, $menu);

        $this->attachRule(new MenuRules($this));
        $this->attachRule(new StandardRules($this));
        $this->attachRule(new NomenuRules($this));
    }

    /**
     * Build the route for the com_kwpsolarsystem component
     *
     * @param   array  &$query  An array of URL arguments
     *
     * @return  array  The URL arguments to use to assemble the subsequent URL
     *
     * @since   3.3
     */
    public function build(&$query)
    {
        $segments = array();

        if (isset($query['view']))
        {
            $segments[] = $query['view'];
            unset($query['view']);
        }

        if (isset($query['id']))
        {
            $segments[] = $query['id'];
            unset($query['id']);
        }

        return $segments;
    }

    /**
     * Parse the segments of a URL.
     *
     * @param   array  &$segments  The segments of the URL to parse.
     *
     * @return  array  The URL attributes to be used by the application.
     *
     * @since   3.3
     */
    public function parse(&$segments)
    {
        $vars = array();

        // View is always the first element of the array
        $count = count($segments);

        if ($count)
        {
            $segment = array_shift($segments);

            if (is_numeric($segment))
            {
                $vars['id'] = $segment;
            }
            else
            {
                $vars['view'] = $segment;
            }

            $segment = array_shift($segments);

            if (is_numeric($segment))
            {
                $vars['id'] = $segment;
            }
        }

        return $vars;
    }
}
