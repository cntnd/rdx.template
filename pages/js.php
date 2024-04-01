<?php
$dir = rex_path::assets('cymka/js/');

if (!is_dir($dir)) {
    mkdir($dir, 0755);
}

$files = scandir($dir, SCANDIR_SORT_ASCENDING);
$js = [];

echo '<div class="row">';

echo '<div class="col-sm-3">';
echo '<ul class="list-group">';
foreach ($files as $file) {
    if (is_file($dir . $file) && str_ends_with($file, ".js")) {
        $js[] = $dir . $file;
        echo '<li class="list-group-item"><a href="">' . $file . '</a></li>';
    }
}
echo '</ul>';
echo '</div>';

echo '<div class="col-sm-8">';
?>
    <textarea id="jsinput" class="aceeditor"
              rows="10" cols="50" aceeditor-width="800px" aceeditor-height="300px" aceeditor-theme="chaos"
              aceeditor-mode="js"
              aceeditor-options='{"showLineNumbers": true, "showGutter": true}'></textarea>
<?php
echo '</div>';

echo '</div>';
