<?php 
/*
  * @package component kwpsolarsystem for Joomla! 5.x 6.x
 * @version $Id: kwpsolarsystem 1.0.0 2026-06-06 01:10:10Z $
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

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;

//require Formhelper.php in Helper and with constructor add $this->form to its param
//then call the field which prints all field. echo $this->blah

/** @var \Joomla\Component\Kwpsolarsystem\Administrator\View\Kwpsolarsystem\HtmlView $this */

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->getRegistry()->addExtensionRegistryFile('com_contenthistory');
$wa->useScript('keepalive')
   ->useScript('form.validate')
   ->useScript('com_contenthistory.admin-history-versions');
 //  var_dump("Hamid:".$this->form->getFieldSets('params')[1]);
?>
<form action="<?php echo Route::_('index.php?option=com_kwpsolarsystem&layout=edit&id=' . $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="adminForm" class="form-validate">
	<div class="row-fluid">
		<div class="span10 form-horizontal">
            <fieldset class="adminform">
			
				
				    <?php echo $this->form->renderField('id'); ?>
                        <?php echo $this->form->renderField('title'); ?>
                        <?php echo $this->form->renderField('alias'); ?>
                        <?php echo $this->form->renderField('state'); ?>
                        <?php echo $this->form->renderField('created_by'); ?>
                       	<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

				
            </fieldset>
    	</div>
        <input type="hidden" name="task" value="" />

        <?php echo HTMLHelper::_('form.token'); ?>
    </div>
	<div id="validation-form-failed" data-backend-detail="kwpsolarsystem" data-message="<?php echo $this->escape(Text::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>">
	</div>
</form>
