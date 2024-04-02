<?php
$dir = rex_path::assets('cymka/css/');

if (!is_dir($dir)) {
    mkdir($dir, 0755);
}

// get current file
$current = rex_request('file');

// create new file
if (rex_request('action') == "create") {
    $new_file = rex_request('file');
    if (!str_ends_with($new_file, ".css")) {
        $new_file .= ".css";
    }
    $current = $new_file;
    file_put_contents($dir . $current, '/*' . $new_file . '*/');
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
    $content = rex_request('cssinput');
    file_put_contents($dir . $current, $content);
}
?>
    <script>
        $(document).ready(function () {
            $(".alert_remove_file").click(function () {
                const file = $(this).data("file");
                const consent = confirm("Datei '" + file + "' löschen?");
                if (consent) {
                    $("#cntndTemplate_file").val(file);
                    $("#cntndTemplate_action").val("remove");
                    $("#cntndTemplate_form").submit();
                }
            });

            $(".alert_new_file").click(function () {
                const new_file = prompt("Bitte Dateiname eingeben:");
                if (new_file !== undefined && new_file !== "") {
                    $("#cntndTemplate_file").val(new_file);
                    $("#cntndTemplate_action").val("create");
                    $("#cntndTemplate_form").submit();
                } else {
                    alert("Kein Dateiname eingegeben");
                }
            });
        });
    </script>
<?php

echo '<form action="' . rex_url::currentBackendPage() . '" method="POST" id="cntndTemplate_form">';
echo '<div class="row">';

echo '<div class="col-sm-3">';
echo '<ul class="list-group">';
echo '<li class="list-group-item list-group-item-action">';
echo '<a href="#" class="alert_new_file" aria-expanded="false"><i class="fa-solid fa-plus"></i> CSS-Datei erstellen</a>';
echo '</li>';

$files = scandir($dir, SCANDIR_SORT_ASCENDING);
foreach ($files as $file) {
    if (is_file($dir . $file) && str_ends_with($file, ".css")) {
        if (empty($current)) {
            $current = $file;
        }
        echo '<li class="list-group-item list-group-item-action"><a href="' . rex_url::currentBackendPage(['file' => $file]) . '">' . $file . '</a><a href="#" class="badge text-bg-primary rounded-pill alert_remove_file" data-file="' . $file . '"><i class="fa-solid fa-trash"></i></a></li>';
    }
}
echo '</ul>';
echo '</div>';

echo '<div class="col-sm-8">';
$content="";
if (!empty($current)) {
    $content = file_get_contents($dir . $current);
}
?>
    <textarea id="cssinput" class="aceeditor"
              name="cssinput"
              rows="10" cols="50" aceeditor-width="100%" aceeditor-height="500px" aceeditor-theme="github"
              aceeditor-options='{"showLineNumbers": true, "showGutter": true}'
              aceeditor-mode="css"><?= $content ?></textarea>
<?php

echo '<button type="submit">Speichern</button>';
echo '</div>';

echo '</div>';
echo '<input type="hidden" name="file" value="' . $current . '" id="cntndTemplate_file" />';
echo '<input type="hidden" name="action" value="update" id="cntndTemplate_action" />';
echo '</form>';
?>