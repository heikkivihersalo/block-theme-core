<?php

namespace Vihersalo\BlockThemeCore\Admin\Duplicate;

use Vihersalo\BlockThemeCore\Application;
use Vihersalo\BlockThemeCore\Application\HooksLoader;
use Vihersalo\BlockThemeCore\Admin\Duplicate\Utils;
use Vihersalo\BlockThemeCore\Support\ServiceProvider;

/**
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Admin\Duplicate
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class DuplicateProvider extends ServiceProvider {
	/**
	 * Register the navigation provider
	 */
	public function register() {
		$this->enable_duplicate_posts( $this->app->make( HooksLoader::class ) );
	}

	/**
	 * Enable customizer
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function enable_duplicate_posts( HooksLoader $loader ) {
		$loader->add_action( 'admin_action_create_duplicate_post_as_draft', Utils::class, 'create_duplicate_post_as_draft' );
		$loader->add_filter( 'post_row_actions', Utils::class, 'add_duplicate_post_link_to_admin', 10, 2 );
		$loader->add_filter( 'page_row_actions', Utils::class, 'add_duplicate_post_link_to_admin', 10, 2 );
		$loader->add_action( 'admin_notices', Utils::class, 'show_duplicate_admin_notice' );
	}

	/**
	 * Boot the navigation provider
	 */
	public function boot() {
	}
}
