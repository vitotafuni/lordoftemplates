<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Document
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

use Joomla\Utilities\ArrayHelper;

class JDocumentRendererHtmlLothead extends JDocumentRendererHtmlHead
{
	public function fetchHead($document)
	{
    	// Convert the tagids to titles
		if (isset($document->_metaTags['name']['tags']))
		{
			$tagsHelper = new JHelperTags;
			$document->_metaTags['name']['tags'] = implode(', ', $tagsHelper->getTagNames($document->_metaTags['name']['tags']));
		}

		// Trigger the onBeforeCompileHead event
		$app = JFactory::getApplication();
		$app->triggerEvent('onBeforeCompileHead');

		// Get line endings
		$lnEnd  = $document->_getLineEnd();
		$tab    = $document->_getTab();
		$tagEnd = ' />';
		$buffer = '';

		// Generate charset when using HTML5 (should happen first)
		if ($document->isHtml5())
		{
			$buffer .= $tab . '<meta charset="' . $document->getCharset() . '" />' . $lnEnd;
		}

		// Generate base tag (need to happen early)
		$base = $document->getBase();

		if (!empty($base))
		{
			$buffer .= $tab . '<base href="' . $base . '" />' . $lnEnd;
		}

		// Generate META tags (needs to happen as early as possible in the head)
		foreach ($document->_metaTags as $type => $tag)
		{
			foreach ($tag as $name => $content)
			{
				if ($type == 'http-equiv' && !($document->isHtml5() && $name == 'content-type'))
				{
					$buffer .= $tab . '<meta http-equiv="' . $name . '" content="' . htmlspecialchars($content, ENT_COMPAT, 'UTF-8') . '" />' . $lnEnd;
				}
				elseif ($type != 'http-equiv' && !empty($content))
				{
					$buffer .= $tab . '<meta ' . $type . '="' . $name . '" content="' . htmlspecialchars($content, ENT_COMPAT, 'UTF-8') . '" />' . $lnEnd;
				}
			}
		}

		// Don't add empty descriptions
		$documentDescription = $document->getDescription();

		if ($documentDescription)
		{
			$buffer .= $tab . '<meta name="description" content="' . htmlspecialchars($documentDescription, ENT_COMPAT, 'UTF-8') . '" />' . $lnEnd;
		}

		// Don't add empty generators
		$generator = $document->getGenerator();

		if ($generator)
		{
			$buffer .= $tab . '<meta name="generator" content="' . htmlspecialchars($generator, ENT_COMPAT, 'UTF-8') . '" />' . $lnEnd;
		}

		$buffer .= $tab . '<title>' . htmlspecialchars($document->getTitle(), ENT_COMPAT, 'UTF-8') . '</title>' . $lnEnd;

		// Generate link declarations
		foreach ($document->_links as $link => $linkAtrr)
		{
			$buffer .= $tab . '<link href="' . $link . '" ' . $linkAtrr['relType'] . '="' . $linkAtrr['relation'] . '"';

			if (is_array($linkAtrr['attribs']))
			{
				if ($temp = ArrayHelper::toString($linkAtrr['attribs']))
				{
					$buffer .= ' ' . $temp;
				}
			}

			$buffer .= ' />' . $lnEnd;
		}

        // Output the custom tags - array_unique makes sure that we don't output the same tags twice
		foreach (array_unique($document->_custom) as $custom)
		{
			$buffer .= $tab . $custom . $lnEnd;
		}

		return $buffer;
    }
}

class JDocumentRendererHtmlLotcss extends JDocumentRendererHtmlHead
{
	public function fetchHead($document)
	{
    	// Trigger the onBeforeCompileHead event
		$app = JFactory::getApplication();
		$app->triggerEvent('onBeforeCompileHead');

		// Get line endings
		$lnEnd  = $document->_getLineEnd();
		$tab    = $document->_getTab();
		$tagEnd = ' />';
		$buffer = '';
		
		$JUriRoot = JURI::root(true);
        unset($document->_styleSheets[$JUriRoot . '/media/system/css/modal.css']);
        unset($document->_styleSheets[$JUriRoot . '/media/jui/css/chosen.css']);
        
    	$defaultCssMimes = array('text/css');

		// Generate stylesheet links
		foreach ($document->_styleSheets as $strSrc => $strAttr)
		{
			$buffer .= $tab . '<link rel="stylesheet" href="' . $strSrc . '"';

			if (!is_null($strAttr['mime']) && (!$document->isHtml5() || !in_array($strAttr['mime'], $defaultCssMimes)))
			{
				$buffer .= ' type="' . $strAttr['mime'] . '"';
			}

			if (!is_null($strAttr['media']))
			{
				$buffer .= ' media="' . $strAttr['media'] . '"';
			}

			if (is_array($strAttr['attribs']))
			{
				if ($temp = ArrayHelper::toString($strAttr['attribs']))
				{
					$buffer .= ' ' . $temp;
				}
			}

			$buffer .= $tagEnd . $lnEnd;
		}

		// Generate stylesheet declarations
		foreach ($document->_style as $type => $content)
		{
			$buffer .= $tab . '<style';

			if (!is_null($type) && (!$document->isHtml5() || !in_array($type, $defaultCssMimes)))
			{
				$buffer .= ' type="' . $type . '"';
			}

			$buffer .= '>' . $lnEnd;

			// This is for full XHTML support.
			if ($document->_mime != 'text/html')
			{
				$buffer .= $tab . $tab . '/*<![CDATA[*/' . $lnEnd;
			}

			$buffer .= $content . $lnEnd;

			// See above note
			if ($document->_mime != 'text/html')
			{
				$buffer .= $tab . $tab . '/*]]>*/' . $lnEnd;
			}

			$buffer .= $tab . '</style>' . $lnEnd;
		}
		
		return $buffer;
    }
}

class JDocumentRendererHtmlLotjs extends JDocumentRendererHtmlHead
{
	public function fetchHead($document)
	{
    	// Trigger the onBeforeCompileHead event
		$app = JFactory::getApplication();
		$app->triggerEvent('onBeforeCompileHead');

		// Get line endings
		$lnEnd  = $document->_getLineEnd();
		$tab    = $document->_getTab();
		$tagEnd = ' />';
		$buffer = '';
		
		$JUriRoot = JURI::root(true);
        unset($document->_scripts[$JUriRoot . '/media/jui/js/jquery.min.js']);
        unset($document->_scripts[$JUriRoot . '/media/jui/js/chosen.jquery.min.js']);
        unset($document->_scripts[$JUriRoot . '/media/jui/js/jquery-noconflict.js']);
        unset($document->_scripts[$JUriRoot . '/media/jui/js/jquery-migrate.min.js']);
        unset($document->_scripts[$JUriRoot . '/media/system/js/modal.js']);
        unset($document->_scripts[$JUriRoot . '/media/system/js/validate.js']);
        unset($document->_scripts[$JUriRoot . '/media/system/js/punycode.js']);
        unset($document->_scripts[$JUriRoot . '/media/system/js/caption.js']);
        unset($document->_scripts[$JUriRoot . '/media/system/js/core.js']);
        unset($document->_scripts[$JUriRoot . '/media/system/js/mootools-core.js']);
        unset($document->_scripts[$JUriRoot . '/media/system/js/mootools-more.js']);


    	$defaultJsMimes = array('text/javascript', 'application/javascript', 'text/x-javascript', 'application/x-javascript');

		// Generate script file links
		foreach ($document->_scripts as $strSrc => $strAttr)
		{
			$buffer .= $tab . '<script src="' . $strSrc . '"';

			if (!is_null($strAttr['mime']) && (!$document->isHtml5() || !in_array($strAttr['mime'], $defaultJsMimes)))
			{
				$buffer .= ' type="' . $strAttr['mime'] . '"';
			}

			if ($strAttr['defer'])
			{
				$buffer .= ' defer="defer"';
			}

			if ($strAttr['async'])
			{
				$buffer .= ' async="async"';
			}

			$buffer .= '></script>' . $lnEnd;
		}

		// Generate scripts options
		$scriptOptions = $document->getScriptOptions();

		if (!empty($scriptOptions))
		{
			$buffer .= $tab . '<script type="text/javascript">' . $lnEnd;

			// This is for full XHTML support.
			if ($document->_mime != 'text/html')
			{
				$buffer .= $tab . $tab . '//<![CDATA[' . $lnEnd;
			}

			$pretyPrint  = (JDEBUG && defined('JSON_PRETTY_PRINT') ? JSON_PRETTY_PRINT : false);
			$jsonOptions = json_encode($scriptOptions, $pretyPrint);
			$jsonOptions = $jsonOptions ? $jsonOptions : '{}';

			// TODO: use .extend(Joomla.optionsStorage, options) when it will be safe
			$buffer .= $tab . 'var Joomla = Joomla || {};' . $lnEnd;
			$buffer .= $tab . 'Joomla.optionsStorage = ' . $jsonOptions . ';' . $lnEnd;

			// See above note
			if ($document->_mime != 'text/html')
			{
				$buffer .= $tab . $tab . '//]]>' . $lnEnd;
			}

			$buffer .= $tab . '</script>' . $lnEnd;
		}

		// Generate script declarations
		foreach ($document->_script as $type => $content)
		{
			$buffer .= $tab . '<script';

			if (!is_null($type) && (!$document->isHtml5() || !in_array($type, $defaultJsMimes)))
			{
				$buffer .= ' type="' . $type . '"';
			}

			$buffer .= '>' . $lnEnd;

			// This is for full XHTML support.
			if ($document->_mime != 'text/html')
			{
				$buffer .= $tab . $tab . '//<![CDATA[' . $lnEnd;
			}

			$buffer .= $content . $lnEnd;

			// See above note
			if ($document->_mime != 'text/html')
			{
				$buffer .= $tab . $tab . '//]]>' . $lnEnd;
			}

			$buffer .= $tab . '</script>' . $lnEnd;
		}

		// Generate script language declarations.
		if (count(JText::script()))
		{
			$buffer .= $tab . '<script';

			if (!$document->isHtml5())
			{
				$buffer .= ' type="text/javascript"';
			}

			$buffer .= '>' . $lnEnd;

			if ($document->_mime != 'text/html')
			{
				$buffer .= $tab . $tab . '//<![CDATA[' . $lnEnd;
			}

			$buffer .= $tab . $tab . '(function() {' . $lnEnd;
			$buffer .= $tab . $tab . $tab . 'Joomla.JText.load(' . json_encode(JText::script()) . ');' . $lnEnd;
			$buffer .= $tab . $tab . '})();' . $lnEnd;

			if ($document->_mime != 'text/html')
			{
				$buffer .= $tab . $tab . '//]]>' . $lnEnd;
			}

			$buffer .= $tab . '</script>' . $lnEnd;
		}
		
		return $buffer;

    }
}