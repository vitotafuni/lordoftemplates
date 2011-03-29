<?php
/**
 * Copyright (c) 2010 - Vito Tafuni - www.vitotafuni.com
 * licence: http://www.opensource.org/licenses/mit-license.php
 */

defined('_JEXEC') or die('Restricted access');

$path = $this->baseurl.'/templates/'.$this->template;
$full_path = $_SERVER['DOCUMENT_ROOT'].$path;
?>
<?php echo '<?xml version="1.0" encoding="utf-8"?'.'>'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
	<jdoc:include type="head" />
	<!--[if lt IE 8]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.0(beta3)/IE8.js" type="text/javascript"></script>
	<![endif]-->
	<link rel="stylesheet" href="<?php echo $path ?>/css/structure.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="<?php echo $path ?>/css/style.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="<?php echo $path ?>/css/typography.css" type="text/css" media="all"/>
<?php if( $this->params->get( 'dynamic_css' )): ?>
	<link rel="stylesheet" href="<?php echo $path ?>/css/dynamic.css" type="text/css" media="all"/>
<?php endif;
if(file_exists($full_path.'/favicon_anim.gif')): ?>
	<link rel="icon" type="image/gif" href="<?php echo $path ?>/favicon_anim.gif" >
<?php endif;
if(file_exists($full_path.'/favicon_iphone.png')): ?>
	<link rel="apple-touch-icon" href="<?php echo $path ?>/favicon_iphone.png"/>
<?php endif;
if ($this->countModules('style')) :?>
	<style type="text/css">
		<jdoc:include type="modules" name="style" />
	</style>
<?php endif ?>
</head>

<body>
<?php if( ($background=$this->params->get( 'background' )) ): ?>
	<div id="lot_background"><jdoc:include type="modules" name="background" style="rounded" /></div>
	<div id="lot_container_inner">
<?php endif;?>
	<div id="lot_message"><jdoc:include type="message" /></div>
	<div id="lot_container">
	<?php if( ( $header=$this->params->get( 'header' )) ): ?>
		<div id="lot_header"><jdoc:include type="modules" name="header" style="rounded" /></div>
	<?php endif;
	if( ( $footer=$this->params->get( 'footer' )) || $header ): ?>
		<div id="lot_body">
	<?php endif;
		if(	$left=$this->params->get( 'left' ) && $show_left=(!$this->params->get( 'fluid_left' ) || $this->countModules( 'left or left2' )) ): ?>
			<div id="lot_left">
			<?php if( $this->params->get( 'left2' )  ): ?>
				<div id="lot_left1"><jdoc:include type="modules" name="left" style="rounded" /></div>
				<div id="lot_left2"><jdoc:include type="modules" name="left2" style="rounded" /></div>
			<?php else: ?>
				<jdoc:include type="modules" name="left" style="rounded" />				
			<?php endif; ?>
			</div>
		<?php endif;
		$show_right=(!$this->params->get( 'fluid_right' ) || $this->countModules( 'right or right2' ));
		if( ($right=$this->params->get( 'right' )) || $left ): ?>
			<div id="lot_center" class="<?php echo $show_right? ($show_left? "":"no_left"):($show_left? "no_right":"no_both") ?>">
		<?php endif;
			if( ($top=$this->params->get( 'top' )) ): ?>
				<div id="lot_top"><jdoc:include type="modules" name="top" style="rounded" /></div>
			<?php endif;
				if( ($bottom=$this->params->get( 'bottom' )) || $top ): ?>
					<div id="lot_content">
				<?php endif; ?>
						<jdoc:include type="modules" name="center-top" style="rounded" />
						<jdoc:include type="component" />
						<jdoc:include type="modules" name="center-bottom" style="rounded" />
				<?php if( $top || $bottom ) : ?>
					</div>
				<?php endif; 
			if( $bottom ): ?>
				<div id="lot_bottom"><jdoc:include type="modules" name="bottom" style="rounded" /></div>
			<?php endif; 
		if( $left || $right ): ?>
			</div>
		<?php endif;
		if( $right && $show_right ): ?>
			<div id="lot_right">
			<?php if( $this->params->get( 'right2' )): ?>						
				<div id="lot_right1"><jdoc:include type="modules" name="right" style="rounded" /></div>
				<div id="lot_right2"><jdoc:include type="modules" name="right2" style="rounded" /></div>
			<?php else: ?>
				<jdoc:include type="modules" name="right" style="rounded" />
			<?php endif; ?>
			</div>
		<?php endif; 
	if( $header || $footer ): ?>
		</div>
	<?php endif;
	if( $footer ): ?>
		<div id="lot_footer"><jdoc:include type="modules" name="footer" style="rounded" /></div>
	<?php endif; ?>
	</div>
	<div id="lot_debug"><jdoc:include type="modules" name="debug" /></div>
	<?php if( $background ): ?>
	</div>
	<?php endif; ?>
</body>
</html>
