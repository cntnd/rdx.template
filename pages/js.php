<?php
$dir = rex_path::assets('cymka/js/');
$fragment = new rex_fragment();
$fragment->setVar('mode', 'js', false);
$fragment->setVar('dir', $dir, false);

if (!is_dir($dir)) {
    mkdir($dir, 0755);
}

// get current file
$current = rex_request('file');

// create new file
if (rex_request('action') == "create") {
    $new_file = rex_request('file');
    if (!empty($new_file)) {
        if (!str_ends_with($new_file, ".js")) {
            $new_file .= ".js";
        }
        $current = $new_file;
        file_put_contents($dir . $current, '/*' . $new_file . '*/');
    }
}

// remove file
if (rex_request('action') == "remove") {
    $file = rex_request('file');
    if (is_file($dir . $file)) {
        unlink($dir . $file);
    }
    $current = "";
}

// update file
if (rex_request('action') == "update") {
    $current = rex_request('file');
    $content = rex_request('input');
    file_put_contents($dir . $current, $content);
}

$fragment->setVar('current', $current, false);

echo $fragment->parse('alert.php');
echo $fragment->parse('editor.php');
?>