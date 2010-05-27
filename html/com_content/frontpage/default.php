<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php if ($this->params->get('show_page_title', 1)) : ?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<?php echo $this->escape($this->params->get('page_title')); ?>
</div>
<?php endif; ?>
<div class="blog<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>" cellpadding="0" cellspacing="0">
<?php if ($this->params->def('num_leading_articles', 1)) : ?>
<div>

	<?php for ($i = $this->pagination->limitstart; $i < ($this->pagination->limitstart + $this->params->get('num_leading_articles')); $i++) : ?>
		<?php if ($i >= $this->total) : break; endif; ?>
		<div>
		<?php
			$this->item =& $this->getItem($i, $this->params);
			echo $this->loadTemplate('item');
		?>
		</div>
	<?php endfor; ?>

</div>
<?php else : $i = $this->pagination->limitstart; endif; ?>

<?php
$startIntroArticles = $this->pagination->limitstart + $this->params->get('num_leading_articles');
$numIntroArticles = $startIntroArticles + $this->params->get('num_intro_articles', 4);
if (($numIntroArticles != $startIntroArticles) && ($i < $this->total)) : ?>
<div>
	
		<?php
			$divider = '';
			if ($this->params->def('multi_column_order',1)) : // order across as before
			for ($z = 0; $z < $this->params->def('num_columns', 2); $z ++) :
				if ($z > 0) : $divider = " column_separator"; endif; ?>
				<?php
				    $rows = (int) ($this->params->get('num_intro_articles', 4) / $this->params->get('num_columns'));
				    $cols = ($this->params->get('num_intro_articles', 4) % $this->params->get('num_columns'));
				?>
				<div valign="top" width="<?php echo intval(100 / $this->params->get('num_columns')) ?>%" class="article_column<?php echo $divider ?>">
				<?php
				$loop = (($z < $cols)?1:0) + $rows;

				for ($y = 0; $y < $loop; $y ++) :
					$target = $i + ($y * $this->params->get('num_columns')) + $z;
					if ($target < $this->total && $target < ($numIntroArticles)) :
						$this->item =& $this->getItem($target, $this->params);
						echo $this->loadTemplate('item');
					endif;
				endfor;
						?></div>
						<?php endfor; 
						$i = $i + $this->params->get('num_intro_articles') ; 
			else : // otherwise, order down columns, like old category blog
				for ($z = 0; $z < $this->params->get('num_columns'); $z ++) :
					if ($z > 0) : $divider = " column_separator"; endif; ?>
					<div valign="top" width="<?php echo intval(100 / $this->params->get('num_columns')) ?>%" class="article_column<?php echo $divider ?>">
					<?php for ($y = 0; $y < ($this->params->get('num_intro_articles') / $this->params->get('num_columns')); $y ++) :
					if ($i < $this->total && $i < ($numIntroArticles)) :
						$this->item =& $this->getItem($i, $this->params);
						echo $this->loadTemplate('item');
						$i ++;
					endif;
				endfor; ?>
				</div>
		<?php endfor; 
		endif;?>		
	
</div>
<?php endif; ?>
<?php if ($this->params->def('num_links', 4) && ($i < $this->total)) : ?>

		<div class="blog_more<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
			<?php
				$this->links = array_splice($this->items, $i - $this->pagination->limitstart);
				echo $this->loadTemplate('links');
			?>
		</div>
<?php endif; ?>

<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->get('pages.total') > 1)) : ?>
	<div valign="top" align="center">
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
<?php if ($this->params->def('show_pagination_results', 1)) : ?>
	<div valign="top" align="center">
		<?php echo $this->pagination->getPagesCounter(); ?>
	</div>
<?php endif; ?>
<?php endif; ?>
</div>
