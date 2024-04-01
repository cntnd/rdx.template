<?php
$dir = rex_path::assets('cymka/css/');

if (!is_dir($dir)) {
    mkdir($dir, 0755);
}

// get current file
$current = rex_request('file');

// create new file
if (!empty(rex_request('create'))) {
    $new_file = rex_request('create');
    if (!str_ends_with($new_file, ".css")) {
        $new_file .= ".css";
    }
    $current = $new_file;
    file_put_contents($dir . $current, '/*' . $new_file . '*/');
}

// remove file
if (!empty(rex_request('remove'))) {
    $new_file = rex_request('remove');
    var_dump($new_file);
}

// update file
if (!empty(rex_request('update'))) {
    $current = rex_request('update');
    $content = rex_request('cssinput');
    file_put_contents($dir . $current, $content);
}

echo '<div class="row">';

echo '<div class="col-sm-3">';
echo '<ul class="list-group">';
echo '<li class="list-group-item list-group-item-action">';
echo '<a href="#" data-toggle="collapse" data-target="#create_file" class="collapsed" aria-expanded="false"><i class="fa-solid fa-plus"></i> CSS-Datei erstellen</a>';

echo '<form action="' . rex_url::currentBackendPage() . '" method="POST">';
echo '<div class="collapse" id="create_file"><input type="text" name="create" required /><button type="submit">Erstellen</button></div>';
echo '</form>';

echo '</li>';

$files = scandir($dir, SCANDIR_SORT_ASCENDING);
foreach ($files as $file) {
    if (is_file($dir . $file) && str_ends_with($file, ".css")) {
        if (empty($current)) {
            $current = $file;
        }
        echo '<li class="list-group-item list-group-item-action"><a href="' . rex_url::currentBackendPage(['file' => $file]) . '">' . $file . '</a><a href="' . rex_url::currentBackendPage(['remove' => $file]) . '" class="badge text-bg-primary rounded-pill"><i class="fa-solid fa-trash"></i></a></li>';
    }
}
echo '</ul>';
echo '</div>';

echo '<div class="col-sm-8">';
echo '<form action="' . rex_url::currentBackendPage() . '" method="POST">';
?>
    <input type="hidden" name="update" value="<?= $current ?>"/>
    <textarea id="cssinput" class="aceeditor"
              name="cssinput"
              rows="10" cols="50" aceeditor-width="inherit" aceeditor-height="300px"
              aceeditor-mode="css"><?= file_get_contents($dir . $current) ?></textarea>
<?php

echo '<button>Speichern</button>';
echo '</form>';
echo '</div>';

echo '</div>';
?>