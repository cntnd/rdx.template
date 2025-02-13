<?php

$current = $this->current;
$dir = $this->dir;
$mode = $this->mode;

echo '<form action="' . rex_url::currentBackendPage() . '" method="POST" id="rdx.theme_form">';
echo '<div class="row">';

echo '<div class="col-sm-3">';
echo '<ul class="list-group">';
echo '<li class="list-group-item list-group-item-action">';
echo '<a href="#" class="alert_new_file" aria-expanded="false"><i class="fa-solid fa-plus"></i> Datei erstellen</a>';
echo '</li>';
$files = scandir($dir, SCANDIR_SORT_ASCENDING);
foreach ($files as $file) {
    if (is_file($dir . $file) && str_ends_with($file, "." . $this->mode)) {
        if (empty($current)) {
            $current = $file;
        }
        echo '<li class="list-group-item list-group-item-action"><a href="' . rex_url::currentBackendPage(['file' => $file]) . '">' . $file . '</a><a href="#" class="badge text-bg-primary rounded-pill alert_remove_file" data-file="' . $file . '"><i class="fa-solid fa-trash"></i></a></li>';
    }
}
echo '</ul>';
echo '</div>';

echo '<div class="col-sm-8">';
$content = "";
$disabled = "disabled";
if (!empty($current)) {
    $content = file_get_contents($dir . $current);
    $disabled = "";
}
?>
    <textarea id="input" class="aceeditor"
              name="input"
              rows="10" cols="50" aceeditor-width="100%" aceeditor-height="500px" aceeditor-theme="github"
              aceeditor-options='{"showLineNumbers": true, "showGutter": true}'
              aceeditor-mode="<?= $mode ?>"><?= $content ?></textarea>
<?php

echo '<button type="submit" '.$disabled.'>Speichern</button>';
echo '</div>';

echo '</div>';
echo '<input type="hidden" name="file" value="' . $current . '" id="rdx.theme_file" />';
echo '<input type="hidden" name="action" value="update" id="rdx.theme_action" />';
echo '</form>';