<?php 

namespace Vihersalo\BlockThemeCore\Admin\Duplicate;

use Vihersalo\BlockThemeCore\Application;
use Vihersalo\BlockThemeCore\Application\HooksLoader;
use Vihersalo\BlockThemeCore\Admin\Duplicate\Helpers;
use Vihersalo\BlockThemeCore\Support\ServiceProvider;

class DuplicateProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     */
    public function register() {
        $this->enable_duplicate_posts();
    }

    /**
	 * Enable customizer
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function enable_duplicate_posts() {
        $this->app->make(HooksLoader::class)->add_action( 'admin_action_create_duplicate_post_as_draft', Helpers::class, 'create_duplicate_post_as_draft' );
		$this->app->make(HooksLoader::class)->add_filter( 'post_row_actions', Helpers::class, 'add_duplicate_post_link_to_admin', 10, 2 );
		$this->app->make(HooksLoader::class)->add_filter( 'page_row_actions', Helpers::class, 'add_duplicate_post_link_to_admin', 10, 2 );
		$this->app->make(HooksLoader::class)->add_action( 'admin_notices', Helpers::class, 'show_duplicate_admin_notice' );
	}

    /**
     * Boot the navigation provider
     */
    public function boot() {
    }
}