<?php

/** @var rex_addon $this */

$csrf = rex_csrf_token::factory('rdx.theme_config');

if (rex_post('config-submit', 'boolean')) {
    if (!$csrf->isValid()) {
        echo rex_view::error(rex_i18n::msg('csrf_token_invalid'));
    } else {
        $config = rex_post('config', [['theme', 'string']]);
        $theme = trim((string) ($config['theme'] ?? ''));

        if ('' !== $theme && !rdx_theme::isValidName($theme)) {
            echo rex_view::error($this->i18n('theme_invalid'));
        } else {
            $this->setConfig(['theme' => $theme]);
            echo rex_view::success($this->i18n('saved'));
        }
    }
}

$theme = $this->getConfig('theme');

$fragment = new rex_fragment();

$content = '<div id="rdx.theme">
    <div class="row">
    <div class="form-group">
                <label class="col-sm-3 control-label">Theme</label>
                <div class="col-sm-9">
                    <input id="truncate_lines" class="form-control" name="config[theme]"
                           type="text" value="' . rex_escape($theme) . '" aria-describedby="theme-folder"/>
                    <div class="form-text" id="theme-folder">Es wird ein Ordner mit diesem Namen im Ordner "assets" erstellt. Erlaubt sind Buchstaben, Ziffern, Punkt, Unterstrich und Bindestrich.</div>
                </div>
            </div>
    </div>
    
    <button class="btn btn-save rex-form-aligned" type="submit" name="config-submit" value="1" ' . rex::getAccesskey($this->i18n('save'), 'save') . '>' . $this->i18n('save') . '</button>
</div>';

echo '<form action="' . rex_url::currentBackendPage() . '" method="POST" id="rdx.theme_theme">';
echo $csrf->getHiddenField();

$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');

echo '</form>';
