<?php
/**
 * Copyright (c) 2017 - Vito Tafuni - www.tapecode.it
 * licence: http://www.opensource.org/licenses/mit-license.php
 */

defined('_JEXEC') or die('Restricted access');

require_once dirname(__FILE__).'/html/renderer_head.php';


$path = $this->baseurl.'/templates/'.$this->template;
$full_path = $_SERVER['DOCUMENT_ROOT'].$path;

$this->setGenerator(null);

JFactory::getDocument()->addScriptDeclaration("
    JCaption = function(){};
    SqueezeBox = { initialize: function(){}, assign: function(){} };
");

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php	if( ($addrbarcol=$this->params->get('addresbarcolor')) ): ?>
	<!-- Address bar color - Android -->
	<meta name="theme-color" content="<?php echo $addrbarcol;?>" />
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="<?php echo $addrbarcol;?>">
	<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<?php 	endif; ?>
	<jdoc:include type="lothead" />
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"  type="text/css" media="all"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"  type="text/css" media="all"/>
	<jdoc:include type="lotcss" />
	
	
<?php if( ($sidebar=$this->params->get( 'sidebar' )) ): ?>
	<link rel="stylesheet" href="<?php echo $path ?>/css/sidebar.css"  type="text/css" media="all"/>
<?php endif; ?>	
	<link rel="stylesheet" href="<?php echo $path ?>/css/style.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="<?php echo $path ?>/css/typography.css" type="text/css" media="all"/>
<?php if( $this->params->get( 'dynamic_css' )): ?>
	<link rel="stylesheet" href="<?php echo $path ?>/css/dynamic.css" type="text/css" media="all"/>
	<?php endif;
@include $full_path.'/images/favicon/index.php';
if ($this->countModules('style')) :?>
	<style type="text/css">
		<jdoc:include type="modules" name="style" style="contentonly"/>
	</style>
<?php endif ?>
<?php
	// If Right-to-Left
	if ($this->direction == 'rtl') :
	    $doc->addStyleSheet('../media/jui/css/bootstrap-rtl.css');
	endif;
	 
	// Load specific language related CSS
	
	if (isset($lang) && $lang != NULL){
		$file = 'language/' . $lang->getTag() . '/' . $lang->getTag() . '.css';
		if (JFile::exists($file)) :
			$doc->addStyleSheet($file);
		endif;
        $doc->addStyleSheet('../media/jui/css/chosen.css');
	}
?>
</head>
<body>
    <?php if( $sidebar ): ?>
    <div id="wrapper">
        <div class="overlay"></div>
		<div id="sidebar-wrapper"><jdoc:include type="modules" name="sidebar" style="lotxhtml" /></div>
		<div id="page-content-wrapper">
    <?php endif; ?>
	<?php if( ($background=$this->params->get( 'background' )) ): ?>
    	<div id="lot_background" class="<?php echo $this->params->get('class-background');?>"><jdoc:include type="modules" name="background" style="lotxhtml" /></div>
    	<div id="lot_container_inner" class="<?php echo $this->params->get('class-container_inner');?>">
    <?php endif;?>
			<div id="lot_message" class="<?php echo $this->params->get('class-message');?>"><jdoc:include type="message" /></div>
			<div id="lot_container" class="<?php echo $this->params->get('class-container');?>">
				<?php if( ( $header=$this->params->get( 'header' )) ): ?>
					<div id="lot_header" class="<?php echo $this->params->get('class-header');?>"><?php echo $this->params->get('before-header');?><jdoc:include type="modules" name="header" style="lotxhtml" /><?php echo $this->params->get('after-header');?></div>
				<?php endif;
				if( ( $footer=$this->params->get( 'footer' )) || $header ): ?>
					<div id="lot_body" class="<?php echo $this->params->get('class-body');?>">
					<?php echo $this->params->get('before-body');?>
				<?php endif;
					$show_left=(!$this->params->get( 'fluid_left' ) || $this->countModules( 'left or left2' ));
					if(	$left=$this->params->get( 'left' ) && $show_left ): ?>
						<div id="lot_left" class="<?php echo $this->params->get('class-left');?>">
						<?php if( $this->params->get( 'left2' )  ): ?>
							<div id="lot_left1" class="<?php echo $this->params->get('class-left1');?>"><jdoc:include type="modules" name="left" style="lotxhtml" /></div>
							<div id="lot_left2" class="<?php echo $this->params->get('class-left2');?>"><jdoc:include type="modules" name="left2" style="lotxhtml" /></div>
						<?php else: ?>
							<jdoc:include type="modules" name="left" style="lotxhtml" />				
						<?php endif; ?>
						</div>
					<?php endif;
					$show_right=(!$this->params->get( 'fluid_right' ) || $this->countModules( 'right or right2' ));
					if( ($right=$this->params->get( 'right' )) || $left ): ?>
						<div id="lot_center" class="<?php echo $this->params->get('class-center');?>" class="<?php echo $show_right? ($show_left? "":"no_left"):($show_left? "no_right":"no_both") ?>">
					<?php endif;
						if( ($top=$this->params->get( 'top' )) ): ?>
							<div id="lot_top" class="<?php echo $this->params->get('class-top');?>"><?php echo $this->params->get('before-top');?><jdoc:include type="modules" name="top" style="lotxhtml" /><?php echo $this->params->get('after-top');?></div>
						<?php endif;
							if( ($bottom=$this->params->get( 'bottom' )) || $top ): ?>
								<div id="lot_content" class="<?php echo $this->params->get('class-content');?>">
							<?php endif; ?>
									<jdoc:include type="modules" name="center-top" style="lotxhtml" />
									<jdoc:include type="component" />
									<jdoc:include type="modules" name="center-bottom" style="lotxhtml" />
							<?php if( $top || $bottom ) : ?>
								</div>
							<?php endif; 
						if( $bottom ): ?>
							<div id="lot_bottom" class="<?php echo $this->params->get('class-bottom');?>"><?php echo $this->params->get('before-bottom');?><jdoc:include type="modules" name="bottom" style="lotxhtml" /><?php echo $this->params->get('after-bottom');?></div>
						<?php endif; 
					if( $left || $right ): ?>
						</div>
					<?php endif;
					if( $right && $show_right ): ?>
						<div id="lot_right" class="<?php echo $this->params->get('class-right');?>">
						<?php if( $this->params->get( 'right2' )): ?>						
							<div id="lot_right1" class="<?php echo $this->params->get('class-right1');?>"><jdoc:include type="modules" name="right" style="lotxhtml" /></div>
							<div id="lot_right2" class="<?php echo $this->params->get('class-right2');?>"><jdoc:include type="modules" name="right2" style="lotxhtml" /></div>
						<?php else: ?>
							<jdoc:include type="modules" name="right" style="lotxhtml" />
						<?php endif; ?>
						</div>
					<?php endif; 
				if( $header || $footer ): ?>
					</div>
					<?php echo $this->params->get('after-body');?>
				<?php endif;
				if( $footer ): ?>
					<div id="lot_footer" class="<?php echo $this->params->get('class-footer');?>"><?php echo $this->params->get('before-footer');?><jdoc:include type="modules" name="footer" style="lotxhtml" /><?php echo $this->params->get('after-footer');?></div>
				<?php endif; ?>
			</div> 
			<div id="lot_debug" class="<?php echo $this->params->get('class-debug');?>"><jdoc:include type="modules" name="debug" /></div>
			<?php if( $background ): ?>
		</div>
			<?php endif; ?>
			<?php if( $sidebar ): ?>
        </div>
    </div>
    		<?php endif; ?>
			
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!--[if lt IE 8]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.0(beta3)/IE8.js" type="text/javascript"></script>
	<![endif]-->
	<script type="text/javascript">
		jQuery.noConflict();
	</script>
	<?php if( $sidebar ): ?>
    <script>
		jQuery("#sidebar-toggle").click(function(e) {
			e.preventDefault();
			jQuery("#wrapper").toggleClass("toggled");
		});
	</script>
    <?php endif; ?>
    <jdoc:include type="lotjs" />
</body>
</html>
