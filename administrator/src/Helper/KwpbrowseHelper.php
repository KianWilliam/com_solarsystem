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
/*
use \Kwpsolarsystem\KWPPath;
use \Kwpsolarsystem\KWPFolder;
use \Kwpsolarsystem\KWPFile;
*/
namespace Joomla\Component\Kwpsolarsystem\Administrator\Helper;
//namespace Kwpsolarsystem;
use Joomla\CMS\Factory;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;
use stdClass;
use Joomla\Component\Kwpsolarsystem\Administrator\View\Browse;


defined('_JEXEC') or die;
/*
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
*/
class KwpbrowseHelper {

	static $isRestrictedUser = false;
	
		function __construct() {
	
	}


	public static function getFileTypes($type) {
		$input = Factory::getApplication()->input;
		$type = $input->get('type', $type, 'string');

		switch ($type) {
			case 'video' :
				$filetypes = array('.mp4', '.ogv', '.webm', '.MP4', '.OGV', '.WEBM');
				break;
			case 'audio' :
				$filetypes = array('.mp3', '.ogg', '.MP3', '.OGG');
				break;
			case 'image' :
			default :
				$filetypes = array('.jpg', '.jpeg', '.png', '.gif', '.tiff', '.JPG', '.JPEG', '.PNG', '.GIF', '.TIFF', '.ico', '.webp', '.WEBP');
				break;
		}

		return $filetypes;
	}

	/*
	 * Get a list of folders and files 
	 */
	public static function getItemsList($type = 'image') {
		//var_dump('hamid');
		//exit();
		$input = Factory::getApplication()->input;

		$type = $input->get('type', $type, 'string');

		switch ($type) {
			case 'video' :
				$filetypes = array('.mp4', '.ogv', '.webm', '.MP4', '.OGV', '.WEBM');
				break;
			case 'audio' :
				$filetypes = array('.mp3', '.ogg', '.MP3', '.OGG');
				break;
			case 'image' :
			default :
				$filetypes = array('.jpg', '.jpeg', '.png', '.gif', '.tiff', '.JPG', '.JPEG', '.PNG', '.GIF', '.TIFF', '.ico');
				break;
		}

		$folder = $input->get('folder', '', 'string') ? '/' . trim($input->get('folder', '', 'string'), '/') : '/' . trim(ComponentHelper::getParams('com_kwpsolarsystem')->get('imagespath', 'images/kwpsolarsystem'), '/');

		// makes replacement if specific user management is set
		if (stristr($folder, '$userid')) {
			self::$isRestrictedUser = true;
			$user = Factory::getUser();
			$folder = str_replace('$userid', 'user_' . $user->id, $folder);
			if (! file_exists(JPATH_SITE . '/' . $folder)) {
				Folder::create(JPATH_SITE . '/' . $folder);
			}
		}

		// no folder filtering 
		if (ComponentHelper::getParams('com_kwpsolarsystem')->get('imagespathexclusive', '0') == '0') {
		$folder = $input->get('folder', 'images', 'string');
		}

		$tree = new stdClass();

		// list the files in the root folder
		$fName = self::createFolderObj(JPATH_SITE . '/' . $folder, $tree, 1);
		$tree->$fName->files = self::getImagesInFolder(JPATH_SITE . '/' . $folder, implode('|', $filetypes));

		// look for all folder and files
		self::getSubfolder(JPATH_SITE . '/' . $folder, $tree, implode('|', $filetypes), 2);
		$tree = self::prepareList($tree);

		return $tree;
	}

	/* 
	 * List the subfolders and files according to the filter
	 */
	private static function getSubfolder($folder, &$tree, $filter, $level) {
		$folders = Folder::folders($folder, '.', $recurse = false, $fullpath = true);
		natcasesort($folders);

		if (! count($folders)) return;

		foreach ($folders as $f) {
			$fName = self::createFolderObj($f, $tree, $level);

			// list all authorized files from the folder
			// self::getImagesInFolder($f, $tree, $fName, $filter, $level);

			// recursive loop
			self::getSubfolder($f, $tree, $filter, $level+1);
		}
		return;
	}
	
	private static function createFolderObj($f, &$tree, $level) {
			$fName = File::makeSafe(str_replace(JPATH_SITE, '', $f));
			$tree->$fName = new stdClass();
			$name = explode('/', $f);
			$name = end($name);
			$tree->$fName->name = ($level == 1 && self::$isRestrictedUser == true) ? 'images' : $name;
			$tree->$fName->path = $f;
			$tree->$fName->level = $level;
		$tree->$fName->files = false;

		return $fName;
		}

	/* 
	 * List the subfolders and files according to the filter
	 */
	public static function getImagesInFolder($f, $filter = '.') {

			// list all authorized files from the folder
			$files = Folder::files($f, $filter, $recurse = false, $fullpath = false);
			if (is_array($files)) natcasesort($files);

			return $files;
		}

	/* 
	 * Set level diff and check for depth
	 */
	private static function prepareList($items) {
		if (! $items) return $items;

		$lastitem = 0;
		foreach ($items as $i => $item)
		{
			self::prepareItem($item);

			if ($item->level != 0) {
				if (isset($items->$lastitem))
				{
					$items->$lastitem->deeper     = ($item->level > $items->$lastitem->level);
					$items->$lastitem->shallower  = ($item->level < $items->$lastitem->level);
					$items->$lastitem->level_diff = ($items->$lastitem->level - $item->level);
				}
			}
			$lastitem = $i;

			
		}

		// for the last item
		if (isset($items->$lastitem))
		{
			$items->$lastitem->deeper     = (1 > $items->$lastitem->level);
			$items->$lastitem->shallower  = (1 < $items->$lastitem->level);
			$items->$lastitem->level_diff = ($item->level - 1);
		}

		return $items;
	}

	/* 
	 * Set the default values
	 */
	private static function prepareItem(&$item) {
		$item->deeper     = false;
		$item->shallower  = false;
		$item->level_diff = 0;
		$item->basepath = str_replace(JPATH_SITE, '', $item->path);
		$item->basepath = str_replace('\\', '/', $item->basepath);
		$item->basepath = trim($item->basepath, '/');
	}

	/**
	 * Get the file and store it on the server
	 * 
	 * @return mixed, the method return
	 */
	public static function ajaxAddPicture() {
		// check the token for security, it is set already by js
		if (! Session::checkToken('get')) {
			$msg = Text::_('JINVALID_TOKEN');
			echo '{"error" : "' . $msg . '"}';
			exit;
		}

		$app = Factory::getApplication();
		$input = $app->input;
		$file = $input->files->get('file', '', 'array');
		// $imgpath = '/' . trim($input->get('path', '', 'string'), '/') . '/';
		$imgpath = $input->get('path', '', 'string') ? '/' . trim($input->get('path', '', 'string'), '/') . '/' : '/' . trim(ComponentHelper::getParams('com_kwpsolarsystem')->get('imagespath', 'images/kwpsolarsystem'), '/') . '/';

		// makes replacement if specific user management is set
		$user = Factory::getUser();
		$imgpath = str_replace('$userid', 'user_' . $user->id, $imgpath);

		if (!is_array($file)) {
			$msg = Text::_('KWP_NO_FILE_RECEIVED');
			echo '{"error" : "' . $msg . '"}';
			exit;
		}

		$filename = File::makeSafe($file['name']);

		// check the file extension // TODO recup preg_match de local dev
		// if (\Joomla\CMS\Filesystem\File::getExt($filename) != 'jpg') {
			// $msg = \Joomla\CMS\Language\Text::_('CK_NOT_JPG_FILE');
			// echo '{"error" : "'  $msg  '"}';
			// exit;
		// }

		//Set up the source and destination of the file
		$src = $file['tmp_name'];

		// check if the file exists
		if (!$src || !File::exists($src)) {
			$msg = Text::_('KWP_FILE_NOT_EXISTS');
			echo '{"error" : "' . $msg . '"}';
			exit;
		}

		// check if folder exists, if not then create it
		if (!Folder::exists(JPATH_SITE . $imgpath)) {
			if (!Folder::create(JPATH_SITE . $imgpath)) {
				$msg = Text::_('KWP_UNABLE_TO_CREATE_FOLDER') . ' : ' . $imgpath;
				echo '{"error" : "' . $msg . '"}';
				exit;
			}
		}

		// write the file
		if (! File::copy($src, JPATH_SITE . $imgpath . $filename)) {
			$msg = Text::_('KWP_UNABLE_WRITE_FILE');
			echo '{"error" : "' . $msg . '"}';
			exit;
		}
		echo '{"img" : "' . $imgpath . $filename . '", "filename" : "' . $filename . '"}';
		exit;
	}

	public static function createFolder($path, $folder) {
		$path = Path::clean(JPATH_SITE . '/' . $path . '/' . $folder);

		if (!is_dir($path) && !is_file($path))
			{
				if (Folder::create($path))
				{
					$data = "<html>\n<body bgcolor=\"#FFFFFF\">\n</body>\n</html>";
					File::write($path . '/index.html', $data);
				} else {
					return false;
				}
		}
		return true;
	}
}
