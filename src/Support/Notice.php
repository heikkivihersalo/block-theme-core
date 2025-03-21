<?php
/**
 * The notice class.
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    Vihersalo\BlockThemeCore\Common
 */

namespace Vihersalo\BlockThemeCore\Support;

defined( 'ABSPATH' ) || die();

/**
 * The notice class.
 *
 * This class defines all code necessary to display a notice in admin area.
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Common
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Notice {
	/**
	 * The message
	 *
	 * @since    2.0.0
	 * @access   protected
	 * @var      string    $message    The message
	 */
	protected $message;

	/**
	 * Constructor
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function __construct( string $message ) {
		$this->message = $message;
	}

	/**
	 * Get the HTML for the notice
	 *
	 * @return void
	 */
	public function get_html() {
		echo '<div class="notice notice-error"><p>' . esc_html( $this->message ) . '</p></div>';
	}

	/**
	 * Display the notice
	 *
	 * @since    2.0.0
	 */
	public function display() {
		add_action( 'admin_notices', [ $this, 'get_html' ] );
	}
}
