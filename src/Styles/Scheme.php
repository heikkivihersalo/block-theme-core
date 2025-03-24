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
     * @param string $themeColor The theme color
     * @param bool   $darkMode The dark mode
     * @return void
     */
    public function __construct(string $themeColor = 'hsl(0, 0%, 20%)', bool $darkMode = false) {
        $this->themeColor = $themeColor;
        $this->darkMode   = $darkMode;
    }

    /**
     * Inline theme color
     *
     * @since 1.0.0
     * @access public
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
