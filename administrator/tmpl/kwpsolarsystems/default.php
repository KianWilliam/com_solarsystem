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

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Component\Kwpsolarsystem\Administrator\Helper\KwpsolarsystemHelper;
?>
<?php $listOrder = $this->listOrder; ?>
<?php $listDirn = $this->listDirn;
$saveOrder = $listOrder;
if ($listOrder && !empty($this->items))
{
	$this->saveOrderingUrl = 'index.php?option=com_kwpsolarsystem&task=kwpsolarsystems.saveOrderAjax&tmpl=component&' . Session::getFormToken() . '=1';
	HTMLHelper::_('draggablelist.draggable');
}

?>
<form action="<?php echo Route::_('index.php?option=com_kwpsolarsystem&view=kwpsolarsystems'); ?>" method="post" name="adminForm" id="adminForm" data-list-order="<?php echo $listOrder; ?>">
	<?php if(!empty($this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php else : ?>
		<?php echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>
		<div id="j-main-container">
			<?php endif;?>
			<table class="table table-striped" id="kwpsolarsystemList">
				<thead>
					<tr>
						<?php if (isset($this->items[0]->ordering)): ?>
							<th width="1%" class="nowrap center hidden-phone">
								<?php echo HTMLHelper::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
							</th>
						<?php endif; ?>
						<th width="1%" class="nowrap center">
							<?php echo HTMLHelper::_('grid.checkall'); ?>
						</th>
						<th class="left">
							<?php echo HTMLHelper::_('grid.sort',  'Title', 'a.title', $listDirn, $listOrder); ?>
						</th>
						<th class="left">
							<?php echo HTMLHelper::_('grid.sort',  'Created By', 'a.created_by', $listDirn, $listOrder); ?>
						</th>
						<th class="left">
							<?php echo HTMLHelper::_('grid.sort',  'State', 'a.state', $listDirn, $listOrder); ?>
						</th>
						<th width="1%" class="nowrap">
							<?php echo HTMLHelper::_('grid.sort', 'Id', 'a.id', $listDirn, $listOrder); ?>
						</th>
					</tr>
				</thead>
				<tbody <?php if ($saveOrder) :?> class="js-draggable" data-url="<?php echo $this->saveOrderingUrl; ?>" data-direction="<?php echo strtolower($listDirn); ?>" data-nested="true"<?php endif; ?>>
				<?php
				foreach ($this->items as $i => $item) :
					$ordering   = ($listOrder == 'a.ordering');
					$canCreate	= $this->user->authorise('core.create',		'com_kwpsolarsystem');
					$canEdit	= $this->user->authorise('core.edit',		'com_kwpsolarsystem');
					$canCheckin	= $this->user->authorise('core.manage',		'com_kwpsolarsystem');
					$canChange	= $this->user->authorise('core.edit.state',	'com_kwpsolarsystem');
					
					?>
					<tr class="row<?php echo $i % 2; ?>" data-draggable-group="1">
						<td class="order nowrap center hidden-phone">
							<?php
							$iconClass = '';
							if (!$canChange)
							{
								$iconClass = ' inactive';
							}
							elseif (!$this->saveOrder)
							{
								$iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
							}
							?>
							<span class="sortable-handler<?php echo $iconClass; ?>">
								<span class="icon-ellipsis-v"></span>
							</span>
							<?php if ($canChange && $this->saveOrder) : ?>
								<input type="text" style="display:none" name="order[]" size="5"
									   value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
							<?php endif; ?>
						</td>
						<td class="center">
							<?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
						</td>
							<td class="center">
							<?php echo  $item->title; ?>
						</td>
						<td>
							<?php echo $item->created_by; ?>
						</td>
						<td>
							<?php echo HTMLHelper::_('jgrid.published', $item->state, $i, 'kwpsolarsystems.', $canChange, 'cb'); ?>
						</td>
						<td>
							<a href="<?php echo Route::_('index.php?option=com_kwpsolarsystem&task=kwpsolarsystem.edit&id=' . $item->id); ?>">
								<?php echo $item->id; ?>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<div class="pagination center">
				<?php echo $this->pagination->getListFooter(); ?>
			</div>
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
			<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
			<?php echo HTMLHelper::_('form.token'); ?>
		</div>
	</div>
</form>
