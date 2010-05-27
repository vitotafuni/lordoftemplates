<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<script language="javascript" type="text/javascript">

	function tableOrdering( order, dir, task )
	{
		var form = document.adminForm;

		form.filter_order.value 	= order;
		form.filter_order_Dir.value	= dir;
		document.adminForm.submit( task );
	}
</script>
<form action="<?php echo $this->action; ?>" method="post" name="adminForm" >
<div>
<?php if ($this->params->get('filter') || $this->params->get('show_pagination_limit')) : ?>
<div class="archive-filters">		
	<?php if ($this->params->get('filter')) : ?>

				<?php echo JText::_($this->params->get('filter_type') . ' Filter').'&nbsp;'; ?>
				<input type="text" name="filter" value="<?php echo $this->escape($this->lists['filter']);?>" class="inputbox" onchange="this.form.submit();" />

		<?php endif; ?>
		<?php if ($this->params->get('show_pagination_limit')) : ?>

			<?php
				echo '&nbsp;&nbsp;&nbsp;'.JText::_('Display Num').'&nbsp;';
				echo $this->pagination->getLimitBox();
			?>

		<?php endif; ?>
</div>
<?php endif; ?>
<?php if ($this->params->get('show_headings')) : ?>
<div class="archive-headings">
	
	<?php if ($this->params->get('show_title')) : ?>
 	<td class="sectiontableheader<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>" >
		<?php echo JHTML::_('grid.sort',  'Item Title', 'a.title', $this->lists['order_Dir'], $this->lists['order'] ); ?>
	</td>
	<?php endif; ?>
	<?php if ($this->params->get('show_date')) : ?>
	<td class="sectiontableheader<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>" width="25%">
		<?php echo JHTML::_('grid.sort',  'Date', 'a.created', $this->lists['order_Dir'], $this->lists['order'] ); ?>
	</td>
	<?php endif; ?>
	<?php if ($this->params->get('show_author')) : ?>
	<td class="sectiontableheader<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"  width="20%">
		<?php echo JHTML::_('grid.sort',  'Author', 'author', $this->lists['order_Dir'], $this->lists['order'] ); ?>
	</td>
	<?php endif; ?>
	<?php if ($this->params->get('show_hits')) : ?>
	<td align="center" class="sectiontableheader<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>" width="5%" nowrap="nowrap">
		<?php echo JHTML::_('grid.sort',  'Hits', 'a.hits', $this->lists['order_Dir'], $this->lists['order'] ); ?>
	</td>
	<?php endif; ?>
</div>
<?php endif; ?>
<ul class="article-list">
<?php foreach ($this->items as $item) : ?>
<li class="row<?php echo ($item->odd +1 ) . $this->escape($this->params->get('pageclass_sfx')); ?>" >
	
	<?php if ($this->params->get('show_title')) : ?>
	<?php if ($item->access <= $this->user->get('aid', 0)) : ?>

		<h2><a href="<?php echo $item->link; ?>">
			<?php echo $this->escape($item->title); ?></a></h2>
			<?php $this->item = $item; echo JHTML::_('icon.edit', $item, $this->params, $this->access) ?>
				<?php if ($this->params->get('show_date')) : ?>

		<?php echo $item->created; ?>

	<?php endif; ?>

	<?php else : ?>
	<td>
		<?php
			echo $this->escape($item->title).' : ';
			$link = JRoute::_('index.php?option=com_user&view=login');
			$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug, $item->sectionid), false);
			$fullURL = new JURI($link);
			$fullURL->setVar('return', base64_encode($returnURL));
			$link = $fullURL->toString();
		?>
		<a href="<?php echo $link; ?>">
			<?php echo JText::_( 'Register to read more...' ); ?></a>
	</td>
	<?php endif; ?>
	<?php endif; ?>

	<?php if ($this->params->get('show_author')) : ?>

		<?php echo $this->escape($item->created_by_alias) ? $this->escape($item->created_by_alias) : $this->escape($item->author); ?>

	<?php endif; ?>
	<?php if ($this->params->get('show_hits')) : ?>

		<?php echo $this->escape($item->hits) ? $this->escape($item->hits) : '-'; ?>

	<?php endif; ?>
</li>
<?php endforeach; ?>
</ul>
<?php if ($this->params->get('show_pagination')) : ?>
<div class="archive-paginator">
		<?php echo $this->pagination->getPagesLinks(); ?>

		<?php //echo $this->pagination->getPagesCounter(); ?>
</div>
<?php endif; ?>
</div>

<input type="hidden" name="id" value="<?php echo $this->category->id; ?>" />
<input type="hidden" name="sectionid" value="<?php echo $this->category->sectionid; ?>" />
<input type="hidden" name="task" value="<?php echo $this->lists['task']; ?>" />
<input type="hidden" name="filter_order" value="" />
<input type="hidden" name="filter_order_Dir" value="" />
<input type="hidden" name="limitstart" value="0" />
<input type="hidden" name="viewcache" value="0" />
</form>
