<?php

/**
 * Hilfsfunktionen fuer rdx.theme.
 *
 * Theme- und Dateinamen stammen aus Benutzereingaben und werden zu
 * Dateipfaden zusammengesetzt. Ohne Pruefung liesse sich mit "../" aus dem
 * Theme-Ordner ausbrechen; deshalb werden nur einfache Namen zugelassen und
 * der fertige Pfad zusaetzlich gegen das Zielverzeichnis geprueft.
 */
final class rdx_theme
{
    /** Erlaubt: Buchstaben, Ziffern, Punkt, Unterstrich, Bindestrich - kein fuehrender Punkt. */
    private const NAME_PATTERN = '/^[A-Za-z0-9_][A-Za-z0-9._-]*$/';

    private function __construct()
    {
    }

    /**
     * Prueft einen einzelnen Pfadbestandteil (Theme- oder Dateiname).
     */
    public static function isValidName(?string $name): bool
    {
        $name = (string) $name;

        if ('' === $name || strlen($name) > 255) {
            return false;
        }

        if (str_contains($name, '..')) {
            return false;
        }

        return 1 === preg_match(self::NAME_PATTERN, $name);
    }

    /**
     * Prueft einen Dateinamen inkl. passender Endung (css/js).
     */
    public static function isValidFile(?string $file, string $mode): bool
    {
        $file = (string) $file;
        $suffix = '.' . $mode;

        if (!self::isValidName($file) || !str_ends_with($file, $suffix)) {
            return false;
        }

        return strlen($file) > strlen($suffix);
    }

    /**
     * Verzeichnis eines Themes inkl. abschliessendem Slash.
     */
    public static function getDir(string $theme, string $mode): string
    {
        return rex_path::assets($theme . '/' . $mode . '/');
    }

    /**
     * Vollstaendiger Pfad einer Datei innerhalb des Theme-Verzeichnisses
     * oder null, wenn der Name ungueltig ist bzw. ausserhalb liegen wuerde.
     */
    public static function getFilePath(string $dir, ?string $file, string $mode): ?string
    {
        if (!self::isValidFile($file, $mode)) {
            return null;
        }

        $path = $dir . $file;

        // Zweite Sicherung: der aufgeloeste Pfad muss im Theme-Ordner liegen.
        $realDir = realpath($dir);
        if (false === $realDir) {
            return null;
        }

        $realDir = rtrim(str_replace('\\', '/', $realDir), '/') . '/';
        $realFile = realpath($path);
        if (false !== $realFile) {
            $realFile = str_replace('\\', '/', $realFile);
            if (!str_starts_with($realFile, $realDir)) {
                return null;
            }
        }

        return $path;
    }
}
