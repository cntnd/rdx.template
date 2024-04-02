<?php

$current = $this->current;
$dir = $this->dir;
$mode = $this->mode;

// create new file
if (rex_request('action') == "create") {
    $new_file = rex_request('file');
    if (!empty($new_file)) {
        if (!str_ends_with($new_file, "." . $mode)) {
            $new_file .= "." . $mode;
        }
        $this->current = $new_file;
        file_put_contents($dir . $new_file, '/*' . $new_file . '*/');
    }
}

// remove file
if (rex_request('action') == "remove") {
    $file = rex_request('file');
    if (is_file($dir . $file)) {
        unlink($dir . $file);
    }
    $this->current = "";
}

// update file
if (rex_request('action') == "update") {
    $current = rex_request('file');
    $content = rex_request('input');
    file_put_contents($dir . $current, $content);
}