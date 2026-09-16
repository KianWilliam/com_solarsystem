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

namespace Joomla\Component\Kwpsolarsystem\Site\Helper;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

/**
 * Kwpsolarsystem access helper
 */
class AccessHelper
{
    private bool $ownRecordsLoaded = false;
    private array $ownRecordsById = [];

    /**
     * @param string $table
     * @return void
     */
    public function preloadOwnRecords(string $table): void
    {
        $user = Factory::getUser();
        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select('id, created_by')
            ->from($table)
            ->where($db->qn('created_by') . ' = ' . $db->q((int)$user->id));
        $db->setQuery($query);
        $records = $db->loadAssocList();
        foreach ($records as $record) {
            $this->ownRecordsById[$record['id']] = (int)$record['created_by'];
        }
        $this->ownRecordsLoaded = true;
    }

    /**
     * @param int|null $id
     * @return bool
     * @throws \Exception
     */
    public function canAccessOwnRecord(?int $id = null): bool
    {
        if (!$this->ownRecordsLoaded) {
            throw new \Exception('Please preload records before calling the ' . __METHOD__ . ' method');
        }
        $app = Factory::getApplication();
        if (empty($id)) {
            $id = $app->input->getInt('id');
            $params = $app->getParams();

            $paramId = $params->get('id');
            if ($paramId && !$id) {
                $id = $paramId;
            }
        }
        $user = Factory::getUser();
        $userId = $this->ownRecordsById[$id] ?? 0;
        return $userId === (int)$user->id && $user->authorise('core.edit.own', 'com_kwpsolarsystem');
    }
}
