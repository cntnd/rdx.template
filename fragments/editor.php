<?php

$dir = $this->dir;
$mode = $this->mode;

$current = $this->current;
if (!rdx_theme::isValidFile($current, $mode)) {
    $current = "";
}

echo '<form action="' . rex_url::currentBackendPage() . '" method="POST" id="rdx.theme_form">';
echo '<div class="row">';

echo '<div class="col-sm-3">';
echo '<ul class="list-group">';
echo '<li class="list-group-item list-group-item-action">';
echo '<a href="#" class="alert_new_file" aria-expanded="false"><i class="fa-solid fa-plus"></i> Datei erstellen</a>';
echo '</li>';
$files = is_dir($dir) ? scandir($dir, SCANDIR_SORT_ASCENDING) : false;
if (!is_array($files)) {
    $files = [];
}
foreach ($files as $file) {
    if (rdx_theme::isValidFile($file, $mode) && is_file($dir . $file)) {
        if (empty($current)) {
            $current = $file;
        }
        echo '<li class="list-group-item list-group-item-action"><a href="' . rex_url::currentBackendPage(['file' => $file]) . '">' . rex_escape($file) . '</a><a href="#" class="badge text-bg-primary rounded-pill alert_remove_file" data-file="' . rex_escape($file) . '"><i class="fa-solid fa-trash"></i></a></li>';
    }
}
echo '</ul>';
echo '</div>';

echo '<div class="col-sm-8">';
$content = "";
$disabled = "disabled";
$path = rdx_theme::getFilePath($dir, $current, $mode);
if (null !== $path && is_file($path)) {
    $content = (string) rex_file::get($path);
    $disabled = "";
} else {
    $current = "";
}
?>
    <textarea id="input" class="aceeditor"
              name="input"
              rows="10" cols="50" aceeditor-width="100%" aceeditor-height="500px" aceeditor-theme="github"
              aceeditor-options='{"showLineNumbers": true, "showGutter": true}'
              aceeditor-mode="<?= rex_escape($mode) ?>"><?= rex_escape($content) ?></textarea>
<?php

echo '<button type="submit" ' . $disabled . '>Speichern</button>';
echo '</div>';

echo '</div>';
echo '<input type="hidden" name="file" value="' . rex_escape($current) . '" id="rdx.theme_file" />';
echo '<input type="hidden" name="action" value="update" id="rdx.theme_action" />';
echo rex_csrf_token::factory('rdx.theme_file')->getHiddenField();
echo '</form>';
