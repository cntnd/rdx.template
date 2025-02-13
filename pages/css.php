<?php
$theme = $this->getConfig('theme');
$dir = rex_path::assets($theme.'/css/');
$fragment = new rex_fragment();
$fragment->setVar('mode', 'css', false);
$fragment->setVar('dir', $dir, false);

if (!is_dir($dir)) {
    mkdir($dir, 0755);
}

// get current file
$current = rex_request('file');
$fragment->setVar('current', $current, false);

$content = $fragment->parse('action.php');
$content .= $fragment->parse('alert.php');
$content .= $fragment->parse('editor.php');


$fragment->setVar('heading', "CSS", false);
$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');
?>