<?php

namespace Vihersalo\Core\Styles;

/**
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Analytics
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Scheme {
	/**
	 * Theme color
	 * @var string
	 */
	private string $theme_color;

	/**
	 * Dark mode
	 * @var bool
	 */
	private bool $dark_mode;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 * @param string $theme_color The theme color
	 * @param bool   $dark_mode The dark mode
	 * @return void
	 */
	public function __construct( string $theme_color = 'hsl(0, 0%, 20%)', bool $dark_mode = false ) {
		$this->theme_color = $theme_color;
		$this->dark_mode   = $dark_mode;
	}

	/**
	 * Inline theme color
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function inline_theme_color(): void {
		?>
		<meta name="theme-color" content="<?php echo $this->theme_color; ?>">
		<meta name="msapplication-navbutton-color" content="<?php echo $this->theme_color; ?>">
		<meta name="apple-mobile-web-app-status-bar-style" content="<?php echo $this->theme_color; ?>">
		<?php
	}
}
