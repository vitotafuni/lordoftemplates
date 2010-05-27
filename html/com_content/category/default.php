<?php // no direct access
defined('_JEXEC') or die('Restricted access');
$cparams =& JComponentHelper::getParams('com_media');
?>
<div class="inner-text">
<div class="archive">
<div class="linkinfo"><a href="/blog.feed?type=rss"><?php echo JText::_('Iscriviti ai feed');?></a></div>
<?php if ($this->params->get('show_page_title', 1)) : ?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<h1><?php echo $this->escape($this->params->get('page_title')); ?></h1>
</div>
<?php endif; ?>

<div class="contentpane<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">

	<div class="contentdescription<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>" >
	<?php if ($this->category->image) : ?>
		<img src="<?php echo $this->baseurl . '/' . $cparams->get('image_path') . '/'. $this->category->image;?>" align="<?php echo $this->category->image_position;?>" hspace="6" alt="<?php echo $this->category->image;?>" />
	<?php endif; ?>
	<?php echo $this->category->description; ?>
</div>

<div>
	<?php
		$this->items =& $this->getItems();
		echo $this->loadTemplate('items');
	?>

	<?php if ($this->access->canEdit || $this->access->canEditOwn) :
			echo JHTML::_('icon.create', $this->category  , $this->params, $this->access);
	endif; ?>
	</div>
</div>
</div>
</div>
