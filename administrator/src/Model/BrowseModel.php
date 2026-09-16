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

namespace Joomla\Component\Kwpsolarsystem\Administrator\Model;

defined('_JEXEC') or die;


use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Factory;
use stdClass;


class BrowseModel extends ListModel {

	/*
	 * Get a list of folders and files 
	 */
	public function getItemsList($type = 'image') {
		$input = Factory::getApplication()->input;

		$type = $input->get('type', $type, 'string');

		switch ($type) {
			case 'video' :
				$filetypes = array('.mp4', '.ogv', '.webm');
				break;
			case 'audio' :
				$filetypes = array('.mp3', '.ogg');
				break;
			case 'image' :
			default :
				$filetypes = array('.jpg', '.jpeg', '.png', '.gif', '.tiff');
				break;
		}

		$folder = $input->get('folder', 'images', 'string');
		$tree = new stdClass();

		// look for all folder and files
		$this->getSubfolder(JPATH_SITE . '/' . $folder, $tree, implode('|', $filetypes), 1);

		$tree = $this->prepareList($tree);

		return $tree;
	}

	/* 
	 * List the subfolders and files according to the filter
	 */
	private function getSubfolder($folder, &$tree, $filter, $level) {
		$folders = Folder::folders($folder, '.', $recurse = false, $fullpath = true);

		if (! count($folders)) return;

		foreach ($folders as $f) {
			// list all authorized files from the folder
			$files = Folder::files($f, $filter, $recurse = false, $fullpath = false);
			$fName = File::makeSafe($f);
			$tree->$fName = new stdClass();
			$name = explode('/', $f);
			$name = end($name);
			$tree->$fName->name = $name;
			$tree->$fName->path = $f;
			$tree->$fName->files = $files;
			$tree->$fName->level = $level;

			// recursive loop
			$this->getSubfolder($f, $tree, $filter, $level+1);
		}
		return;
	}

	/* 
	 * Set level diff and check for depth
	 */
	private function prepareList($items) {
		if (! $items) return $items;

		$lastitem = 0;
		foreach ($items as $i => $item)
		{
			$item->deeper     = false;
			$item->shallower  = false;
			$item->level_diff = 0;

			if (isset($items->$lastitem))
			{
				$items->$lastitem->deeper     = ($item->level > $items->$lastitem->level);
				$items->$lastitem->shallower  = ($item->level < $items->$lastitem->level);
				$items->$lastitem->level_diff = ($items->$lastitem->level - $item->level);
			}
			$lastitem = $i;

			$item->basepath = str_replace(JPATH_SITE, '', $item->path);
			$item->basepath = str_replace('\\', '/', $item->basepath);
			$item->basepath = trim($item->basepath, '/');
		}

		return $items;
	}

	public function getPagination($total = null, $start = null, $limit = null)
	{
		return false;
	}
}
