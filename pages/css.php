<?php

/** @var rex_addon $this */

$theme = trim((string) $this->getConfig('theme'));

if ('' === $theme) {
    echo rex_view::warning($this->i18n('theme_missing'));
    return;
}

$dir = rex_path::assets($theme . '/css/');

if (!is_dir($dir) && !rex_dir::create($dir)) {
    echo rex_view::error($this->i18n('dir_not_created', $dir));
    return;
}

$fragment = new rex_fragment();
$fragment->setVar('mode', 'css', false);
$fragment->setVar('dir', $dir, false);

// get current file
$current = rex_request('file');
$fragment->setVar('current', $current, false);

$content = $fragment->parse('action.php');
$content .= $fragment->parse('alert.php');
$content .= $fragment->parse('editor.php');

$fragment->setVar('heading', "CSS", false);
$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');
