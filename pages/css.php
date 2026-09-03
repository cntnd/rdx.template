<?php

/** @var rex_addon $this */

$mode = 'css';
$theme = trim((string) $this->getConfig('theme'));

if ('' === $theme) {
    echo rex_view::warning($this->i18n('theme_missing'));
    return;
}

if (!rdx_theme::isValidName($theme)) {
    echo rex_view::error($this->i18n('theme_invalid'));
    return;
}

$dir = rdx_theme::getDir($theme, $mode);

if (!is_dir($dir) && !rex_dir::create($dir)) {
    echo rex_view::error($this->i18n('dir_not_created', $dir));
    return;
}

$fragment = new rex_fragment();
$fragment->setVar('mode', $mode, false);
$fragment->setVar('dir', $dir, false);

// get current file
$current = rex_request('file', 'string');
$fragment->setVar('current', $current, false);

$content = $fragment->parse('action.php');
$content .= $fragment->parse('alert.php');
$content .= $fragment->parse('editor.php');

$fragment->setVar('heading', "CSS", false);
$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');
