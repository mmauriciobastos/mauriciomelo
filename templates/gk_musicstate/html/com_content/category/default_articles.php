<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.framework');

// Create some shortcuts.
$params		= &$this->item->params;
$n			= count($this->items);
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>

<?php if (empty($this->items)) : ?>
	<?php if ($this->params->get('show_no_articles', 1)) : ?>
	<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
	<?php endif; ?>
<?php else : ?>
	<form action="<?php echo htmlspecialchars(JFactory::getURI()->toString(), ENT_COMPAT, 'UTF-8'); ?>" method="post" name="adminForm" id="adminForm">
		<?php if ($this->params->get('show_headings') || $this->params->get('filter_field') != 'hide' || $this->params->get('show_pagination_limit')) :?>
		<fieldset class="filters">
			<?php if ($this->params->get('filter_field') != 'hide') :?>
			<legend class="hidelabeltxt">
				<?php echo JText::_('JGLOBAL_FILTER_LABEL'); ?>
			</legend>
	
			<div class="filter-search">
				<label class="filter-search-lbl" for="filter-search"><?php echo JText::_('COM_CONTENT_'.$this->params->get('filter_field').'_FILTER_LABEL').'&#160;'; ?></label>
				<input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="inputbox" onchange="document.adminForm.submit();" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />
			</div>
			<?php endif; ?>
	
			<?php if ($this->params->get('show_pagination_limit')) : ?>
			<div class="display-limit">
				<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>&#160;
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>
			<?php endif; ?>
	
			<input type="hidden" name="filter_order" value="" />
			<input type="hidden" name="filter_order_Dir" value="" />
			<input type="hidden" name="limitstart" value="" />
		</fieldset>
		<?php endif; ?>
	
		<table>
		<?php
			$headerTitle    = '';
			$headerDate     = '';
			$headerAuthor   = '';
			$headerHits     = '';
			$headerEdit     = '';
		?>
			<?php if ($this->params->get('show_headings')) : ?>
			<?php
				$headerTitle    = 'headers="categorylist_header_title"';
				$headerDate     = 'headers="categorylist_header_date"';
				$headerAuthor   = 'headers="categorylist_header_author"';
				$headerHits     = 'headers="categorylist_header_hits"';
				$headerEdit     = 'headers="categorylist_header_edit"';
			?>
			<thead>
				<tr>
					<th class="list-title" id="tableOrdering">
						<?php  echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder) ; ?>
					</th>
	
					<?php if ($date = $this->params->get('list_show_date')) : ?>
					<th class="list-date" id="tableOrdering2">
						<?php if ($date == "created") : ?>
							<?php echo JHtml::_('grid.sort', 'COM_CONTENT_'.$date.'_DATE', 'a.created', $listDirn, $listOrder); ?>
						<?php elseif ($date == "modified") : ?>
							<?php echo JHtml::_('grid.sort', 'COM_CONTENT_'.$date.'_DATE', 'a.modified', $listDirn, $listOrder); ?>
						<?php elseif ($date == "published") : ?>
							<?php echo JHtml::_('grid.sort', 'COM_CONTENT_'.$date.'_DATE', 'a.publish_up', $listDirn, $listOrder); ?>
						<?php endif; ?>
					</th>
					<?php endif; ?>
	
					<?php if ($this->params->get('list_show_author', 1)) : ?>
					<th class="list-author" id="tableOrdering3">
						<?php echo JHtml::_('grid.sort', 'JAUTHOR', 'author', $listDirn, $listOrder); ?>
					</th>
					<?php endif; ?>
	
					<?php if ($this->params->get('list_show_hits', 1)) : ?>
					<th class="list-hits" id="tableOrdering4">
						<?php echo JHtml::_('grid.sort', 'JGLOBAL_HITS', 'a.hits', $listDirn, $listOrder); ?>
					</th>
					<?php endif; ?>
				</tr>
			</thead>
			<?php endif; ?>
	
			<tbody>
			<?php foreach ($this->items as $i => $article) : ?>
				<?php if ($this->items[$i]->state == 0) : ?>
					<tr class="system-unpublished cat-list-row<?php echo $i % 2; ?>">
				<?php else: ?>
					<tr class="cat-list-row<?php echo $i % 2; ?>" >
				<?php endif; ?>
					<?php if (in_array($article->access, $this->user->getAuthorisedViewLevels())) : ?>
						<td <?php echo $headerTitle; ?> class="list-title">
							<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid)); ?>">
								<?php echo $this->escape($article->title); ?></a>
						</td>
	
						<?php if ($this->params->get('list_show_date')) : ?>
						<td <?php echo $headerDate; ?> class="list-date">
							<?php echo JHtml::_('date', $article->displayDate, $this->escape(
							$this->params->get('date_format', JText::_('DATE_FORMAT_LC3')))); ?>
						</td>
						<?php endif; ?>
	
						<?php if ($this->params->get('list_show_author', 1) && !empty($article->author )) : ?>
						<td <?php echo $headerAuthor; ?> class="list-author">
							<?php $author =  $article->author ?>
							<?php $author = ($article->created_by_alias ? $article->created_by_alias : $author);?>
	
							<?php if (!empty($article->contactid ) &&  $this->params->get('link_author') == true):?>
								<?php echo JHtml::_(
										'link',
										JRoute::_('index.php?option=com_contact&view=contact&id='.$article->contactid),
										$author
								); ?>
	
							<?php else :?>
								<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
							<?php endif; ?>
						</td>
						<?php endif; ?>
	
						<?php if ($this->params->get('list_show_hits', 1)) : ?>
						<td <?php echo $headerHits; ?> class="list-hits">
							<?php echo $article->hits; ?>
						</td>
						<?php endif; ?>
	
					<?php else : // Show unauth links. ?>
						<td <?php echo $headerEdit; ?>>
							<?php
								echo $this->escape($article->title).' : ';
								$menu		= JFactory::getApplication()->getMenu();
								$active		= $menu->getActive();
								$itemId		= $active->id;
								$link   = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
								$link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language)));
							?>
							<a href="<?php echo $link; ?>" class="register">
								<?php echo JText::_( 'COM_CONTENT_REGISTER_TO_READ_MORE' ); ?></a>
						</td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	
		<?php if (!empty($this->items) && (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1))) : ?>
			<?php echo str_replace('</ul>', '<li class="counter">'.$this->pagination->getPagesCounter().'</li>', $this->pagination->getPagesLinks()); ?>
		<?php endif; ?>
	</form>
<?php endif; ?>