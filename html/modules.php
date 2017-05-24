<?php
/**
 * @version		$Id: modules.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

function modChrome_contentonly($module, &$params, &$attribs) { 
    // Temporarily store header class in variable
	$headerClass    = $params->get('header_class');
	$headerClass    = ($headerClass) ? ' class="' . htmlspecialchars($headerClass, ENT_COMPAT, 'UTF-8') . '"' : '';
	
	if ($module->showtitle != 0) :?>
	    <h3 <?php echo $headerClass; ?>><?php echo $module->title; ?></h3>
    <?php endif;
	//echo  preg_replace("|<div[^>]*>(.*)</div>|s","$1",$module->content,1);
	echo $module->content;
}

function modChrome_css($module, &$params, &$attribs) { 
   	echo  preg_replace("|<div[^>]*>(.*)</div>|s","$1",$module->content,1);
}

function modChrome_bootstrap_modmenu($module, &$params, &$attribs) { ?>
    <div class="<?php echo htmlspecialchars($params->get('moduleclass_sfx')); $params->set('moduleclass_sfx',''); ?>">
        <?php if ($module->showtitle != 0) :?>
				<h3><?php echo $module->title; ?></h3>
        <?php endif; ?>
		<?php echo $module->content; ?>
    </div>
<?}

function modChrome_lotxhtml($module, &$params, &$attribs)
{
	$moduleTag      = $params->get('module_tag', 'div');
	$headerTag      = htmlspecialchars($params->get('header_tag', 'h3'), ENT_COMPAT, 'UTF-8');
	$bootstrapSize  = (int) $params->get('bootstrap_size', 0);
	$moduleClass    = $bootstrapSize != 0 ? ' span' . $bootstrapSize : '';

	// Temporarily store header class in variable
	$headerClass    = $params->get('header_class');
	$headerClass    = ($headerClass) ? ' class="' . htmlspecialchars($headerClass, ENT_COMPAT, 'UTF-8') . '"' : '';

	if (!empty ($module->content)) : ?>
		<<?php echo $moduleTag; ?> class="module<?php echo htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8') . $moduleClass; ?>">
			<?php if ((bool) $module->showtitle) : ?>
				<<?php echo $headerTag . $headerClass . '>' . $module->title; ?></<?php echo $headerTag; ?>>
			<?php endif; ?>
			<?php echo $module->content; ?>
		</<?php echo $moduleTag; ?>>
	<?php endif;
}