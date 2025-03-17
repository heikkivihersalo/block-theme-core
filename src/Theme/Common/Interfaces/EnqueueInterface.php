<?php
/**
 * The enqueue scripts interface.
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Common\Interfaces
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme\Common\Interfaces;

/**
 * The enqueue scripts interface.
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Common\Interfaces
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
interface EnqueueInterface {
	/**
	 * Check if the plugin's assets exist and display a notice if they don't
	 *
	 * @since    2.0.0
	 * @access   public
	 * @param    string $path The path to the asset
	 * @return   bool
	 */
	public static function asset_exists( string $path, string $type = '' ): bool;

	/**
	 * Register the stylesheets for the plugin.
	 *
	 * @since    2.0.0
	 * @access   public
	 * @param    string $asset_path   The path to the asset
	 * @param    string $style_url    The URL to the stylesheet
	 * @param    string $handle       The handle for the stylesheet
	 * @return   void
	 */
	public static function enqueue_style(): void;

	/**
	 * Register the scripts for the plugin.
	 *
	 * @since    2.0.0
	 * @access   public
	 * @param    string $asset_path   The path to the asset
	 * @param    string $script_url   The URL to the script
	 * @param    string $handle       The handle for the script
	 * @return   void
	 */
	public static function enqueue_script(): void;

	/**
	 * Run the editor scripts and styles
	 *
	 * @since    2.0.0
	 * @access   public
	 * @return   void
	 */
	public static function register(): void;
}
