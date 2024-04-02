<?php
$dir = rex_path::assets('cymka/css/');
$fragment = new rex_fragment();
$fragment->setVar('mode', 'css', false);
$fragment->setVar('dir', $dir, false);

if (!is_dir($dir)) {
    mkdir($dir, 0755);
}

// get current file
$current = rex_request('file');
$fragment->setVar('current', $current, false);

echo $fragment->parse('action.php');
echo $fragment->parse('alert.php');
echo $fragment->parse('editor.php');
?>