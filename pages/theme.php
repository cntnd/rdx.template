<?php

if (rex_post('config-submit', 'boolean')) {
    $this->setConfig(rex_post('config', [
        ['theme', 'string']
    ]));

    echo rex_view::success($this->i18n('saved'));
}

$theme = $this->getConfig('theme');

$fragment = new rex_fragment();

$content = '<div id="rdx.theme">
    <div class="row">
    <div class="form-group">
                <label class="col-sm-3 control-label">Theme</label>
                <div class="col-sm-9">
                    <input id="truncate_lines" class="form-control" name="config[theme]"
                           type="text" value="' . $theme . '" aria-describedby="theme-folder"/>
                    <div class="form-text" id="theme-folder">Es wird ein Ordner mit diesem Namen im Ordner "assets" erstellt.</div>
                </div>
            </div>
    </div>
    
    <button class="btn btn-save rex-form-aligned" type="submit" name="config-submit" value="1" ' . rex::getAccesskey($this->i18n('save'), 'save') . '>' . $this->i18n('save') . '</button>
</div>';


echo '<form action="' . rex_url::currentBackendPage() . '" method="POST" id="rdx.theme_theme">';

$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');

echo '</form>';
?>
