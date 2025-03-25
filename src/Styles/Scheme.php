<?php

declare(strict_types=1);

namespace Vihersalo\Core\Styles;

class Scheme {
    /**
     * Theme color
     * @var string
     */
    private string $themeColor;

    /**
     * Dark mode
     * @var bool
     */
    private bool $darkMode;

    /**
     * Constructor
     * @param string|null $themeColor The theme color
     * @param bool|null $darkMode The dark mode
     * @return void
     */
    public function __construct(string|null $themeColor, bool|null $darkMode) {
        $this->themeColor = $themeColor ?? '#000000';
        $this->darkMode   = $darkMode   ?? false;
    }

    /**
     * Inline theme color
     * @return void
     */
    public function inlineThemeColor(): void {
        ?>
        <meta name="theme-color" content="<?php echo $this->themeColor; ?>">
        <meta name="msapplication-navbutton-color" content="<?php echo $this->themeColor; ?>">
        <meta name="apple-mobile-web-app-status-bar-style" content="<?php echo $this->themeColor; ?>">
        <?php
    }
}
