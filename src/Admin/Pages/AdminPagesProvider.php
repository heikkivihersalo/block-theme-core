<?php

namespace Vihersalo\BlockThemeCore\Admin;

use Vihersalo\BlockThemeCore\Application;
use Vihersalo\BlockThemeCore\Application\HooksLoader;
use Vihersalo\BlockThemeCore\Support\Utils\Common as Utils;
use Vihersalo\BlockThemeCore\Support\ServiceProvider;

use Vihersalo\BlockThemeCore\Admin\Pages\AdminPagesManager;

/**
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Admin
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class AdminPagesProvider extends ServiceProvider {
	/**
	 * Register the navigation provider
	 */
	public function register() {
		$this->register_admin_pages( $this->app->make( HooksLoader::class ) );
	}

	public function register_admin_pages( HooksLoader $loader ) {
		$pages = $this->app->make( 'config' )->get( 'app.admin_pages' );

		foreach ( $pages as $page ) :
			add_menu_page(
				$page->get_title(),
				$page->get_menu_title(),
				$page->get_capability(),
				$page->get_slug(),
				$page->get_callback(),
				$page->get_icon(),
				$page->get_position()
			);
		endforeach;
	}
}
