<?php

namespace Vihersalo\Core\Admin\Duplicate;

use Vihersalo\Core\Application;
use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Admin\Duplicate\Utils;
use Vihersalo\Core\Support\ServiceProvider;

/**
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Admin\Duplicate
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
	 * @since    1.0.0
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
