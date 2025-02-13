<link rel="stylesheet" type="text/css" href="<?= rex_addon::get('aceeditor')->getAssetsUrl('css/aceeditor.min.css') ?>"/>
<script src="<?= rex_addon::get('aceeditor')->getAssetsUrl('vendor/aceeditor/ace.js') ?>"></script>
<script src="<?= rex_addon::get('aceeditor')->getAssetsUrl('js/aceeditor.min.js') ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let aceTextAreas = document.querySelectorAll('textarea.aceeditor');
        if (aceTextAreas.length > 0) {
            for (var i = 0; i < aceTextAreas.length; i++) {
                let textArea = aceTextAreas[i];
                let editor = textAreaToAceEditor(textArea);
            }
        }
    });
</script>
<?php

/** @var rex_addon $this */
echo rex_view::title($this->i18n('title'));

include rex_be_controller::getCurrentPageObject()->getSubPath();