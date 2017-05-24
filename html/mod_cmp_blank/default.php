<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$url = JURI::base();

$tagenable = $params->get('tagenable');
$tag       = $params->get('tag');

$scriptenable = $params->get('scriptenable');
$script       = $params->get('script');

$scriptfileenable = $params->get('scriptfileenable');
$scriptfile       = $params->get('scriptfile');

$cssenable = $params->get('cssenable');
$css       = $params->get('css');

$csssheetenable = $params->get('csssheetenable');
$csssheet       = $params->get('csssheet');

$phpenable = $params->get('phpenable');
$php       = $params->get('phpcode');

$htmlenable = $params->get('htmlenable');
$html       = $params->get('htmlcode');

$stylecss    = $params->get('stylecss');
$idmodule    = $params->get('idmodule');
$classmodule = $params->get('classmodule');

$order = $params->get('codeorder');



$doc = JFactory::getDocument();
$content = "";

if ($tagenable == 1) {
    $doc->addCustomTag($tag);
}
if ($scriptenable == 1) {
    $doc->addScriptDeclaration($script, 'text/javascript');
}
if ($scriptfileenable == 1) {
    $scriptfile = explode("\n", $scriptfile);
    foreach ($scriptfile as $key => $value) {
        $value = trim($value);
        if (!empty($value)) {
            $doc->addScript($value);
        }
    }
}
if ($cssenable == 1) {
    $doc->addStyleDeclaration($css, 'text/css');
}
if ($csssheetenable == 1) {
    $csssheet = explode("\n", $csssheet);
    foreach ($csssheet as $key => $value) {
        $value = trim($value);
        if (!empty($value)) {
            $doc->addStyleSheet($value);
        }
    }
}
if ($stylecss != "") {
    $stylecss = "style=\"$stylecss\"";
}
if ($idmodule != "") {
    $idmodule = "id=\"$idmodule\"";
}
if ($classmodule != "") {
    $classmodule = "class=\"$classmodule\"";
}


if ($order == 0) {
    if ($htmlenable == 1) {
        $content .= $html;
    }
    if ($phpenable == 1) {
        ob_start();
        eval(' ?>'.$php.'<?php ');
        $content .= ob_get_clean();
    }
} else {
    if ($phpenable == 1) {
        ob_start();
        eval(' ?>'.$php.'<?php ');
        $content .= ob_get_clean();
    }
    if ($htmlenable == 1) {
        $content .= $html;
    }
}

if(!empty($content) && "$idmodule$classmodule$stylecss"!="")
        $content = "<div $idmodule $classmodule $stylecss>$content</div>";
?>