<?php

$dir = $this->dir;
$mode = $this->mode;

if (!is_dir($dir) && !rex_dir::create($dir)) {
    return;
}

$action = rex_post('action', 'string');

if ('' === $action) {
    return;
}

// Statusaendernde Aktionen nur mit gueltigem CSRF-Token
if (!rex_csrf_token::factory('rdx.theme_file')->isValid()) {
    echo rex_view::error(rex_i18n::msg('csrf_token_invalid'));
    return;
}

// create new file
if ("create" == $action) {
    $new_file = trim(rex_post('file', 'string'));
    if (!empty($new_file)) {
        if (!str_ends_with($new_file, "." . $mode)) {
            $new_file .= "." . $mode;
        }
        $path = rdx_theme::getFilePath($dir, $new_file, $mode);
        if (null === $path) {
            echo rex_view::error(rex_i18n::msg('rdx.theme_file_invalid'));
        } elseif (is_file($path)) {
            echo rex_view::error(rex_i18n::msg('rdx.theme_file_exists', $new_file));
        } else {
            $this->setVar('current', $new_file, false);
            rex_file::put($path, '/*' . $new_file . '*/');
        }
    }
}

// remove file
if ("remove" == $action) {
    $path = rdx_theme::getFilePath($dir, rex_post('file', 'string'), $mode);
    if (null !== $path && is_file($path)) {
        rex_file::delete($path);
    }
    $this->setVar('current', "", false);
}

// update file
if ("update" == $action) {
    $current = rex_post('file', 'string');
    $path = rdx_theme::getFilePath($dir, $current, $mode);
    if (null === $path || !is_file($path)) {
        echo rex_view::error(rex_i18n::msg('rdx.theme_file_invalid'));
        $this->setVar('current', "", false);
    } else {
        rex_file::put($path, rex_post('input', 'string'));
    }
}
