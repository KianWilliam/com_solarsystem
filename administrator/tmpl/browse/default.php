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
 //I added it myself kwpfof might not be accessible without it, use require if it didn't work
//namespace Kwpsolarsystem;
//use Carouselck\CKFof;
defined('_JEXEC') or die;

//use Joomla\Component\Kwpsolarsystem\Administrator\Helper\KwpframeworkHelper;
use Joomla\Component\Kwpsolarsystem\Administrator\Helper\KwpfofHelper;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Session\Session;
//require_once(JPATH_ROOT . '/administrator/components/com_carouselck/helpers/defines.js.php');
define('KWPSOLARSYSTEM_URL', Uri::base(true) . '/index.php?option=com_kwpsolarsystem');
$imagespath = Uri::root(true) . '/media/com_kwpsolarsystem/images/';
//HTMLHelper::_('jquery.framework');
//webasset does'nt work! in modal
$doc = Factory::getDocument();
//$wa = Factory::getDocument()->getWebAssetManager();
//$wa->registerAndUseStyle('kwpbrowse', Uri::Base(true).'/components/com_kwpsolarsystem/assets/css/kwpbrowse.css');
//$wa->registerAndUseScript('kwpbrowsejs', Uri::Base(true).'/components/com_kwpsolarsystem/assets/js/kwpbrowse.js?ver=2.1.0');*/
$doc->addStylesheet(Uri::Base(true).'/components/com_kwpsolarsystem/assets/css/kwpbrowse.css');
//$doc->addScript(CAROUSELCK_MEDIA_URI . '/assets/ckbrowse.js?ver=2.1.0');
$input = Factory::getApplication()->input;

$returnFunc = $input->get('func', 'kwpSelectFile', 'cmd');
$returnField = $input->get('field', '', 'string');
$type = $input->get('type', 'image', 'string');
//Carouselck\CKFramework::loadCss();
//KwpframeworkHelper::loadCss();

switch ($type) {
	case 'video' :
		$fileicon = 'file_video.png';
		break;
	case 'audio' :
		$fileicon = 'file_audio.png';
		break;
	case 'folder' :
	case 'image' :
	default :
		$fileicon = 'file_image.png';
		break;
}
//var_dump("anal canadian:".JPATH_SITE);
?>
<script type="text/javascript">
	var URIROOT = "<?php echo Uri::root(true); ?>";
	var URIBASE = "<?php echo Uri::base(true); ?>";
	var KWPSOLARSYSTEM_ADMIN_URL = '<?php echo Uri::root() ?>administrator/index.php?option=com_kwpsolarsystem';
	var KWPSOLARSYSTEM_URL = '<?php echo Uri::base()  ?>index.php?option=com_kwpsolarsystem';


	var KWPSOLARSYSTEMTOKEN = '<?php echo Factory::getSession()->getFormToken() ?>=1';
	
</script>
<div id="kwpbrowse" class="clearfix">
<div id="kwpfolderupload">
	<div class="inner">
		<div class="upload">
			<h2 class="uploadinstructions"><?php echo Text::_( 'Drop files here to upload' ); ?></h2>
			<p><?php echo Text::_( 'or Select Files' ); ?></p><input id="kwpfileupload" type="file" class="" />

		</div>
	</div>
</div>
<div id="kwpfoldertreelist">
<p><?php echo Text::_('KWPSOLARSYSTEM_BROWSE_INFOS') ?></p>
<h3><?php echo Text::_('KWPSOLARSYSTEM_FOLDERS') ?></h3>
<?php
$lastitem = 0;
foreach ($this->items as $i => $folder) {
	$submenustyle = '';
	$folderclass = '';
	if ($folder->level == 1) {
		$submenustyle = 'display: block;';
		$folderclass = 'kwpcurrent';
	}
	$pathway = str_replace('/', '</span><span class="kwpfoldertreepath">', ($folder->basepath));
	?>
	<div class="kwpfoldertree <?php echo $folderclass ?> <?php echo ($folder->deeper ? 'parent' : '') ?> <?php //echo (count($folder->files) ? 'hasfiles' : '') ?>" data-level="<?php echo $folder->level ?>" data-path="<?php echo ($folder->basepath) ?>">
		<?php if ($folder->level > 1) { ?><div class="kwpfoldertreetoggler" onclick="kwpToggleTreeSub(this)"></div><?php } ?>
		<div class="kwpfoldertreename" onclick="kwpLoadFiles(this, '<?php echo $type ?>', '<?php echo ($folder->basepath) ?>')"><span class="icon-folder"></span><?php echo ($folder->name); ?>
		<?php /*<div class="ckfoldertreecount"><?php echo count($folder->files); ?></div> */ ?>
		</div>
		<div class="kwpfoldertreefiles">
			<?php if ($type == 'folder') { ?>
			<div id="kwpfoldertreelistfolderselection">
				<div class="kwpbutton kwpbutton-primary" style="font-size:20px;padding: 10px 20px;" onclick="kwpSelectFolder('<?php echo ($folder->basepath) ?>')"><i class="fas fa-check-square"></i> <?php echo Text::_('KWP_SELECT_FOLDER') ?><br /><small><?php echo $pathway ?></small></div>
			</div>
			<?php } ?>
			<div class="kwpfoldertreepathway kwpinterface">
				<span><?php echo $pathway; ?></span>
				<?php
				if (KwpfofHelper::userCan('create', 'com_media')) {
				?>
				<span class="kwpfoldertreepathwayactions">
					<span class="kwpfoldertreepathwayaddfolder kwpbutton"  onclick="kwpAddFolder()"><?php echo Text::_('KWP_ADD_SUB_FOLDER') ?></span>
					<span class="kwpfoldertreepathwayfoldername"><input type="text" class="kwpfoldertreepathwayaddfoldername" /></span>
					<span class="kwpfoldertreepathwaycreatefolder kwpbutton" onclick="kwpCreateFolder(this, '<?php echo ($folder->basepath) ?>')"><?php echo Text::_('Create Folder') ?></span>
				</span>
				<?php } ?>
			</div>
		<?php if (isset($folder->files) && ! empty($folder->files)) {
				foreach ($folder->files as $j => $file) { 
		?>
				<div class="kwpfoldertreefile kwpwait" data-type="<?php echo $type ?>" onclick="kwpSelectFile(this)" data-path="<?php echo ($folder->basepath) ?>" data-filename="<?php echo ($file) ?>">
					<div class="kwpfakeimage" data-src="<?php echo Uri::root(true) . '/' . ($folder->basepath) . '/' . ($file) ?>" title="<?php echo ($file); ?>" ></div>
					<div class="kwpimagetitle"><?php echo ($file); ?></div>
					
			</div>
		<?php } ?>
		<?php } ?>
		</div>

	<?php
		if ($folder->deeper)
		{
			echo '<div class="kwpsubfolder" style="' . $submenustyle . '">';
		}
		elseif ($folder->shallower)
		{
			// The next item is shallower.
			echo '</div>'; // close ckfoldertree
			echo str_repeat('</div></div>', $folder->level_diff); // close cksubfolder + ckfoldertree
		} 
		else
		{
			// The next item is on the same level.
			echo '</div>'; // close ckfoldertree
		}
}

?>
</div>
<div id="kwpfoldertreepreview">
	<div class="inner">
		<?php if ($type == 'image') { ?>
		<div id="kwpfoldertreepreviewimage">
		</div>
		<?php } ?>
	</div>
</div>

</div>
<script>
var $kwp = window.$kwp || jQuery.noConflict();
var URIROOT = window.URIROOT || '<?php echo Uri::root(true) ?>';

function kwpToggleTreeSub(btn) {
	var item = $kwp(btn).parent();
	if (item.hasClass('kwpopened')) {
		item.removeClass('kwpopened');
	} else {
		item.addClass('kwpopened')
		// item.find('> .cksubfolder, > .ckfoldertreefiles').css('opacity','0').animate({'opacity': '1'}, 300);
	}
}

function kwpShowFiles(btn) {
	// show the image in place of divs
//	console.log("lintzieene, haha")
	var fakeImages = $kwp(btn).find('~ .kwpfoldertreefiles .kwpfakeimage');
	if (fakeImages.length) {
		fakeImages.each(function() {
			$fakeImage = $kwp(this);
			var source = $fakeImage.parent().attr('data-type') == 'image' || $fakeImage.parent().attr('data-type') == 'folder' ? $fakeImage.attr('data-src') : '<?php echo $imagespath . $fileicon ?>';
			$fakeImage.after('<img src="' + source + '" title="' + $fakeImage.attr('title') + '" loading="lazy"/>');
			$fakeImage.parent().removeClass('kwpwait');
			$fakeImage.remove();
		});
	}
	// set the current state on the folder
	var item = $kwp(btn).parent();
	$kwp('.kwpcurrent').not(btn).removeClass('kwpcurrent');
	if (item.hasClass('kwpcurrent')) {
		item.removeClass('kwpcurrent');
	} else {
		item.addClass('kwpcurrent')
	}
}

function kwpSelectFile(btn) {
	//console.log(btn)
	try {
		if (typeof(window.parent.<?php echo $returnFunc ?>) != 'undefined') {

			window.parent.<?php echo $returnFunc ?>($kwp(btn).attr('data-path') + '/' + $kwp(btn).attr('data-filename'), '<?php echo $returnField ?>');
				  
	if (typeof(window.parent.KWPBox) != 'undefined')
		window.parent.KWPBox.close();
		} else {
			alert('ERROR : The function <?php echo $returnFunc ?> is missing in the parent window. Please contact the developer');
		}
	}
catch(err) {
		alert('ERROR : ' + err.message + '. Please contact the developper.');
	}
}

function kwpSelectFolder(path) {
	try {
		if (typeof(window.parent.<?php echo $returnFunc ?>) != 'undefined') {
			window.parent.<?php echo $returnFunc ?>(path, '<?php echo $returnField ?>');
			if (typeof(window.parent.KWPBox) != 'undefined') window.parent.KWPBox.close();
		} else {
			alert('ERROR : The function <?php echo $returnFunc ?> is missing in the parent window. Please contact the developer');
		}
	}
	catch(err) {
		alert('ERROR : ' + err.message + '. Please contact the developper.');
	}
}

// display the images in the root folder
kwpShowFiles($kwp('.kwpfoldertreename').first()[0]);
</script>
